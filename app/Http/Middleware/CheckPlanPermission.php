<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPlanPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();
        if (!$user || !$user->hasPlanPermission($permission)) {
            abort(403, 'You do not have permission to access this feature.');
        }
        return $next($request);
    }
}