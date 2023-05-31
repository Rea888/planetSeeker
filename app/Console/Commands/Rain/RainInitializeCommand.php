<?php

namespace App\Console\Commands\Rain;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Rain\RainProcessingService;
use Exception;

class RainInitializeCommand extends AbstractInitializeCommand
{
    protected $signature = 'rain:initialize';

    protected $description = 'Save cities and dates to rain_processing_reports_table';

    private RainProcessingService $rainProcessingService;

    public function __construct(RainProcessingService $rainProcessingService)
    {
        parent::__construct();
        $this->rainProcessingService = $rainProcessingService;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();
        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->rainProcessingService->initialize($dataIdentifier);
        }
    }
}
