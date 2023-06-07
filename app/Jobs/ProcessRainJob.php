<?php

namespace App\Jobs;

use App\Models\HistoricalRainProcessingReportsModel;
use App\Service\Rain\ProcessedRainService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRainJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalRainProcessingReportsModel $historicalRainProcessingReportsModel;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalRainProcessingReportsModel $historicalRainProcessingReportsModel)
    {
        $this->historicalRainProcessingReportsModel = $historicalRainProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedRainService $processedRainService
     * @return void
     * @throws RequestException
     */
    public function handle(ProcessedRainService $processedRainService): void
    {
        $processedRainService->process($this->historicalRainProcessingReportsModel);
    }
}
