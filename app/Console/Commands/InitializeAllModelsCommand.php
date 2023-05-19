<?php

namespace App\Console\Commands;

use App\Console\Commands\Humidity\HumidityInitializeCommand;
use App\Console\Commands\Temperature\TemperatureInitializeCommand;
use Illuminate\Console\Command;
class InitializeAllModelsCommand extends Command
{
    protected $signature = 'models:initialize';

    protected $description = 'Save cities and dates in all processing_models_tables';

    public function handle()
    {
        $this->call(TemperatureInitializeCommand::class);
        $this->call(HumidityInitializeCommand::class);
    }
}
