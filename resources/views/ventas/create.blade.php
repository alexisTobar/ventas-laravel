@extends('layout')

@section('content')

<h1>Registrar Nueva Venta</h1>
<hr>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Ups! Hubo un problema:</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        Formulario de Venta
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="mb-2">
                <label for="buscadorProductos" class="form-label fs-5 fw-bold">Buscar Producto (por nombre):</label>
                <input type="text" id="buscadorProductos" class="form-control form-control-lg" placeholder="Escribe el nombre del producto para filtrar..." autofocus>
            </div>
        </div>
    </div>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">1. Seleccione un Producto:</label>

                <div style="height: 600px; overflow-y: auto; border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f8f9fa;">

                    <div class="row">

                        @forelse ($productos as $producto)
                        <div class="col-md-4 mb-3 producto-filterable-card">

                            <div class="card h-70 shadow-sm product-card" style="cursor: pointer;">

                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                    class="card-img-top"
                                    alt="{{ $producto->nombre }}"
                                    style="height: 180px; object-fit: cover; border-bottom: 1px solid #ddd;">

                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title" style="font-size: 1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $producto->nombre }}
                                    </h5>

                                    <p class="card-text text-success mb-1">
                                        ${{ number_format($producto->precio, 0) }}
                                    </p>
                                    <p class="card-text text-muted" style="font-size: 0.8rem;">
                                        Stock: {{ $producto->stock }}
                                    </p>

                                    <div class="form-check d-inline-block mt-auto">
                                        <input class="form-check-input" type="radio" name="producto_id" id="prod-{{ $producto->id }}" value="{{ $producto->id }}" required>
                                        <label class="form-check-label" for="prod-{{ $producto->id }}">
                                            Seleccionar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No hay productos con imagen para mostrar.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <hr>
                <label class="form-label">2. Complete los detalles de la venta:</label>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cantidad" class="form-label">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" min="1" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tipo_pago" class="form-label">Tipo de Pago:</label>
                        <select name="tipo_pago" id="tipo_pago" class="form-select" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="debito">Débito</option>
                            <option value="credito">Crédito</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Venta</button>
            </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // CAMBIO 2: Cambiamos el selector de '.card' a '.product-card'
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            card.addEventListener('click', (event) => {

                // Evitamos que el clic en el label o el input dispare el evento dos veces
                if (event.target.tagName === 'INPUT' || event.target.tagName === 'LABEL') {
                    return;
                }

                const radio = card.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });
    });
    // Espera a que el documento (DOM) esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Selecciona el input de búsqueda
        const buscador = document.getElementById('buscadorProductos');
        
        // 2. Selecciona TODAS las tarjetas de productos
        //    Usamos la clase que acabamos de añadir
        const tarjetas = document.querySelectorAll('.producto-filterable-card');

        // 3. Escucha el evento 'keyup' (cada vez que el usuario suelta una tecla)
        buscador.addEventListener('keyup', function(evento) {
            
            // 4. Obtiene el texto de búsqueda (en minúsculas para que no distinga)
            const textoBusqueda = evento.target.value.toLowerCase();

            // 5. Recorre cada tarjeta de producto
            tarjetas.forEach(function(tarjeta) {
                
                // 6. Busca el nombre del producto dentro de la tarjeta
                const nombreProducto = tarjeta.querySelector('.card-title').textContent.toLowerCase();

                // 7. Compara y muestra/oculta la tarjeta
                if (nombreProducto.includes(textoBusqueda)) {
                    tarjeta.style.display = ''; // Muestra la tarjeta (display: block)
                } else {
                    tarjeta.style.display = 'none'; // Oculta la tarjeta
                }
            });
        });
    });
</script>

@endsection