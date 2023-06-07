<?php

namespace App\Console\Commands;

use App\Console\Commands\Cloudcover\CloudcoverFinishQueueCommand;
use App\Console\Commands\Humidity\HumidityFinishQueueCommand;
use App\Console\Commands\Rain\RainFinishQueueCommand;
use App\Console\Commands\Snowfall\SnowfallFinishQueueCommand;
use App\Console\Commands\Shortwave_Radiation\ShortwaveRadiationFinishQueueCommand;
use App\Console\Commands\Surface_Pressure\SurfacePressureFinishQueueCommand;
use App\Console\Commands\Temperature\TemperatureFinishQueueCommand;
use App\Console\Commands\Windspeed\WindspeedFinishQueueCommand;
use Illuminate\Console\Command;

class FinishQueueAllModelsCommand extends Command
{
    protected $signature = 'models:finishQueue';

    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its historical_* database';

    public function handle()
    {
        $this->call(TemperatureFinishQueueCommand::class);
        $this->call(HumidityFinishQueueCommand::class);
        $this->call(SurfacePressureFinishQueueCommand::class);
        $this->call(RainFinishQueueCommand::class);
        $this->call(SnowfallFinishQueueCommand::class);
        $this->call(CloudcoverFinishQueueCommand::class);
        $this->call(ShortwaveRadiationFinishQueueCommand::class);
        $this->call(WindspeedFinishQueueCommand::class);
    }
}
