<?php

namespace App\Console\Commands\Humidity;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Processing\Humidity\HumidityProcessingService;

class HumidityInitializeCommand extends AbstractInitializeCommand
{

    protected $signature = 'humidity:initialize';

    protected $description = 'TODO';

    private HumidityProcessingService $humidityProcessingService;

    public function __construct(HumidityProcessingService $humidityProcessingService)
    {
        parent::__construct();
        $this->humidityProcessingService = $humidityProcessingService;
    }

    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();

        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->humidityProcessingService->initialize($dataIdentifier);
        }
    }
}
