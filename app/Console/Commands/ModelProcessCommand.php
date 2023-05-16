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
    protected $signature = 'modelProcess:save {models_names}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process cities and dates since start date in config and save records into DB';
    private ModelProcessingService $modelProcessingService;

    public function __construct(ModelProcessingService $modelProcessingService)
    {
        parent::__construct();
        $this->modelProcessingService = $modelProcessingService;
    }


    public function handle()
    {
        $groupName = $this->argument('models_names');
        $modelsNames = config("models_names.$groupName");

        if (is_null($modelsNames)) {
            $this->error("Parameter group not found: $groupName");
            return;
        }

        foreach ($modelsNames as $modelsName) {
            $this->modelProcessingService->saveModelProcessToDb($modelsName);
        }
    }
}
