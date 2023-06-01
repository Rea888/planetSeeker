<?php

namespace App\Console\Commands\Shortwave_Radiation;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Shortwave_Radiation\ShortwaveRadiationProcessingService;
use Exception;

class ShortwaveRadiationInitializeCommand extends AbstractInitializeCommand
{
    protected $signature = 'shortwave_radiation:initialize';

    protected $description = 'Save cities and dates to shortwave_radiation_processing_reports_table';

    private ShortwaveRadiationProcessingService $shortwaveRadiationProcessingService;

    public function __construct(ShortwaveRadiationProcessingService $shortwaveRadiationProcessingService)
    {
        parent::__construct();
        $this->shortwaveRadiationProcessingService = $shortwaveRadiationProcessingService;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();
        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->shortwaveRadiationProcessingService->initialize($dataIdentifier);
        }
    }
}
