<?php

namespace App\Jobs;

use App\Service\ApiDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessModelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private Model $unprocessedModel;
    private string $parameter;
    private string $modelClassName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $unprocessedModel, string $modelClassName, string $parameter )
    {
        $this->unprocessedModel = $unprocessedModel;
        $this->modelClassName = $modelClassName;
        $this->parameter = $parameter;
    }


    public function handle(ApiDataService $apiDataService)
    {
        $apiDataService->process($this->unprocessedModel, $this->modelClassName,$this->parameter);
    }
}
