<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('DEMO_MODE', false)) {
            $disabledRoutes = [
                'admin.users.delete-all',
                'admin.system-settings.store',
                'admin.business.update',
                'admin.business.destroy',
                'admin.business.delete-all',
                'admin.addons.show',
                'business.profiles.update',
            ];

            $except_role = ['superadmin', 'admin', 'user'];
            $except_email = ['superadmin@superadmin.com', 'admin@admin.com', 'user@user.com'];
            $response = response()->json(['message' => 'This action is disabled in demo mode.'], 403);

            if (in_array(Route::currentRouteName(), $disabledRoutes)) {
                return $response;
            } elseif (in_array(Route::currentRouteName(), ['admin.profiles.update', 'admin.users.update', 'admin.users.destroy'])) {
                if ($request->route('profile')) {
                    $user = User::findOrFail($request->route('profile'));
                } else {
                    $user = $request->route('user');
                }

                if (in_array($user->email, $except_email)) {
                    return $response;
                }
            } elseif (Route::currentRouteName() == 'admin.roles.update') {
                $role = $request->route('role')->name;

                if (in_array($role, $except_role)) {
                    return $response;
                }
            }
        }

        return $next($request);
    }
}
