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
        Schema::create('historical_temperature_models', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude', 14, 10);
            $table->decimal('longitude', 14, 10);
            $table->dateTime('date_time_of_measurement');
            $table->integer('temperature_2m');
            $table->timestamps();

            $table->unique(['latitude', 'longitude', 'date_time_of_measurement'], 'place_time_unique_temp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historical_temperature_models');
    }
};
