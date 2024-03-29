<?php

namespace App\Console\Commands;

use App\Console\Commands\Humidity\HumidityBeginQueueCommand;
use App\Console\Commands\Rain\RainBeginQueueCommand;
use App\Console\Commands\Snowfall\SnowfallBeginQueueCommand;
use App\Console\Commands\Shortwave_Radiation\ShortwaveRadiationBeginQueueCommand;
use App\Console\Commands\Surface_Pressure\SurfacePressureBeginQueueCommand;
use App\Console\Commands\Temperature\TemperatureBeginQueueCommand;
use App\Console\Commands\Windspeed\WindspeedBeginQueueCommand;
use Illuminate\Console\Command;


class BeginQueueAllModelsCommand extends Command
{
    protected $signature = 'models:beginQueue';

    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its historical_* database';

    public function handle()
    {
        $this->call(TemperatureBeginQueueCommand::class);
        $this->call(HumidityBeginQueueCommand::class);
        $this->call(SurfacePressureBeginQueueCommand::class);
        $this->call(RainBeginQueueCommand::class);
        $this->call(SnowfallBeginQueueCommand::class);
        $this->call(CloudcoverBeginQueueCommand::class);
        $this->call(ShortwaveRadiationBeginQueueCommand::class);
        $this->call(WindspeedBeginQueueCommand::class);
    }
}

