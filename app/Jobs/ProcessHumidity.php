<?php

namespace App\Jobs;

use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Service\ApiDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessHumidity implements ShouldQueue
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
     * @return void
     */
    public function handle(ApiDataService $apiDataService)
    {
        $apiDataService->process($this->historicalHumidityProcessingReportsModel);
    }
}
