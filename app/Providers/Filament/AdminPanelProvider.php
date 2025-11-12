<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// 🛡️ Plugin de roles y permisos
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;

// 📜 Plugin de Log Viewer
use Boquizo\FilamentLogViewer\FilamentLogViewerPlugin;
use Filament\Support\Icons\Heroicon;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            // 🎨 Colores base
            ->colors([
                'primary' => Color::Amber,
            ])

            // 🧩 Plugins registrados
            ->plugins([
                FilamentShieldPlugin::make(), // Roles y permisos
                FilamentLogViewerPlugin::make()
                    ->navigationGroup('Sistema')
                    ->navigationIcon(Heroicon::OutlinedDocumentText)
                    ->navigationLabel('Log Viewer'),
            ])

            // 🔍 Descubrir automáticamente recursos y páginas
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')

            // 📋 Páginas manuales adicionales
            ->pages([
                Dashboard::class,
            ])

            // 🧱 Widgets del dashboard
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])

            // ⚙️ Middleware general
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

            // 🔒 Middleware de autenticación
            ->authMiddleware([
                Authenticate::class,
            ])

            // 💾 Opcional: habilitar notificaciones y auditoría
            ->databaseNotifications()
            ->databaseTransactions();
    }
}
