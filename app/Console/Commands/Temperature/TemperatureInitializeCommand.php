<?php

namespace App\Console\Commands\Temperature;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Processing\Temperature\TemperatureProcessingService;

class TemperatureInitializeCommand extends AbstractInitializeCommand
{

    protected $signature = 'temperature:initialize';

    protected $description = 'TODO';

    private TemperatureProcessingService $temperatureProcessingService;

    public function __construct(TemperatureProcessingService $temperatureProcessingService)
    {
        parent::__construct();
        $this->temperatureProcessingService = $temperatureProcessingService;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();

        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->temperatureProcessingService->initialize($dataIdentifier);
        }
    }
}
