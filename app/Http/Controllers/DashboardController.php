<?php

namespace App\Http\Controllers;

use App\Models\Venta; // Importamos el modelo Venta
use Illuminate\Http\Request;
use App\Models\Producto; // <-- AÑADE ESTA LÍNEA

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal con las ventas del día.
     */
    public function index()
    {
        // 1. Obtenemos las ventas de HOY (como ya lo hacíamos)
        $ventasHoy = Venta::with('producto')
                        ->whereDate('fecha', now()) 
                        ->latest('fecha') 
                        ->get();

        // 2. Calculamos los totales del día
        $totalHoy = $ventasHoy->sum('total');
        $cantidadHoy = $ventasHoy->count();

        // --- INICIO: NUEVA LÓGICA DE STOCK ---
        
        // 3. Inicializamos la variable
        $productosBajoStock = collect(); // Una colección vacía

        // 4. Si el usuario es admin, buscamos el stock bajo
        if (auth()->user()->role == 'admin') {
            $productosBajoStock = Producto::where('stock', '<=', 5) // Límite de 5 unidades
                                            ->orderBy('stock', 'asc') // Mostrar los más bajos primero
                                            ->get();
        }
        
        // --- FIN: NUEVA LÓGICA DE STOCK ---

        // 5. Pasamos todos los datos a la vista
        return view('dashboard', compact(
            'ventasHoy', 
            'totalHoy', 
            'cantidadHoy', 
            'productosBajoStock' // <-- Pasamos la nueva variable
        ));
    }
}
