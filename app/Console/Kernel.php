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
        $names = config('models_names.names');
        $namesString = implode(' ', $names);
        $group1 = config('parameters.group1');
        $group1String = implode(' ',$group1);

        $schedule->command('weatherforecast:process')->dailyAt('01:00');

        $schedule->command('modelProcess:save {$namesString}')->monthly()->dailyAt('01:05');

        $fiveMinutesLater = Carbon::createFromTimeString('01:05')->addMinutes(5)->format('H:i');
        $schedule->command('model:beginQue {$group1String}')->monthly()->dailyAt($fiveMinutesLater);


        $oneHourLater = Carbon::createFromTimeString($fiveMinutesLater)->addHour()->format('H:i');
        $schedule->command('model:finishQue {$group1String}')->monthly()->dailyAt($oneHourLater);
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
