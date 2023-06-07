<?php

namespace App\Console\Commands\Windspeed;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Windspeed\WindspeedProcessingService;
use Exception;

class WindspeedInitializeCommand extends AbstractInitializeCommand
{

    protected $signature = 'windspeed:initialize';

    protected $description = 'Save cities and dates to historical_windspeed_processing_reports_table';
    private WindspeedProcessingService $windspeedProcessingService;

    public function __construct(WindspeedProcessingService $windspeedProcessingService)
    {
        parent::__construct();
        $this->windspeedProcessingService = $windspeedProcessingService;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();

        foreach ($dataIdentifiers as $dataIdentifier){
            $this->windspeedProcessingService->initialize($dataIdentifier);
        }
    }
}
