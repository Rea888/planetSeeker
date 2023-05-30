<?php

namespace App\Console\Commands\Humidity;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Humidity\HumidityProcessingService;
use Exception;

class HumidityInitializeCommand extends AbstractInitializeCommand
{
    protected $signature = 'humidity:initialize';

    protected $description = 'Save cities and dates to humidity_processing_reports_table';

    private HumidityProcessingService $humidityProcessingService;

    public function __construct(HumidityProcessingService $humidityProcessingService)
    {
        parent::__construct();
        $this->humidityProcessingService = $humidityProcessingService;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();
        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->humidityProcessingService->initialize($dataIdentifier);
        }
    }
}
