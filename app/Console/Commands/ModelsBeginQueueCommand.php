<?php

namespace App\Console\Commands;

use App\Jobs\ProcessModelsJob;
use App\Service\ModelProcessingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
    protected $signature = 'model:beginQue {model} {model2} {parameter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its parameter in models database ';


    public function handle()
    {
        $modelClassName = $this->argument('model');
        $modelClassName2 = $this->argument('model2');
        $parameter = $this->argument('parameter');
        $unprocessedModels = $this->modelProcessingService->getUnprocessedModelsWhereBeganAtIsNull  ($modelClassName);
        foreach ($unprocessedModels as $unprocessedModel) {
            $job = new ProcessModelsJob($unprocessedModel, $modelClassName2, $parameter);
            dispatch($job);
        }
    }
}
