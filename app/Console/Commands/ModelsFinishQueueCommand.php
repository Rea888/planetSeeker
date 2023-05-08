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
    protected $signature = 'model:finishQue {$model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its parameter in models database ';


    public function handle()
    {
        $modelClassName = $this->argument('model');
        $unprocessedModels = $this->modelProcessingService->getUnprocessedModelsFinishedAt($modelClassName);
        foreach ($unprocessedModels as $unprocessedModel) {
            $job = new ProcessModelsJob($unprocessedModel);
            dispatch($job);
        }
    }
}
