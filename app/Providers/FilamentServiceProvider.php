<?php

namespace App\Providers;

use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registrar el enlace al dashboard de usuario en el panel de administración
        \Filament\Facades\Filament::serving(function () {
            \Filament\Facades\Filament::registerNavigationItems([
                NavigationItem::make('Zona de Usuario')
                    ->url('/')
                    ->icon('heroicon-o-user')
                    ->sort(100) // Colocarlo al final
                    ->openUrlInNewTab() // Abrir en nueva pestaña
            ]);
        });
    }
}
