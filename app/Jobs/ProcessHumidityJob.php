<?php

namespace App\Jobs;

use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Service\Humidity\ProcessedHumidityService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessHumidityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalHumidityProcessingReportsModel $historicalHumidityProcessingReportsModel;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalHumidityProcessingReportsModel $historicalHumidityProcessingReportsModel)
    {
        $this->historicalHumidityProcessingReportsModel = $historicalHumidityProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedHumidityService $processedHumidityService
     * @return void
     */
    public function handle(ProcessedHumidityService $processedHumidityService): void
    {
        $processedHumidityService->process($this->historicalHumidityProcessingReportsModel);
    }
}
