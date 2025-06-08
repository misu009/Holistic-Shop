<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\CleanTempFiles::class,
        \App\Console\Commands\CleanEditorJsTemp::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('clean:temp-files')->daily();
        $schedule->command('editorjs:clean-temp')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
