<?php

namespace App\Console\Commands\Shortwave_Radiation;

use App\Jobs\ProcessShortwaveRadiationJob;
use App\Models\HistoricalShortwaveRadiationProcessingReportsModel;
use Illuminate\Console\Command;

class ShortwaveRadiationFinishQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shortwave_radiation:finishQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its shortwave radiation in historical_shortwave_radiation database ';

    public function handle()
    {
        $unprocessedShortwaveRadiationModels = HistoricalShortwaveRadiationProcessingReportsModel::where('processing_finished_at', null)->get();
        foreach ($unprocessedShortwaveRadiationModels as $unprocessedShortwaveRadiationModel) {
            $job = new ProcessShortwaveRadiationJob($unprocessedShortwaveRadiationModel);
            dispatch($job);
        }
    }
}
