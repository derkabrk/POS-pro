<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use Spatie\Permission\Models\Role;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtpMail;
use App\Mail\LoginMail;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        $business_categories = BusinessCategory::latest()->get();
        return view('auth.login', compact('business_categories'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $remember = $request->filled('remember') ? 1 : 0;
        $user = auth()->user();

        // Check if the user is a shop-owner or staff
        if ($user->role == 'shop-owner' || $user->role == 'staff') {
            $module = Module::find('Business');

            if ($module && $module->isEnabled()) {
                // Generate OTP and send email
                $code = random_int(100000, 999999); // Generate a 6-digit OTP
                $visibility_time = env('OTP_VISIBILITY_TIME', 3); // Default to 3 minutes
                $expire = now()->addSeconds($visibility_time * 60);

                $data = [
                    'code' => $code,
                    'name' => $user->name,
                ];

                // Update the user's OTP and expiration time
                $user->update([
                    'remember_token' => $code,
                    'email_verified_at' => $expire,
                ]);

                // Send OTP via email
                if (env('MAIL_USERNAME')) {
                    if (env('QUEUE_MAIL')) {
                        Mail::to($user->email)->queue(new LoginOtpMail($data));
                    } else {
                        Mail::to($user->email)->send(new LoginOtpMail($data));
                    }
                } else {
                    Auth::logout();
                    return response()->json([
                        'message' => __('Mail service is not configured. Please contact your administrator.'),
                    ], 406);
                }

                // Return response with openModal key
                return response()->json([
                    'message' => 'An OTP code has been sent to your email. Please check and confirm.',
                    'otp_expiration' => now()->diffInSeconds($expire),
                    'otp_required' => true, // Indicate OTP is required
                    'openModal' => true, // Trigger OTP modal on frontend
                ]);
            } else {
                Auth::logout();
                return response()->json([
                    'message' => $module ? 'Web addon is not active.' : 'Web addon is not installed.',
                ], 406);
            }
        } else {
            // Handle other roles
            $role = Role::where('name', $user->role)->first();
            $first_role = $role->permissions->pluck('name')->all()[0];
            $page = explode('-', $first_role);
            $redirect_url = route('admin.' . $page[0] . '.index');

            return response()->json([
                'message' => __('Logged In Successfully'),
                'remember' => $remember,
                'redirect' => $redirect_url,
            ]);
        }
    }

    /**
     * Resend OTP to the user's email.
     */
    public function otpResend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $code = random_int(100000, 999999);
        $visibility_time = env('OTP_VISIBILITY_TIME', 3); // Default to 3 minutes
        $expire = now()->addSeconds($visibility_time * 60);

        $data = [
            'code' => $code,
            'name' => User::where('email', $request->email)->first()->name,
        ];

        // Send OTP via email
        if (env('MAIL_USERNAME')) {
            if (env('QUEUE_MAIL')) {
                Mail::to($request->email)->queue(new LoginOtpMail($data));
            } else {
                Mail::to($request->email)->send(new LoginOtpMail($data));
            }
        } else {
            return response()->json([
                'message' => __('Mail service is not configured. Please contact your administrator.'),
            ], 406);
        }

        // Update the user's OTP and expiration time
        User::where('email', $request->email)->first()->update([
            'remember_token' => $code,
            'email_verified_at' => $expire,
        ]);

        return response()->json([
            'message' => 'An OTP code has been sent to your email. Please check and confirm.',
            'otp_expiration' => now()->diffInSeconds($expire),
        ]);
    }

    /**
     * Submit OTP for verification.
     */
    public function otpSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|min:4|max:6',
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
            return response()->json(['message' => __('The OTP has expired.')], 400);
        }

        // OTP is valid, clear the OTP and log the user in
        Auth::login($user);
        $user->update([
            'remember_token' => null,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'message' => 'Logged in successfully!',
            'redirect' => route('business.dashboard.index'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Set the access token expiration.
     */
    protected function setAccessTokenExpiration(NewAccessToken $accessToken)
    {
        $expiration = now()->addMinutes(config('sanctum.expiration', 120)); // Default to 120 minutes if not set
        DB::table('personal_access_tokens')
            ->where('id', $accessToken->accessToken->id)
            ->update(['expires_at' => $expiration]);
    }
}