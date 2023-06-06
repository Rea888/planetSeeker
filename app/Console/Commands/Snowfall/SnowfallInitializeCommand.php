<?php

namespace App\Console\Commands\Snowfall;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Snowfall\SnowfallProcessingService;
use Exception;

class SnowfallInitializeCommand extends AbstractInitializeCommand
{
    protected $signature = 'snowfall:initialize';

    protected $description = 'Save cities and dates to historical_snowfall_processing_reports_table';

    private SnowfallProcessingService $snowfallProcessingService;

    public function __construct(SnowfallProcessingService $snowfallProcessingService)
    {
        parent::__construct();
        $this->snowfallProcessingService = $snowfallProcessingService;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();

        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->snowfallProcessingService->initialize($dataIdentifier);
        }
    }
}
