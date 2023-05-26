<?php

namespace App\Console\Commands;

use App\Console\Commands\Humidity\HumidityFinishQueueCommand;
use App\Console\Commands\Temperature\TemperatureFinishQueueCommand;
use Illuminate\Console\Command;

class FinishQueueAllModelsCommand extends Command
{
    protected $signature = 'models:finishQueue';

    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its historical_* database';

    public function handle()
    {
        $this->call(TemperatureFinishQueueCommand::class);
        $this->call(HumidityFinishQueueCommand::class);
    }
}
