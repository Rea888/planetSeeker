<?php

namespace App\Console\Commands\Cloudcover;

use App\Console\Commands\AbstractInitializeCommand;
use App\Service\Cloudcover\CloudcoverProcessingService;
use Exception;

class CloudcoverInitializeCommand extends AbstractInitializeCommand
{
    protected $signature = 'cloudcover:initialize';

    protected $description = 'Save cities and dates to cloudcover_processing_reports_table';

    private CloudcoverProcessingService $cloudcoverProcessingService;

    public function __construct(CloudcoverProcessingService $cloudcoverProcessingService)
    {
        parent::__construct();
        $this->cloudcoverProcessingService = $cloudcoverProcessingService;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $dataIdentifiers = $this->getCitiesAndDates();
        foreach ($dataIdentifiers as $dataIdentifier) {
            $this->cloudcoverProcessingService->initialize($dataIdentifier);
        }
    }
}
