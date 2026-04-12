<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Post;
use App\Models\Events;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class OptimizeExistingImages extends Command
{
    // Added {--dry} to the signature
    protected $signature = 'images:optimize {--dry : Run the script without modifying files or database}';
    protected $description = 'Rescale and convert all existing images to WebP';

    protected $isDryRun = false;

    public function handle()
    {
        $this->isDryRun = $this->option('dry');

        if ($this->isDryRun) {
            $this->warn('!!! RUNNING IN DRY RUN MODE - NO CHANGES WILL BE SAVED !!!');
        }

        $manager = new ImageManager(new Driver());
        $disk = Storage::disk('public');

        // 1. Products (800px)
        $this->info('Processing Product Gallery...');
        $this->processMedia(\App\Models\Product::all(), 800, $manager, $disk);

        // 2. Posts (800px)
        $this->info('Processing Post Gallery...');
        $this->processMedia(\App\Models\Post::all(), 800, $manager, $disk);

        // 3. Events (1920px)
        $this->info('Processing Event Media...');
        $this->processMedia(\App\Models\Events::all(), 1920, $manager, $disk);

        // 4. Post Preview Images
        $this->info('Processing Post Preview Images...');
        foreach (Post::whereNotNull('preview_image')->get() as $post) {
            $this->optimizeSingleColumn($post, 'preview_image', 800, $manager, $disk);
        }

        $this->info($this->isDryRun ? 'Dry run complete. No files were harmed.' : 'Optimization complete!');
    }

    private function processMedia($models, $width, $manager, $disk)
    {
        foreach ($models as $model) {
            foreach ($model->media as $media) {
                if (Str::endsWith($media->path, '.webp')) continue;

                if ($disk->exists($media->path)) {
                    $oldPath = $media->path;
                    $newPath = Str::replaceLast(pathinfo($oldPath, PATHINFO_EXTENSION), 'webp', $oldPath);

                    try {
                        // We still "read" the image to verify it's not corrupt
                        $img = $manager->read($disk->path($oldPath));
                        $encoded = $img->scaleDown(width: $width)->toWebp(quality: 80);

                        if (!$this->isDryRun) {
                            $disk->put($newPath, $encoded->toString());
                            $media->update(['path' => $newPath]);
                            if ($oldPath !== $newPath) $disk->delete($oldPath);
                            $this->line("<info>Optimized:</info> $newPath");
                        } else {
                            $this->line("<comment>[DRY RUN]</comment> Would optimize: $oldPath -> $newPath");
                        }
                    } catch (\Exception $e) {
                        $this->error("Failed: $oldPath - " . $e->getMessage());
                    }
                }
            }
        }
    }

    private function optimizeSingleColumn($model, $column, $width, $manager, $disk)
    {
        $oldPath = $model->$column;
        if (!$oldPath || Str::endsWith($oldPath, '.webp')) return;

        if ($disk->exists($oldPath)) {
            $newPath = Str::replaceLast(pathinfo($oldPath, PATHINFO_EXTENSION), 'webp', $oldPath);
            try {
                $img = $manager->read($disk->path($oldPath));
                $encoded = $img->scaleDown(width: $width)->toWebp(quality: 80);

                if (!$this->isDryRun) {
                    $disk->put($newPath, $encoded->toString());
                    $model->update([$column => $newPath]);
                    $disk->delete($oldPath);
                    $this->line("<info>Optimized Column:</info> $newPath");
                } else {
                    $this->line("<comment>[DRY RUN]</comment> Would optimize column: $oldPath -> $newPath");
                }
            } catch (\Exception $e) {
                $this->error("Failed Column: $oldPath");
            }
        }
    }
}