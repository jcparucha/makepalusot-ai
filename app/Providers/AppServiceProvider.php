<?php

namespace App\Providers;

use App\Contracts\Libraries\AiClientInterface;
use App\Libraries\Ai\GeminiClient;
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
        $this->app->bind(AiClientInterface::class, GeminiClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('generate', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
