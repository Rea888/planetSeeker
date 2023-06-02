<?php

namespace App\Jobs;

use App\Models\HistoricalWindspeedModelProcessingReportsModel;
use App\Service\Windspeed\ProcessedWindspeedService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWindspeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalWindspeedModelProcessingReportsModel $historicalWindspeedModelProcessingReportsModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalWindspeedModelProcessingReportsModel $historicalWindspeedModelProcessingReportsModel)
    {
        //
        $this->historicalWindspeedModelProcessingReportsModel = $historicalWindspeedModelProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedWindspeedService $processedWindspeedService
     * @return void
     * @throws Exception
     */
    public function handle(ProcessedWindspeedService $processedWindspeedService): void
    {
        $processedWindspeedService->process($this->historicalWindspeedModelProcessingReportsModel);
    }
}
