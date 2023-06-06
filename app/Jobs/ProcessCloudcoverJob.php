<?php

namespace App\Jobs;

use App\Models\HistoricalCloudcoverProcessingReportsModel;
use App\Service\Cloudcover\ProcessedCloudcoverService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCloudcoverJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalCloudcoverProcessingReportsModel $historicalCloudcoverProcessingReportsModel;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalCloudcoverProcessingReportsModel $historicalCloudcoverProcessingReportsModel)
    {
        $this->historicalCloudcoverProcessingReportsModel = $historicalCloudcoverProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedCloudcoverService $processedCloudcoverService
     * @return void
     * @throws RequestException
     */
    public function handle(ProcessedCloudcoverService $processedCloudcoverService): void
    {
        $processedCloudcoverService->process($this->historicalCloudcoverProcessingReportsModel);
    }
}
