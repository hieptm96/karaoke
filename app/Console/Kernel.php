<?php

namespace App\Console;


use App\Console\Commands\LoadSingerSong;
use App\Console\Commands\MakeSampleData;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\LoadProviceDistrict;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\EmailCommand',
        MakeSampleData::class,
        LoadSingerSong::class,
        LoadProviceDistrict::class,

    ];

    /**dd
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
//        $schedule->command('email:everyMonth')->when(function() {
//            return (new \Carbon\Carbon('first day of this month'))->isToday();
//        });
        // Run on 01 day of the month
        $schedule->command('email:everyMonth')->cron('0 0 01 * *');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
