<?php

namespace App\Console\Commands;

use App\Console\Commands\Humidity\HumidityInitializeCommand;
use App\Console\Commands\Temperature\TemperatureInitializeCommand;
use Illuminate\Console\Command;

class InitalizeAllModelsCommand extends Command
{
    protected $signature = 'models:initialize';

    protected $description = 'TODO';

    public function handle()
    {
        $this->call(TemperatureInitializeCommand::class);
        $this->call(HumidityInitializeCommand::class);
    }
}
