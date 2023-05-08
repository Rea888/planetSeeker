<?php

namespace App\Console\Commands;

use App\Jobs\ProcessModelsJob;
use App\Service\ModelProcessingService;
use Illuminate\Console\Command;

class ModelsBeginQueueCommand extends Command
{


    private ModelProcessingService $modelProcessingService;

    public function __construct(ModelProcessingService $modelProcessingService)
    {
        parent::__construct();

        $this->modelProcessingService = $modelProcessingService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidity:beginQue {$model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its parameter in models database ';


    public function handle()
    {
        $modelClassName = $this->argument('model');
        $unprocessedHumidityModels = $this->modelProcessingService->getUnprocessedModelsBeganAt($modelClassName);
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessModelsJob($unprocessedHumidityModel);
            dispatch($job);
        }
    }
}
