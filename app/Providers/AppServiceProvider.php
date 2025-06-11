<?php

namespace App\Providers;

use App\Livewire\ChatIcon;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        FilamentView::registerRenderHook(PanelsRenderHook::GLOBAL_SEARCH_AFTER, function(){
            return Blade::render('@livewire(\'chat-icon\')');
        });
    }
}
