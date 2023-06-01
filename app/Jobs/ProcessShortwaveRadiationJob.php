<?php

namespace App\Jobs;

use App\Models\HistoricalShortwaveRadiationProcessingReportsModel;
use App\Service\Shortwave_Radiation\ProcessedShortwaveRadiationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessShortwaveRadiationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalShortwaveRadiationProcessingReportsModel $historicalShortwaveRadiationProcessingReportsModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalShortwaveRadiationProcessingReportsModel $historicalShortwaveRadiationProcessingReportsModel)
    {
        $this->historicalShortwaveRadiationProcessingReportsModel = $historicalShortwaveRadiationProcessingReportsModel;
    }

    /**
     * Execute the job.
     * @param ProcessedShortwaveRadiationService $processedShortwaveRadiationService
     * @return void
     * @throws RequestException
     */
    public function handle(ProcessedShortwaveRadiationService $processedShortwaveRadiationService): void
    {
        $processedShortwaveRadiationService->process($this->historicalShortwaveRadiationProcessingReportsModel);
    }
}
