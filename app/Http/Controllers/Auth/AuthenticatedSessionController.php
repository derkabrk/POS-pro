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

        if ($user->role == 'shop-owner' || $user->role == 'staff') {

            $module = Module::find('Business');

            if ($module) {
                if ($module->isEnabled()) {

                    $redirect_url = route('business.dashboard.index');

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
