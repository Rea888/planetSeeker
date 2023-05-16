<?php

namespace App\Providers;

use App\Repository\LongitudeLatitudeRepository;
use App\Service\ApiWeatherClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiWeatherClient::class, function ($app) {
            return new ApiWeatherClient(
                config('services.weather_api.base_url'),
                $app->make(LongitudeLatitudeRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        DB::listen(function ($query) {
//            Log::info(
//                $query->sql,
//                $query->bindings,
//                $query->time
//            );
//        });
    }
}
