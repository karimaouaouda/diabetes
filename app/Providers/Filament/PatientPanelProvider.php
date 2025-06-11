<?php

namespace App\Providers\Filament;

use App\Filament\Patient\Pages\Auth\PatientRegister;
use App\Filament\Patient\Pages\PatientProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Support\Facades\FilamentIcon;
use App\Filament\Patient\Pages\CalculInsuline;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PatientPanelProvider extends PanelProvider
{
    /**
     * @throws \Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('patient')
            ->path('patient')
            ->colors([
                'primary' => Color::Sky,
            ])
            ->icons([
                'heroicon-o-chat'
            ])
            ->login()
            ->registration(PatientRegister::class)
            ->profile(PatientProfile::class, isSimple: false)
            ->databaseNotifications()
            ->databaseNotificationsPolling("2s")
            ->discoverResources(in: app_path('Filament/Patient/Resources'), for: 'App\\Filament\\Patient\\Resources')
            ->discoverPages(in: app_path('Filament/Patient/Pages'), for: 'App\\Filament\\Patient\\Pages')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverPages(in: app_path('Filament/Shared/Pages'), for: 'App\\Filament\\Shared\\Pages')
            ->pages([
                Pages\Dashboard::class,
                CalculInsuline::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Patient/Widgets'), for: 'App\\Filament\\Patient\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

    }

    public function boot()
    {


     FilamentIcon::register([
         'panels::topbar.account-menu' => 'heroicon-s-pencil', // Example using a Blade icon
         // Or use HTML:
         // 'panels::topbar.account-menu' => view('icons.custom-icon'), // If you have a Blade view
     ]);
    }
}
