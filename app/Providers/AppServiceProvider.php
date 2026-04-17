<?php

namespace App\Providers;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('ro');
        Paginator::useBootstrap();
        View::composer('components.client.footer', function ($view) {
            $footerPages = Page::where('is_active', true)
                ->orderByDesc('is_system')
                ->orderBy('title')
                ->get();
            $view->with('footerPages', $footerPages);
        });
    }
}
