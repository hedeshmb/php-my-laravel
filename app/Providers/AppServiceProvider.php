<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        View::share('site_name', config('app.name'));

        DB::enableQueryLog();
        DB::whenQueryingForLongerThan(10, function ($connection, $query) {
            Log::warning('Slow query details:', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'execution_time_ms' => $query->time,
                'connection' => $connection->getName(),
                'database' => $connection->getDatabaseName(),
                'url' => request()->url(),
                'request_method' => request()->method(),
                // 'user_id' => auth()->id,
                'timestamp' => now()->toDateTimeString(),
                // 'query_log' => $connection->getQueryLog()
            ]);
        });

        DB::disableQueryLog();
    }
}
