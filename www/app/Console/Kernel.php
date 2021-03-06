<?php

namespace StartMeUp\Console;

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
        Commands\ArteveldeDatabaseBackup::class,
        Commands\ArteveldeDatabaseDrop::class,
        Commands\ArteveldeDatabaseInit::class,
        Commands\ArteveldeDatabaseReset::class,
        Commands\ArteveldeDatabaseRestore::class,
        Commands\ArteveldeDatabaseUser::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
    }
}
