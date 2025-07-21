<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ParqueoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortalController;

// --- RUTAS PÚBLICAS ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// --- RUTAS PROTEGIDAS ---
Route::middleware('auth')->group(function () {

    // Ruta raíz que redirige según el rol
    Route::get('/', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard.index');
        }
        if (Auth::user()->role === 'cliente') {
            return redirect()->route('cliente.portal');
        }
        return redirect()->route('parqueo.index');
    })->name('home');

    // Ruta de Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Rutas del Panel de Operaciones
    Route::get('/panel', [ParqueoController::class, 'index'])->name('parqueo.index');
    Route::post('/ingreso', [ParqueoController::class, 'registrarIngreso'])->name('parqueo.ingreso');
    Route::post('/salida', [ParqueoController::class, 'registrarSalida'])->name('parqueo.salida');
    
    // Rutas del Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas EXCLUSIVAS para Administradores
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('clientes', ClienteController::class);
        // LA LÍNEA CLAVE ES ESTA:
        Route::resource('clientes.vehiculos', VehiculoController::class)->shallow();
        Route::resource('clientes.contratos', ContratoController::class)
            ->shallow()
            ->only(['create', 'store', 'destroy']);
        Route::get('contratos/{contrato}/recibo', [ContratoController::class, 'showRecibo'])->name('contratos.recibo');
        Route::resource('usuarios', UserController::class)->except(['show']);
    });

    // Rutas EXCLUSIVAS para Clientes
    Route::middleware('role:cliente')->group(function () {
        Route::get('/portal-cliente', [PortalController::class, 'index'])->name('cliente.portal');
    });

});

require __DIR__.'/auth.php';