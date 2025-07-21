<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- Asegúrate de que esta línea esté presente

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
        // Esta línea es la solución. Le dice a Laravel que use los estilos
        // de Bootstrap 5 para todos los enlaces de paginación de la aplicación.
        Paginator::useBootstrapFive(); 
    }
}