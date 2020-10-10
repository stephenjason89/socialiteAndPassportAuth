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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // Cleanup OAuth2 related tokens
        $schedule->command(Commands\OAuth2\PurgeExpiredAuthCodes::class)
            ->runInBackground()->dailyAt('02:00')->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/schedule.log'));
        $schedule->command(Commands\OAuth2\PurgeExpiredAccessTokens::class)
            ->runInBackground()->dailyAt('02:15')->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/schedule.log'));
        $schedule->command(Commands\OAuth2\PurgeExpiredRefreshTokens::class)
            ->runInBackground()->dailyAt('02:30')->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/schedule.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
