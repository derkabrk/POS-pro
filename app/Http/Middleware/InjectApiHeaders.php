<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DynamicApiHeader;

class InjectApiHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Retrieve active API headers
        $apiHeaders = DynamicApiHeader::where('status', true)->get();

        // Share the headers with all views
        view()->share('apiHeaders', $apiHeaders);

        return $next($request);
    }
}