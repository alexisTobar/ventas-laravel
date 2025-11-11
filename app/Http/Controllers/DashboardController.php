<?php

namespace App\Http\Controllers;

use App\Models\Venta; // Importamos el modelo Venta
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal con las ventas del día.
     */
    public function index()
    {
        // 1. Obtenemos solo las ventas de HOY
        // whereDate('columna', 'fecha') compara solo la parte de la fecha (ignora la hora)
        // now() obtiene la fecha y hora actual
        $ventasHoy = Venta::with('producto')
                        ->whereDate('fecha', now()) 
                        ->latest('fecha') // 'latest' las ordena por 'fecha' (hora) descendente
                        ->get();

        // 2. Calculamos los totales del día
        $totalHoy = $ventasHoy->sum('total');
        $cantidadHoy = $ventasHoy->count();

        // 3. Pasamos los datos a la vista
        return view('dashboard', compact('ventasHoy', 'totalHoy', 'cantidadHoy'));
    }
}
