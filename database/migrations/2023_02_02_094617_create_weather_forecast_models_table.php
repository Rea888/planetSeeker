<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_forecast_models', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude',14,10);
            $table->decimal('longitude', 14,10);
            $table->dateTime('date_time_of_measurement');
            $table->decimal('temperature');
            $table->timestamps();

            $table->unique(['latitude', 'longitude', 'date_time_of_measurement'], 'place_time_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_forecast_models');
    }
};
