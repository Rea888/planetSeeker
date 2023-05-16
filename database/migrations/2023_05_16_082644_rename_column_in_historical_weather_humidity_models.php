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
        Schema::table('historical_weather_humidity_models', function (Blueprint $table) {
            $table->renameColumn('relative_humidity_2m', 'relativehumidity_2m');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historical_weather_humidity_models', function (Blueprint $table) {
            //
        });
    }
};
