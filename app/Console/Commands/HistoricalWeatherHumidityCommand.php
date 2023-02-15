<?php

namespace App\Console\Commands;

use App\Http\Controllers\HistoricalWeatherHumidityController;
use Illuminate\Console\Command;

class HistoricalWeatherHumidityCommand extends Command
{

    private HistoricalWeatherHumidityController $historicalWeatherHumidityController;

    public function __construct(HistoricalWeatherHumidityController $historicalWeatherHumidityController)
    {
        parent::__construct();
        $this->historicalWeatherHumidityController = $historicalWeatherHumidityController;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historicalWeatherHumidity:progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->historicalWeatherHumidityController->getHistoricalWeatherHumidity('Paris','2013','01');
    }
}
