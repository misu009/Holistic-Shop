<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:temp-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes temp media files older than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tempDir = storage_path('app/public/temp');
        $files = glob($tempDir . '/*');

        $now = now();

        foreach ($files as $file) {
            if (is_file($file)) {
                $lastModified = \Carbon\Carbon::createFromTimestamp(filemtime($file));
                if ($lastModified->diffInHours($now) >= 24) {
                    unlink($file);
                }
            }
        }

        $this->info('Old temp files cleaned up.');
    }
}
