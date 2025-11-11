<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Nuestros Controladores ---
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController; // <-- AÑADE ESTA LÍNEA

/*
|--------------------------------------------------------------------------
| Ruta de Bienvenida (Pública)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Si el usuario está logueado, que vaya al dashboard.
    // Si no, que vea la página de bienvenida de Breeze (con login/register).
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Iniciar Sesión)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ¡ESTA ES LA LÍNEA CLAVE!
    // Esta debe ser la ÚNICA definición de '/dashboard'.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Nuestras rutas de la aplicación
    Route::resource('productos', ProductoController::class);
    Route::resource('ventas', VentaController::class);
    Route::get('/ventas/exportar', [VentaController::class, 'exportar'])->name('ventas.exportar');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    // 3. Rutas de Perfil (de Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

}); // <-- Fin del grupo 'auth'


// Archivo de rutas de autenticación de Breeze (login, register, etc.)
require __DIR__.'/auth.php';