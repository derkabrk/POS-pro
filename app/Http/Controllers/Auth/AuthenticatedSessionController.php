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
use App\Mail\LoginOtpMain;
use App\Mail\LoginMail;
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
        $redirect_url = url('/');
        $user = auth()->user();

        // Check if the user is a shop-owner or staff
        if ($user->role == 'shop-owner' || $user->role == 'staff') {
            $module = Module::find('Business');

            if ($module) {
                if ($module->isEnabled()) {
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
                            Mail::to($user->email)->queue(new LoginOtpMain($data));
                        } else {
                            Mail::to($user->email)->send(new LoginOtpMain($data));
                        }
                    } else {
                        Auth::logout();
                        return response()->json([
                            'message' => __('Mail service is not configured. Please contact your administrator.'),
                            'redirect' => route('login'),
                        ], 406);
                    }

                    return response()->json([
                        'message' => 'An OTP code has been sent to your email. Please check and confirm.',
                        'otp_expiration' => now()->diffInSeconds($expire),
                    ]);
                } else {
                    Auth::logout();
                    return response()->json([
                        'message' => 'Web addon is not active.',
                        'redirect' => route('login'),
                    ], 406);
                }
            } else {
                Auth::logout();
                return response()->json([
                    'message' => 'Web addon is not installed.',
                    'redirect' => route('login'),
                ], 406);
            }
        } else {
            // Handle other roles
            $role = Role::where('name', $user->role)->first();
            $first_role = $role->permissions->pluck('name')->all()[0];
            $page = explode('-', $first_role);
            $redirect_url = route('admin.' . $page[0] . '.index');
        }

        return response()->json([
            'message' => __('Logged In Successfully'),
            'remember' => $remember,
            'redirect' => $redirect_url,
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
}
