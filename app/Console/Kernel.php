<?php

namespace App\Console;

use Carbon\Carbon;
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

        // Schedule humidityProcess:save to run monthly at a specific time, e.g., 01:00
        $schedule->command('humidityProcess:save')->monthly()->dailyAt('01:00');

        // Schedule humidity:beginQue to run monthly, 2 minutes after humidityProcess:save
        $twoMinutesLater = Carbon::createFromTimeString('01:00')->addMinutes(2)->format('H:i');
        $schedule->command('humidity:beginQue')->monthly()->dailyAt($twoMinutesLater);

        // Schedule humidity:finishQue to run monthly, one hour after humidity:beginQue
        $oneHourLater = Carbon::createFromTimeString($twoMinutesLater)->addHour()->format('H:i');
        $schedule->command('humidity:finishQue')->monthly()->dailyAt($oneHourLater);

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
