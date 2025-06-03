<?php

namespace Modules\Business\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureDropshipperRegistered
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        // Check if user is a dropshipper (by role or relationship)
        if ($user && (method_exists($user, 'isDropshipper') ? $user->isDropshipper() : ($user->role === 'dropshipper' || $user->type === 'dropshipper'))) {
            $dropshipper = $user->dropshipper ?? null;
            if ($dropshipper && !$dropshipper->is_registered) {
                return redirect()->route('dropshipper.registration');
            }
        }
        return $next($request);
    }
}
