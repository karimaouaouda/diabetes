<?php

namespace App\Providers\Filament;

use App\Filament\Patient\Pages\Auth\PatientRegister;
use App\Filament\Shared\Pages\Chat;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use App\Filament\Pages\PatientDiabetesTools;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Support\Facades\FilamentIcon;
use App\Filament\Patient\Pages\CalculInsuline;
//use App\Filament\Patient\Pages\pages\SaisieGlycemie;

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
            ->login()
            ->registration(PatientRegister::class)
            ->databaseNotifications()
            ->discoverResources(in: app_path('Filament/Patient/Resources'), for: 'App\\Filament\\Patient\\Resources')
            ->discoverPages(in: app_path('Filament/Patient/Pages'), for: 'App\\Filament\\Patient\\Pages')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverPages(in: app_path('Filament/Shared/Pages'), for: 'App\\Filament\\Shared\\Pages')
            ->pages([
                Pages\Dashboard::class,
               Chat::class,
               // Pages\SaisieGlycemie::class,
              // Pages\HistoriqueMedical::class,
             // PatientProfile::class,
             CalculInsuline::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Patient/Widgets'), for: 'App\\Filament\\Patient\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
