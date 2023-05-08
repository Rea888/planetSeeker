<?php

namespace App\Jobs;

use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Service\ApiDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessModelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private string $modelClassName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ApiDataService $apiDataService)
    {
        $apiDataService->process($this->modelClassName);
    }
}
