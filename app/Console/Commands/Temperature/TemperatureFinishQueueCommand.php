<?php

namespace App\Console\Commands\Temperature;

use App\Jobs\ProcessTemperatureJob;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use Illuminate\Console\Command;

class TemperatureFinishQueueCommand extends Command
{

    private HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel;

    public function __construct(HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel)
    {
        parent::__construct();
        $this->historicalTemperatureProcessingReportsModel = $historicalTemperatureProcessingReportsModel;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperature:finishQue {parameter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its humidity in historical_temperature database ';


    public function handle()
    {
        $parameter = $this->argument('parameter');
        $unprocessedTemperatureModles = $this->historicalTemperatureProcessingReportsModel->getUnprocessedModelsWhereFinishedAtIsNull();
        foreach ($unprocessedTemperatureModles as $unprocessedTemperatureModel) {
            $job = new ProcessTemperatureJob($unprocessedTemperatureModel, $parameter);
            dispatch($job);
        }
    }
}
