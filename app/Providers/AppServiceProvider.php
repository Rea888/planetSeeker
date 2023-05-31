<?php

namespace App\Providers;

use App\ApiClient\Google\CoordinatesDataMapper;
use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\CloudcoverDataMapper;
use App\ApiClient\Meteo\HumidityDataMapper;
use App\ApiClient\Meteo\MeteoApiClient;
use App\ApiClient\Meteo\SurfacePressureDataMapper;
use App\ApiClient\Meteo\TemperatureDataMapper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(GoogleApiClient::class, function ($app) {
            return new GoogleApiClient(
                $app->make(CoordinatesDataMapper::class),
                config('services.google.base_url'),
                config('services.google.key')
            );
        });

        $this->app->bind(MeteoApiClient::class, function ($app) {
            return new MeteoApiClient(
                $app->make(TemperatureDataMapper::class),
                $app->make(HumidityDataMapper::class),
                $app->make(SurfacePressureDataMapper::class),
                $app->make(CloudcoverDataMapper::class),
                config('services.weather_api.base_url')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
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
