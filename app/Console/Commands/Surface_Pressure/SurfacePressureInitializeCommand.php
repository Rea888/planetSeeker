<?php

namespace App\Console\Commands\Surface_Pressure;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Surface_Pressure\SurfacePressureProcessingService;
use Exception;

class SurfacePressureInitializeCommand extends AbstractInitializeCommand
{
    protected $signature = 'surfacePressure:initialize';

    protected $description = 'Save cities and dates to surface_pressure_processing_reports_models_table';
    private SurfacePressureProcessingService $surfacePressureProcessingService;

    public function __construct(SurfacePressureProcessingService $surfacePressureProcessingService)
    {
        parent::__construct();
        $this->surfacePressureProcessingService = $surfacePressureProcessingService;
   }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();
        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->surfacePressureProcessingService->initialize($dataIdentifier);
        }
    }
}
