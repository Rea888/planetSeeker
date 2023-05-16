<?php

namespace App\Console\Commands;

use App\Jobs\ProcessModelsJob;
use App\Service\ModelFromParameter;
use Illuminate\Console\Command;

class ModelsBeginQueueCommand extends Command
{


    private ModelFromParameter $modelFromParameter;

    public function __construct(ModelFromParameter $modelFromParameter)
    {
        parent::__construct();
        $this->modelFromParameter = $modelFromParameter;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:beginQue {parameters}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its parameter in models database ';


    public function handle()
    {
        $groupName = $this->argument('parameters');
        $parameters = config("parameters.$groupName");

        if (is_null($parameters)) {
            $this->error("Parameter group not found: $groupName");
            return;
        }

        foreach ($parameters as $parameter) {
            $unprocessedModelByParameter = $this->modelFromParameter->getUnprocessedModelByParameter(trim($parameter));
            $unprocessedModels = $unprocessedModelByParameter->getUnprocessedModelsWhereBeganAtIsNull();

            foreach ($unprocessedModels as $unprocessedModel) {
                $job = new ProcessModelsJob($unprocessedModel, $parameter);
                dispatch($job);
            }
        }
    }
}
