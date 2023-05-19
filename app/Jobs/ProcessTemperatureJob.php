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


    private string $parameter;
    private HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel, string $parameter)
    {

        $this->parameter = $parameter;
        $this->historicalTemperatureProcessingReportsModel = $historicalTemperatureProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProcessedTemperatureService $processedHumidityService)
    {
        $processedHumidityService->process($this->historicalTemperatureProcessingReportsModel, $this->parameter);
    }
}
