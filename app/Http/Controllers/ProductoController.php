<?php

namespace App\Http\Controllers;

use App\Models\Producto; // <-- 1. IMPORTAMOS EL MODELO
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- AÑADE ESTA LÍNEA

class ProductoController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     */
    public function index()
    {
        // 2. Buscamos todos los productos en la base de datos
        // latest() los ordena del más nuevo al más viejo
        // paginate(10) los separa en páginas de 10 productos
        $productos = Producto::latest()->paginate(10);

        // 3. Devolvemos la vista 'productos.index' y le pasamos la variable 'productos'
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        // Simplemente devolvemos la vista que contiene el formulario de creación
        return view('productos.create');
    }


    // ... (deja el resto de funciones vacías por ahora)

    /**
     * Guarda el nuevo producto en la base de datos.
     */
    /**
     * Guarda el nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario (con la imagen)
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // 'nullable' (opcional), 'image' (debe ser una imagen), 'mimes' (tipos permitidos), 'max' (tamaño máx. 2MB)
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $rutaImagen = null; // Variable para guardar la ruta de la imagen

        // 2. Lógica para guardar la imagen (si se subió una)
        if ($request->hasFile('imagen')) {
            // getClientOriginalName() obtiene el nombre original
            // time() . '-' para asegurar que el nombre sea único
            $nombreImagen = time() . '-' . $request->file('imagen')->getClientOriginalName();

            // Guardamos la imagen en 'storage/app/public/productos'
            // Y la variable $rutaImagen contendrá 'productos/nombre-de-imagen.jpg'
            $rutaImagen = $request->file('imagen')->storeAs('productos', $nombreImagen, 'public');
        }

        // 3. Crear el producto en la base de datos (con la ruta de la imagen)
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'imagen' => $rutaImagen, // Guardamos la ruta en la BD
        ]);

        // 4. Redirigir
        return redirect()->route('productos.index')->with('success', '¡Producto creado exitosamente!');
    }
    public function show(string $id) {}
    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(string $id)
    {
        // 1. Buscamos el producto que queremos editar
        $producto = Producto::findOrFail($id);

        // 2. Mostramos la vista de edición y le pasamos el producto
        return view('productos.edit', compact('producto'));
    }
    /**
     * Actualiza el producto en la base de datos.
     */
    /**
     * Actualiza el producto en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 'nullable' es clave aquí
        ]);

        // 2. Buscar el producto
        $producto = Producto::findOrFail($id);

        // 3. Obtener los datos validados (excepto la imagen)
        $data = $request->only('nombre', 'descripcion', 'precio', 'stock');

        // 4. Lógica para subir/reemplazar la imagen
        if ($request->hasFile('imagen')) {

            // 4a. Guardar la nueva imagen
            $nombreImagen = time() . '-' . $request->file('imagen')->getClientOriginalName();
            $rutaImagen = $request->file('imagen')->storeAs('productos', $nombreImagen, 'public');

            // 4b. Borrar la imagen antigua (si existe)
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            // 4c. Añadir la nueva ruta a los datos
            $data['imagen'] = $rutaImagen;
        }

        // 5. Actualizar el producto en la base de datos
        $producto->update($data);

        // 6. Redirigir
        return redirect()->route('productos.index')->with('success', '¡Producto actualizado exitosamente!');
    }
    /**
     * Elimina el producto de la base de datos.
     */
    public function destroy(string $id)
    {
        // 1. Buscar el producto por su ID
        $producto = Producto::findOrFail($id);
        // findOrFail() es útil: si no encuentra el producto, dará un error 404 automáticamente.

        // 2. Eliminar el producto
        $producto->delete();

        // 3. Redirigir de vuelta a la lista con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto eliminado exitosamente!');
    }
}
