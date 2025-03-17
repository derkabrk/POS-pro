<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Currency;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\NewAccessToken;
use App\Http\Controllers\Controller;
use App\Models\UserCurrency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|max:100',
            'email' => 'required|email',
        ]);

        $code = random_int(100000, 999999);
        $expire = now()->addMinutes(env('OTP_VISIBILITY_TIME') ?? 3);
        $data = [
            'code' => $code,
            'name' => $request->name,
        ];

        $user = User::where('email', $request->email)->first();
        if ($user && $user->business_id) {
            return response()->json([
                'message' => 'This email is already exists.',
            ], 406);
        }

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

        $user = User::updateOrCreate(['email' => $request->email], $request->except('password') + [
                    'remember_token' => $code,
                    'email_verified_at' => $expire,
                    'password' => Hash::make($request->password),
                ]);

        return response()->json([
            'message' => 'An otp code has been sent to your email. Please check and confirm.',
            'data' => $user,
        ]);
    }

    public function submitOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|min:4|max:15',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => __('User not found'),
            ], 404);
        }

        if ($user->remember_token == $request->otp) {
            if ($user->email_verified_at > now()) {

                Auth::login($user);
                $is_setup = $user->business_id ? true : false;
                $token = $user->createToken('createToken')->plainTextToken;
                $accessToken = $user->createToken('createToken');
                $this->setAccessTokenExpiration($accessToken);

                $user->update([
                    'remember_token' => NULL,
                    'email_verified_at' => now(),
                ]);

                $currency = Currency::select('id', 'name', 'code', 'symbol', 'position')->where('is_default', 1)->first();

                return response()->json([
                    'message' => 'Logged In successfully!',
                    'is_setup' => $is_setup,
                    'token' => $token,
                    'currency' => $currency,
                ]);

            } else {
                return response()->json([
                    'error' => __('The verification otp has been expired.')
                ], 400);
            }
        } else {
            return response()->json([
                'error' => __('Invalid otp.')
            ], 404);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();

            if ($user->role != 'staff' && $user->role != 'shop-owner') {
                return response()->json([
                    'message' => 'You can not login as ' .$user->role. ' from the app!'
                ], 406);
            }

            if ($user->remember_token && !$user->business_id) { // If user didn't verify email

                $code = random_int(100000, 999999);
                $expire = now()->addMinutes(env('OTP_VISIBILITY_TIME') ?? 3);
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
                ], 201);
            }

            $currency = UserCurrency::select('id', 'name', 'code', 'symbol', 'position')->where('business_id', $user->business_id)->first();

            return response()->json([
                'message' => 'User login successfully!',
                'data' => [
                    'message' => 'Logged In successfully!',
                    'is_setup' => $user->business_id ? true : false,
                    'token' => $user->createToken('createToken')->plainTextToken,
                    'currency' => $currency ?? Currency::select('id', 'name', 'code', 'symbol', 'position')->where('is_default', 1)->first(),
                ],
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid email or password!'
            ], 404);
        }
    }

    protected function setAccessTokenExpiration(NewAccessToken $accessToken)
    {
        $expiration = now()->addMinutes(Config::get('sanctum.expiration'));

        DB::table('personal_access_tokens')
            ->where('id', $accessToken->accessToken->id)
            ->update(['expires_at' => $expiration]);
    }

    public function signOut() : JsonResponse
    {
        $currentToken = auth()->user()->currentAccessToken();

        if ($currentToken) {
            $currentToken->delete();

            return response()->json([
                'message' => __('Sign out successfully'),
            ]);
        } else {
            return response()->json([
                'message' => __('Unauthorized'),
            ], 401);
        }
    }

    public function refreshToken()
    {
        if (auth()->user()->tokens()) {

            auth()->user()->currentAccessToken()->delete();
            $data['token'] = auth()->user()->createToken('createToken')->plainTextToken;
            return response()->json($data);

        } else {
            return response()->json([
                'message' => __('Unauthorized'),
            ], 401);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $code = random_int(100000, 999999);
        $expire = now()->addMinutes(env('OTP_VISIBILITY_TIME') ?? 3);
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
        ]);
    }
}
