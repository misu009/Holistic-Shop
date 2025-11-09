<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class CountRedisVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uniqueId = hash('sha256', $request->ip() . $request->userAgent());
        $today = now()->toDateString();
        $dailySetKey = "unique_visitors:{$today}";

        // Add the visitor to the Redis set (duplicates automatically ignored)
        Redis::sadd($dailySetKey, $uniqueId);

        // Set expiration to 30 days to keep only last 30 days of data
        Redis::expire($dailySetKey, 60 * 60 * 24 * 30);

        return $next($request);
    }
}