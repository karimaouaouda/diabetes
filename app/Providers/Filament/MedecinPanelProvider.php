<?php

namespace App\Providers\Filament;

use App\Filament\Medecin\Pages\DoctorRegister;
use app\Filament\Medecin\Pages\PatientGlycemieHistory;
use App\Filament\Medecin\Resources\PatientResource\Pages\PatientAnalytics;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MedecinPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('doctor')
            ->path('doctor')
            ->colors([
                'primary' => Color::Green,
            ])
            ->login()
            ->registration(DoctorRegister::class)
            ->databaseNotifications()
            ->databaseNotificationsPolling("2s")
            ->discoverResources(in: app_path('Filament/Medecin/Resources'), for: 'App\\Filament\\Medecin\\Resources')
            ->discoverPages(in: app_path('Filament/Medecin/Pages'), for: 'App\\Filament\\Medecin\\Pages')
            ->discoverPages(in: app_path('Filament/Shared/Pages'), for: 'App\\Filament\\Shared\\Pages')
            ->pages([
                Pages\Dashboard::class,
                PatientGlycemieHistory::class,
                PatientAnalytics::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Medecin/Widgets'), for: 'App\\Filament\\Medecin\\Widgets')
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
}
