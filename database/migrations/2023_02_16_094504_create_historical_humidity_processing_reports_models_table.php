<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historical_humidity_processing_reports_models', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('month');
            $table->string('city');
            $table->dateTime('processing_began_at')->nullable();
            $table->dateTime('processing_finished_at')->nullable();
            $table->timestamps();

            $table->unique(['year', 'month', 'city'], 'city_date_processing_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historical_humidity_processing_reports_models');
    }
};