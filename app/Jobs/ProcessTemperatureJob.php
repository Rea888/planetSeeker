<?php

namespace App\Jobs;

use App\Models\HistoricalTemperatureProcessingReportsModel;
use App\Service\Temperature\ProcessedTemperatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTemperatureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel)
    {
        $this->historicalTemperatureProcessingReportsModel = $historicalTemperatureProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedTemperatureService $processedHumidityService
     * @return void
     */
    public function handle(ProcessedTemperatureService $processedHumidityService): void
    {
        $processedHumidityService->process($this->historicalTemperatureProcessingReportsModel);
    }
}
