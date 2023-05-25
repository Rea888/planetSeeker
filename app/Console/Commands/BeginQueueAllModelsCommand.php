<?php

namespace App\Console\Commands;

use App\Console\Commands\Humidity\HumidityBeginQueueCommand;
use App\Console\Commands\Temperature\TemperatureBeginQueueCommand;
use Illuminate\Console\Command;


class BeginQueueAllModelsCommand extends Command
{
    protected $signature = 'models:beginQue';

    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its historical_* database';

    public function handle()
    {
        $this->call(TemperatureBeginQueueCommand::class);
        $this->call(HumidityBeginQueueCommand::class);
    }
}

