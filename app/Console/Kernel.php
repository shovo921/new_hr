<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\AttendanceCronJob::class,
        Commands\AttendanceCronJobTest::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       /* $schedule->command('release:holdTickets')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('clear:otp')->everyFiveMinutes()->withoutOverlapping()->runInBackground();*/
        $schedule->command('AttendanceCronJob:attendanceCronJob')->everyMinute()->runInBackground();
        $schedule->command('AttendanceCronJobTest:AttendanceCronJobTest')->everyMinute()->runInBackground();
        $schedule->command('inspire') ->everyMinute()->appendOutputTo(storage_path('logs/cronlog.log'));
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
