<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = auth()->user();

                if ($user->role == 'shop-owner' || $user->role == 'staff') {

                    $module = Module::find('Business');

                    if ($module) {
                        if ($module->isEnabled()) {
                            return redirect(route('business.dashboard.index'))->with('warning', 'You are already logged in!');
                        } else {
                            Auth::logout();
                            return redirect(route('login'))->with('warning', 'Web addon is not active.');
                        }
                    } else {
                        Auth::logout(); 
                        return redirect(route('login'))->with('warning', 'Web addon is not installed.');
                    }
                } else {

                    $role = Role::where('name', $user->role)->first();
                    $first_role = $role->permissions->pluck('name')->all()[0];
                    $page = explode('-', $first_role);
                    return redirect(route('admin.' . $page[0] . '.index'))->with('warning', 'You are already logged in!');

                }
            }
        }

        return $next($request);
    }
}
