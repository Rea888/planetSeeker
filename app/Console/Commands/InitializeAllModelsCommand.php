<?php

namespace App\Console\Commands;

use App\Console\Commands\Cloudcover\CloudcoverInitializeCommand;
use App\Console\Commands\Humidity\HumidityInitializeCommand;
use App\Console\Commands\Shortwave_Radiation\ShortwaveRadiationInitializeCommand;
use App\Console\Commands\Surface_Pressure\SurfacePressureInitializeCommand;
use App\Console\Commands\Temperature\TemperatureInitializeCommand;
use App\Console\Commands\Windspeed\WindspeedInitializeCommand;
use Illuminate\Console\Command;
class InitializeAllModelsCommand extends Command
{
    protected $signature = 'models:initialize';

    protected $description = 'Save cities and dates in all processing_models_tables';

    public function handle()
    {
        $this->call(TemperatureInitializeCommand::class);
        $this->call(HumidityInitializeCommand::class);
        $this->call(SurfacePressureInitializeCommand::class);
        $this->call(CloudcoverInitializeCommand::class);
        $this->call(ShortwaveRadiationInitializeCommand::class);
        $this->call(WindspeedInitializeCommand::class);
    }
}
