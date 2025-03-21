<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TokenExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->tokens ?? false) {
            $token = auth()->user()->tokens->last();
            if ($token && $token->expires_at <= now()) {
                $token->delete();
                return response()->json('Token has expired.', 401);
            }
        } else {
            return response()->json('Token not available.', 401);
        }

        return $next($request);
    }
}
