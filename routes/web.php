<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Nuestros Controladores ---
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;

// --- Añadido para la API de búsqueda ---
use Illuminate\Http\Request;
use App\Models\Producto;

/*
|--------------------------------------------------------------------------
| Ruta de Bienvenida (Pública)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
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
    
    // --- RUTAS PARA TODOS LOS USUARIOS (VENDEDORES Y ADMINS) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('ventas', VentaController::class);
    
    // Rutas de Perfil (de Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- RUTAS SÓLO PARA ADMINS ---
    // Usamos el 'admin' middleware que creamos
    Route::middleware(['admin'])->group(function () {
        
        Route::resource('productos', ProductoController::class);
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        
        // (Si en el futuro creas una ruta de "gestión de usuarios", iría aquí)
    });
    

    // --- RUTA DE API PARA EL BUSCADOR DE VENTAS ---
    // (Protegida por 'auth' para que solo usuarios logueados puedan usarla)
    Route::get('/api/productos', function (Request $request) {
        $filtro = $request->input('filtro');
        $productos = Producto::query()
            ->when($filtro, function ($query, $filtro) {
                $query->where('nombre', 'like', '%' . $filtro . '%');
            })
            ->where('stock', '>', 0) // Solo productos con stock > 0
            ->orderBy('nombre', 'asc')
            ->get();
        return response()->json($productos);
    });

    
}); // <-- Fin del grupo 'auth'


// Archivo de rutas de autenticación
require __DIR__.'/auth.php';