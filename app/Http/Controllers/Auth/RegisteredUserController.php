<?php

namespace App\Http\Controllers\Auth;

use App\Models\Plan;
use App\Models\User;
use App\Models\Business;
use App\Models\Currency;
use App\Mail\WelcomeMail;
use App\Models\UserCurrency;
use Illuminate\Http\Request;
use App\Models\PlanSubscribe;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\NewAccessToken;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;


class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'shopOpeningBalance' => 'nullable|numeric',
            'business_category_id' => 'required|exists:business_categories,id',
            'phoneNumber' => 'required|max:15',
            'email' => 'required|email|max:255',
            'password' => 'required|max:25',
            'invite_code' => 'nullable|string|exists:invite_codes,code',
        ]);

        DB::beginTransaction();
        try {
            // Find free plan
            $free_plan = Plan::where('subscriptionPrice', '<=', 0)
                ->orWhere('offerPrice', '<=', 0)
                ->first();

            // Create business
            $business = Business::create([
                'address' => $request->address,
                'companyName' => $request->companyName,
                'phoneNumber' => $request->phoneNumber,
                'subscriptionDate' => $free_plan ? now() : null,
                'shopOpeningBalance' => $request->shopOpeningBalance ?? 0,
                'business_category_id' => $request->business_category_id,
                'will_expire' => $free_plan ? now()->addDays($free_plan->duration) : null,
            ]);

            $currency = Currency::where('is_default', 1)->first();
            UserCurrency::create([
                'name' => $currency->name,
                'code' => $currency->code,
                'rate' => $currency->rate,
                'business_id' => $business->id,
                'symbol' => $currency->symbol,
                'currency_id' => $currency->id,
                'position' => $currency->position,
                'country_name' => $currency->country_name,
            ]);

            // Check email association
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return response()->json([
                    'message' => 'This email is already associated with a business.',
                ], 406);
            }

            // Create user
            $user = User::create([
                'business_id' => $business->id,
                'phone' => $request->phoneNumber,
                'name' => $business->companyName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign free plan if available
            if ($free_plan) {
                $subscribe = PlanSubscribe::create([
                    'plan_id' => $free_plan->id,
                    'business_id' => $business->id,
                    'duration' => $free_plan->duration,
                ]);

                $business->update([
                    'plan_subscribe_id' => $subscribe->id,
                ]);
            }

            // Invite code logic
            if ($request->filled('invite_code')) {
                $invite = \Modules\Business\App\Models\InviteCode::where('code', $request->invite_code)->first();
                if ($invite) {
                    if ($invite->used) {
                        return response()->json([
                            'message' => 'This invite code has already been used.',
                        ], 406);
                    }
                    if ($invite->expires_at && $invite->expires_at->isPast()) {
                        return response()->json([
                            'message' => 'This invite code has expired.',
                        ], 406);
                    }
                    $invite->update([
                        'used' => true,
                        'used_by' => $user->id,
                    ]);
                    // Add points to the inviter
                    if ($invite->created_by && ($inviter = \App\Models\User::find($invite->created_by))) {
                        // Fetch points_per_invite from general settings
                        $pointsPerInvite = 10;
                        $generalOption = \App\Models\Option::where('key', 'general')->first();
                        if ($generalOption && isset($generalOption->value['points_per_invite'])) {
                            $pointsPerInvite = (int) $generalOption->value['points_per_invite'];
                        }
                        $inviter->increment('points', $pointsPerInvite); // Add dynamic points per invite
                    }
                }
            }

            // Generate OTP
            $code = random_int(100000, 999999);
            $visibility_time = env('OTP_VISIBILITY_TIME', 3);
            $expire = now()->addSeconds($visibility_time * 60);

            $data = [
                'code' => $code,
                'name' => $request->companyName,
            ];

            $user->update([
                'remember_token' => $code,
                'email_verified_at' => $expire,
            ]);

            // Send welcome mail
            if (env('MAIL_USERNAME')) {
                if (env('QUEUE_MAIL')) {
                    Mail::to($request->email)->queue(new RegistrationMail($data));
                } else {
                    Mail::to($request->email)->send(new RegistrationMail($data));
                }
            } else {
                return response()->json([
                    'message' => 'Mail service is not configured. Please contact your administrator.',
                ], 406);
            }

            DB::commit();

            return response()->json([
                'message' => 'An OTP code has been sent to your email. Please check and confirm.',
                'openModal' => true,
                'email' => $request->email,
                'otp_expiration' => now()->diffInSeconds($expire),
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();

            // Log the exception for debugging
            \Log::error('Error in RegisteredUserController@store:', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Something went wrong. Please contact the admin.',
            ], 403);
        }
    }

    public function otpResend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $code = random_int(100000, 999999);
        $visibility_time = env('OTP_VISIBILITY_TIME', 3);
        $expire = now()->addSeconds($visibility_time * 60);

        $data = [
            'code' => $code,
            'name' => $request->name,
        ];

        if (env('MAIL_USERNAME')) {
            if (env('QUEUE_MAIL')) {
                Mail::to($request->email)->queue(new WelcomeMail($data));
            } else {
                Mail::to($request->email)->send(new WelcomeMail($data));
            }
        } else {
            return response()->json([
                'message' => __('Mail service is not configured. Please contact your administrator.'),
            ], 406);
        }

        User::where('email', $request->email)->first()->update(['remember_token' => $code, 'email_verified_at' => $expire]);

        return response()->json([
            'message' => 'An otp code has been sent to your email. Please check and confirm.',
            'otp_expiration' => now()->diffInSeconds($expire),
        ]);
    }

    public function otpSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|min:4|max:15',
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => __('User not found.')], 400);
        }

        // Check if the OTP matches
        if ($user->remember_token !== $request->otp) {
            return response()->json(['message' => __('Invalid OTP.')], 400);
        }

        // Check if the OTP has expired
        if ($user->email_verified_at <= now()) {
            return response()->json(['message' => __('The verification OTP has expired.')], 400);
        }

        // OTP is valid and not expired
        if (Module::find('Business')) {
            Auth::login($user);

            // Clear the OTP and mark the email as verified
            $user->update([
                'remember_token' => null,
                'email_verified_at' => now(),
            ]);

            return response()->json([
                'message' => 'Logged in successfully!',
                'redirect' => route('business.dashboard.index'),
            ]);
        } else {
            Auth::logout();
            return response()->json([
                'message' => 'The business module is not installed.',
            ], 406);
        }
    }

    protected function setAccessTokenExpiration(NewAccessToken $accessToken)
    {
        $expiration = now()->addMinutes(Config::get('sanctum.expiration'));

        DB::table('personal_access_tokens')
            ->where('id', $accessToken->accessToken->id)
            ->update(['expires_at' => $expiration]);
    }

}
