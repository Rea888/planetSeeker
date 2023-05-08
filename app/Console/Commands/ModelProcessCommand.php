<?php

namespace App\Console\Commands;

use App\Service\ModelProcessingService;
use Illuminate\Console\Command;

class ModelProcessCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modelProcess:save {$model}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process cities and dates since start date in config and save records into DB';
    private ModelProcessingService $modelProcessingService;

    public function __construct(ModelProcessingService $historicalHumidityProcessingService)
    {
        parent::__construct();
        $this->modelProcessingService = $historicalHumidityProcessingService;
    }


    public function handle()
    {
        $modelClassName = $this->argument('model');
        $this->modelProcessingService->saveModelProcessToDb($modelClassName);
    }
}
