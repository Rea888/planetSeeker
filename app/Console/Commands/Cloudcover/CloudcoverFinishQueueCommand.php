<?php

namespace App\Console\Commands\Cloudcover;

use App\Jobs\ProcessCloudcoverJob;
use App\Models\HistoricalCloudcoverProcessingReportsModel;
use Illuminate\Console\Command;

class CloudcoverFinishQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudcover:finishQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its cloudcover in historical_cloudcover database ';


    public function handle()
    {
        $unprocessedCloudcoverModels = HistoricalCloudcoverProcessingReportsModel::where('processing_finished_at', null)->get();
        foreach ($unprocessedCloudcoverModels as $unprocessedCloudcoverModel) {
            $job = new ProcessCloudcoverJob($unprocessedCloudcoverModel);
            dispatch($job);
        }
    }
}
