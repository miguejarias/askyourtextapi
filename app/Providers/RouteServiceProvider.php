<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('ai-requests', function (Request $request) {
            return [
                // 5 requests per minute per user (if authenticated)
                Limit::perMinute(10)->by($request->user()?->id ?: $request->ip()),
                // 25 requests per day per user
                Limit::perDay(50)->by($request->user()?->id ?: $request->ip()),
            ];
        });
    }
}
