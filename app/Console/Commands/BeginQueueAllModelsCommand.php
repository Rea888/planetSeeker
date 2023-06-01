<?php

namespace App\Console\Commands;

use App\Console\Commands\Cloudcover\CloudcoverBeginQueueCommand;
use App\Console\Commands\Humidity\HumidityBeginQueueCommand;
use App\Console\Commands\Shortwave_Radiation\ShortwaveRadiationBeginQueueCommand;
use App\Console\Commands\Surface_Pressure\SurfacePressureBeginQueueCommand;
use App\Console\Commands\Temperature\TemperatureBeginQueueCommand;
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
        $this->call(CloudcoverBeginQueueCommand::class);
        $this->call(ShortwaveRadiationBeginQueueCommand::class);
    }
}

