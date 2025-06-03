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
use Laravel\Socialite\Facades\Socialite;

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

        // Dropshipper registration check
        if ($user->role === 'dropshipper') {
            // If user relation is not loaded, eager load it
            if (!isset($user->dropshipper)) {
                $user->load('dropshipper');
            }
            if (!$user->dropshipper || !$user->dropshipper->is_registered) {
                return response()->json([
                    'message' => __('Please complete your registration.'),
                    'redirect' => route('dropshipper.registration'),
                ]);
            }
        }

        // Check if the user is a shop-owner or staff
        if ($user->role == 'shop-owner' || $user->role == 'staff') {
            $module = Module::find('Business');

            if ($module && $module->isEnabled()) {
                // Directly redirect the user to the dashboard
                return response()->json([
                    'message' => __('Logged In Successfully'),
                    'redirect' => route('business.dashboard.index'),
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
            if ($role && $role->permissions->count() > 0) {
                $first_role = $role->permissions->pluck('name')->all()[0];
                $page = explode('-', $first_role);
                $redirect_url = route('admin.' . $page[0] . '.index');
            } elseif ($user->role === 'dropshipper') {
                // Redirect dropshipper to a dropshipper dashboard or home
                $redirect_url = route('business.dropshipper.dashboard');
            } else {
                // Fallback redirect if role or permissions are missing
                $redirect_url = route('home'); // or any default route you prefer
            }

            return response()->json([
                'message' => __('Logged In Successfully'),
                'remember' => $remember,
                'redirect' => $redirect_url,
            ]);
        }
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google and sign in or register the user.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Find user by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Register new user if not exists
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(str()->random(16)), // random password
                    // Add other fields as needed
                ]);
            }

            Auth::login($user, true);

            // You can adapt the redirect logic from store()
            if ($user->role == 'shop-owner' || $user->role == 'staff') {
                $module = Module::find('Business');
                if ($module && $module->isEnabled()) {
                    return redirect()->route('business.dashboard.index');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'email' => $module ? 'Web addon is not active.' : 'Web addon is not installed.',
                    ]);
                }
            } else {
                $role = Role::where('name', $user->role)->first();
                $first_role = $role ? $role->permissions->pluck('name')->first() : null;
                $page = $first_role ? explode('-', $first_role) : ['dashboard'];
                $redirect_url = route('admin.' . $page[0] . '.index');
                return redirect($redirect_url);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Google authentication failed.']);
        }
    }

    /**
     * Redirect the user to the Facebook authentication page.
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle callback from Facebook and sign in or register the user.
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(str()->random(16)),
                    // Add other fields as needed
                ]);
            }

            Auth::login($user, true);

            // Adapt redirect logic as in store()
            if ($user->role == 'shop-owner' || $user->role == 'staff') {
                $module = Module::find('Business');
                if ($module && $module->isEnabled()) {
                    return redirect()->route('business.dashboard.index');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'email' => $module ? 'Web addon is not active.' : 'Web addon is not installed.',
                    ]);
                }
            } else {
                $role = Role::where('name', $user->role)->first();
                $first_role = $role ? $role->permissions->pluck('name')->first() : null;
                $page = $first_role ? explode('-', $first_role) : ['dashboard'];
                $redirect_url = route('admin.' . $page[0] . '.index');
                return redirect($redirect_url);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Facebook authentication failed.']);
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

        // Mark OTP as verified in the session
        $request->session()->put('otp_verified', true);

        // Send Login Email Alert
        if (env('MAIL_USERNAME')) {
            $loginDetails = [
                'name' => $user->name,
                'ip_address' => $request->ip(),
                'time' => now()->toDateTimeString(),
                'device' => $request->header('User-Agent'),
            ];

            Mail::to($user->email)->queue(new LoginMail($loginDetails));
        }

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