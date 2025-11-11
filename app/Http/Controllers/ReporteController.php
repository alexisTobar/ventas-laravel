<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Muestra la página de reportes con gráficos.
     */
    public function index()
    {
        // --- Reporte 1: Total de Ingresos (para la tarjeta) ---
        $totalIngresos = Venta::sum('total');

        // --- Reporte 2: Gráfico de Pastel (Productos más vendidos) ---
        $ventasPorProducto = Venta::select('productos.nombre', DB::raw('SUM(ventas.cantidad) as total_vendido'))
            ->join('productos', 'ventas.producto_id', '=', 'productos.id')
            ->groupBy('productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->get(); // Obtenemos todos los productos vendidos

        // Preparamos los datos para Chart.js
        $pieLabels = $ventasPorProducto->pluck('nombre');
        $pieData = $ventasPorProducto->pluck('total_vendido');


        // --- Reporte 3: Gráfico de Barras (Ventas Diarias - Últimos 30 días) ---
        $ventasDiarias = Venta::select(DB::raw('DATE(fecha) as dia'), DB::raw('SUM(total) as total_diario'))
            ->where('fecha', '>=', now()->subDays(30)) // Filtramos por los últimos 30 días
            ->groupBy('dia')
            ->orderBy('dia', 'asc') // Ordenamos por fecha ascendente
            ->get();

        // Preparamos los datos para Chart.js
        $barLabels = $ventasDiarias->pluck('dia')->map(function ($date) {
            // Formateamos la fecha para que se vea mejor (ej: 10-Nov)
            return \Carbon\Carbon::parse($date)->format('d-M');
        });
        $barData = $ventasDiarias->pluck('total_diario');


        // --- Pasamos todos los datos a la vista ---
        return view('reportes.index', compact(
            'totalIngresos',
            'pieLabels',
            'pieData',
            'barLabels',
            'barData'
        ));
    }
}