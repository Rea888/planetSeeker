<?php

namespace App\Console\Commands;

use App\Service\HistoricalHumidityProcessingService;
use Illuminate\Console\Command;

class HistoricalHumidityProcessCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidityProcess:save';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private HistoricalHumidityProcessingService $historicalHumidityProcessingService;

    public function __construct(HistoricalHumidityProcessingService $historicalHumidityProcessingService)
    {
        parent::__construct();
        $this->historicalHumidityProcessingService = $historicalHumidityProcessingService;
    }


    public function handle()
    {
        $this->historicalHumidityProcessingService->saveHumidityProcessToDb();
    }
}
