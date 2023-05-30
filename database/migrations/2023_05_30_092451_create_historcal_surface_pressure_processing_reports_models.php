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
        Schema::create('historical_surface_pressure_processing_reports_models', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('month');
            $table->string('city');
            $table->dateTime('processing_began_at')->nullable();
            $table->dateTime('processing_finished_at')->nullable();
            $table->timestamps();

            $table->unique(['year', 'month', 'city'], 'city_date_processing_unique_surface_pressure_process');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historical_surface_pressure_processing_reports_models');
    }
};
