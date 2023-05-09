<?php

namespace App\Console\Commands;

use App\Jobs\ProcessModelsJob;
use App\Service\ModelProcessingService;
use Illuminate\Console\Command;

class ModelsFinishQueueCommand extends Command
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
    protected $signature = 'model:finishQue {model}{model2} {parameter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its parameter in models database ';


    public function handle()
    {
        $modelClassName = $this->argument('model');
        $modelClassName2 = $this->argument('model2');
        $parameter = $this->argument('parameter');
        $unprocessedModels = $this->modelProcessingService->getUnprocessedModelsWhereFinishedAtIsNull($modelClassName);
        foreach ($unprocessedModels as $unprocessedModel) {
            $job = new ProcessModelsJob($unprocessedModel, $modelClassName2, $parameter);
            dispatch($job);
        }
    }
}
