<?php

namespace App\Console\Commands\Snowfall;

use App\Jobs\ProcessSnowfallJob;
use App\Models\HistoricalSnowfallProcessingReportsModel;
use Illuminate\Console\Command;

class SnowfallFinishQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snowfall:finishQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its snowfall value in historical_snowfall database ';

    public function handle()
    {
        $unprocessedSnowfallModels = HistoricalSnowfallProcessingReportsModel::where('processing_finished_at', null)->get();
        foreach ($unprocessedSnowfallModels as $unprocessedSnowfallModel) {
            $job = new ProcessSnowfallJob($unprocessedSnowfallModel);
            dispatch($job);
        }
    }
}
