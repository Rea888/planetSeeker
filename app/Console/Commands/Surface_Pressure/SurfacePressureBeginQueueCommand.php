<?php

namespace App\Console\Commands\Surface_Pressure;

use App\Jobs\ProcessSurfacePressureJob;
use App\Models\HistoricalSurfacePressureProcessingReportsModel;
use Illuminate\Console\Command;

class SurfacePressureBeginQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surfacePressure:beginQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its humidity in historical_surface_pressure database ';


    public function handle()
    {
        $unprocessedSurfacePressureModels = HistoricalSurfacePressureProcessingReportsModel::where('processing_began_at', null)->get();
        foreach ($unprocessedSurfacePressureModels as $unprocessedSurfacePressureModel) {
            $job = new ProcessSurfacePressureJob($unprocessedSurfacePressureModel);
            dispatch($job);
        }
    }
}
