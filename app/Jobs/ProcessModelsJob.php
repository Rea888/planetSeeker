<?php

namespace App\Jobs;

use App\Contracts\Processable;
use App\Service\ApiDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessModelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private string $parameter;
    private Processable $processable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Processable $processable, string $parameter, )
    {
        $this->parameter = $parameter;
        $this->processable = $processable;
    }


    public function handle(ApiDataService $apiDataService)
    {
        $apiDataService->process($this->processable, $this->parameter);
    }
}
