<?php

namespace App\Providers;

use App\Models\Workspace;
use App\Policies\WorkspacePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;

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
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        // });

        // RateLimiter::for('global', function (Request $request) {
        //     return Limit::perMinute(1000)->response(function (Request $request, array $headers) {
        //         return response('Custom response...', 429, $headers);
        //     });
        // });

        // RateLimiter::for('uploads', function (Request $request) {
        //     return $request->user()->vipCustomer()
        //                 ? Limit::none()
        //                 : Limit::perMinute(100);
        // });

        // RateLimiter::for('uploads', function (Request $request) {
        //     return $request->user()->vipCustomer()
        //                 ? Limit::none()
        //                 : Limit::perMinute(100)->by($request->ip());
        // });

        // RateLimiter::for('uploads', function (Request $request) {
        //     return $request->user()
        //                 ? Limit::perMinute(100)->by($request->user()->id)
        //                 : Limit::perMinute(10)->by($request->ip());
        // });
    }
}
