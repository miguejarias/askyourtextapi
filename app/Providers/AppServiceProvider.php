<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
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
