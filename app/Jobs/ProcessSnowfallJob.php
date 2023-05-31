<?php

namespace App\Jobs;

use App\Models\HistoricalSnowfallProcessingReportsModel;
use App\Service\Snowfall\ProcessedSnowfallService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSnowfallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HistoricalSnowfallProcessingReportsModel $historicalSnowfallProcessingReportsModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HistoricalSnowfallProcessingReportsModel $historicalSnowfallProcessingReportsModel){

        $this->historicalSnowfallProcessingReportsModel = $historicalSnowfallProcessingReportsModel;
    }

    /**
     * Execute the job.
     *
     * @param ProcessedSnowfallService $processedSnowfallService
     * @return void
     * @throws RequestException
     */
    public function handle(ProcessedSnowfallService $processedSnowfallService): void
    {
        $processedSnowfallService->process($this->historicalSnowfallProcessingReportsModel);
    }
}
