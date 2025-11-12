<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
// <-- AÑADE ESTA LÍNEA (si no está)// <-- 1. IMPORTANTE para transacciones

class VentaController extends Controller
{
    // ... (la función index() sigue vacía) ...
    /**
     * Muestra una lista de todas las ventas (Historial).
     */
    /**
     * Muestra una lista de todas las ventas (Historial).
     */
    public function index(Request $request)
    {
        // 1. Iniciamos la consulta cargando producto Y usuario
        $query = Venta::with(['producto', 'user']);

        // 2. FILTRO DE ROL: Si no es admin, solo ve sus ventas
        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        // 3. Filtro de Fecha de Inicio (que ya tenías)
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        // 4. Filtro de Fecha de Fin (que ya tenías)
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        // 5. Ordenamos y Paginamos
        $ventas = $query->latest('fecha')->paginate(15);

        return view('ventas.index', [
            'ventas' => $ventas,
            'input' => $request->all()
        ]);
    }


    public function create()
    {
        $productos = Producto::all();
        return view('ventas.create', compact('productos'));
    }

    /**
     * Guarda la nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        // 2. Validación de los datos del formulario
        $request->validate([
            'producto_id' => 'required|exists:productos,id', // El producto debe existir en la tabla productos
            'cantidad' => 'required|integer|min:1',
            'tipo_pago' => 'required|in:efectivo,debito,credito',
        ]);

        // 3. Usamos una "Transacción" de Base de Datos
        // Esto asegura que si el paso B falla, el paso A se revierte.
        // O se hacen las dos cosas (guardar venta y actualizar stock) o no se hace ninguna.
        try {

            DB::beginTransaction(); // Inicia la transacción

            // 4. Encontramos el producto y verificamos el stock
            $producto = Producto::findOrFail($request->producto_id);

            if ($producto->stock < $request->cantidad) {
                // Si no hay stock, detenemos todo y mandamos un error
                return back()->withErrors(['cantidad' => 'No hay stock suficiente para este producto.']);
            }

            // 5. Calculamos el total
            $totalVenta = $producto->precio * $request->cantidad;

            // 6. Creamos la venta
            Venta::create([
                'producto_id' => $request->producto_id,
                'user_id' => auth()->id(),
                'cantidad' => $request->cantidad,
                'total' => $totalVenta,
                'fecha' => now(),
                'tipo_pago' => $request->tipo_pago,
            ]);

            // 7. Descontamos el stock del producto
            $producto->stock = $producto->stock - $request->cantidad;
            $producto->save(); // Guardamos el cambio en el producto

            DB::commit(); // Todo salió bien, confirmamos los cambios

            // 8. Redirigimos con mensaje de éxito
           return redirect()->route('ventas.index')->with('success', '¡Venta registrada exitosamente!');
        } catch (\Exception $e) {
            DB::rollBack(); // Algo salió mal, revertimos todo
            return back()->withErrors(['error' => 'Ocurrió un error al registrar la venta: ' . $e->getMessage()]);
        }
    }

    // ... (el resto de funciones siguen vacías)
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
