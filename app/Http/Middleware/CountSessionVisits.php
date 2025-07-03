<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CountSessionVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('visit_counted')) {
            Visit::create([
                'ip' => $request->ip(),
                'session_id' => Session::getId(),
                'visited_at' => now(),
            ]);
            Session::put('visit_counted', true);
        }

        return $next($request);
    }
}
