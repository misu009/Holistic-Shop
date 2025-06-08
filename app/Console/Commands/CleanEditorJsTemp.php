<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanEditorJsTemp extends Command
{
    protected $signature = 'editorjs:clean-temp';
    protected $description = 'Deletes images in editorjs/tmp older than X minutes';

    public function handle()
    {
        $files = Storage::disk('public')->files('editorjs/tmp');
        $threshold = now()->subDay(); 

        $deleted = 0;

        foreach ($files as $file) {
            $fullPath = storage_path('app/public/' . $file);
            if (file_exists($fullPath) && filemtime($fullPath) < $threshold->timestamp) {
                unlink($fullPath);
                $deleted++;
            }
        }   

        $this->info("Cleaned $deleted old temp file(s).");
        return 0;
    }
}