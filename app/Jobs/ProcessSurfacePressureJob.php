<?php

namespace App\Jobs;

use App\Models\HistoricalSurfacePressureProcessingReportsModel;
use App\Service\Surface_Pressure\ProcessedSurfacePressureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSurfacePressureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalSurfacePressureProcessingReportsModel $historicalSurfacePressureProcessingRepostsModel;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalSurfacePressureProcessingReportsModel $historicalSurfacePressureProcessingRepostsModel)
    {
        $this->historicalSurfacePressureProcessingRepostsModel = $historicalSurfacePressureProcessingRepostsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedSurfacePressureService $processedSurfacePressureService
     * @return void
     */
    public function handle(ProcessedSurfacePressureService $processedSurfacePressureService): void
    {
        $processedSurfacePressureService->process($this->historicalSurfacePressureProcessingRepostsModel);
    }
}
