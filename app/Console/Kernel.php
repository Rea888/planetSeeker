<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('weatherforecast:process')->dailyAt('01:00');
        $schedule->command('humidityProcess:save')->monthly();
        $schedule->command('humidity:queue')->monthly();
        $schedule->command('queue:work --stop-when-empty')->monthly();
        $schedule->command('humidity:queue')->monthly();
        $schedule->command('queue:work --stop-when-empty')->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
