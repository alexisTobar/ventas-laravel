@extends('layout')

@section('page-title', 'Registrar Nueva Venta')

@section('content')

    <!-- Bloque de Alertas -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>¡Ups! Hubo un problema:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Formulario de Búsqueda -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">1. Buscar Producto (por nombre)</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <input type="text" id="buscadorProductos" class="form-control" placeholder="Escribe el nombre del producto para filtrar..." autofocus>
            </div>
        </div>
    </div>

    <!-- Formulario de Venta -->
    <form id="formVenta" action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">2. Seleccionar Producto</h5>
                <p class="text-danger" id="error_no_seleccion" style="display:none;">Por favor, selecciona un producto.</p>
            </div>
            <div class="card-body">
                <!-- Contenedor de la cuadrícula de productos -->
                <div id="lista_productos" class="row" style="max-height: 400px; overflow-y: auto; padding: 10px;">
                    <!-- Los productos se cargarán aquí por JavaScript -->
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">3. Detalles de la Venta</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" required disabled> 
                            <p class="text-danger" id="error_stock" style="display:none;"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipo_pago">Tipo de Pago:</label>
                            <select id="tipo_pago" name="tipo_pago" class="form-control" required style="height: 45px;">
                                <option value="efectivo">Efectivo</option>
                                <option value="debito">Débito</option>
                                <option value="credito">Crédito</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-round">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-round" id="btn_registrar_venta" disabled>Registrar Venta</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    // Almacena los productos cargados para evitar llamadas API innecesarias
    let allProducts = [];
    let productoSeleccionadoId = null;
    let stockDisponible = 0;

    // Función para renderizar los productos en la cuadrícula
    function renderProducts(productos) {
        const listaProductosDiv = document.getElementById('lista_productos');
        listaProductosDiv.innerHTML = ''; // Limpiar productos anteriores
        
        if (productos.length === 0) {
            listaProductosDiv.innerHTML = '<div class="col-12 text-center text-muted">No se encontraron productos.</div>';
            return;
        }

        productos.forEach(producto => {
            const productImage = producto.imagen ? `/storage/${producto.imagen}` : 'https://placehold.co/300x200/e2e2e2/9a9a9a?text=Sin+Imagen';
            
            const productCardHTML = `
                <div class="col-lg-4 col-md-6">
                    <input class="form-check-input" type="radio" 
                           name="producto_id" 
                           id="producto_${producto.id}" 
                           value="${producto.id}" 
                           data-stock="${producto.stock}" 
                           style="display:none;" required>
                    
                    <label class="card card-product text-center" for="producto_${producto.id}" style="cursor: pointer; margin-bottom: 0; border: 2px solid transparent;">
                        <div class="card-image" style="height: 180px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <!-- 
                              ==========================================================
                               ARREGLO: Cambiado 'object-fit: cover' a 'object-fit: contain'
                               para que la imagen no se corte.
                              ==========================================================
                            -->
                            <img class="img-fluid" src="${productImage}" alt="${producto.nombre}" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                ${producto.nombre}
                            </h5>
                            <p class="card-description" style="font-size: 0.9rem;">
                                Stock: ${producto.stock} | $${parseInt(producto.precio).toLocaleString('es-CL')}
                            </p>
                            <span class="btn btn-sm btn-outline-primary btn-round radio-select-indicator">Seleccionar</span>
                        </div>
                    </label>
                </div>
            `;
            listaProductosDiv.innerHTML += productCardHTML;
        });

        attachRadioListeners();
    }

    // Filtra los productos que ya están cargados
    function filterAndRenderProducts(filtro) {
        const filtroLower = filtro.toLowerCase();
        const productosFiltrados = allProducts.filter(producto => 
            producto.nombre.toLowerCase().includes(filtroLower)
        );
        renderProducts(productosFiltrados);
    }

    // Carga inicial de TODOS los productos
    function fetchAllProducts() {
        fetch(`/api/productos`)
            .then(response => response.json())
            .then(productos => {
                allProducts = productos; 
                renderProducts(allProducts);
            })
            .catch(error => console.error('Error al cargar productos:', error));
    }
    
    // Asigna los listeners a los radio buttons
    function attachRadioListeners() {
        document.querySelectorAll('input[name="producto_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.card-product').forEach(c => {
                    c.style.border = '2px solid transparent';
                    c.querySelector('.radio-select-indicator').classList.remove('btn-primary');
                    c.querySelector('.radio-select-indicator').classList.add('btn-outline-primary');
                });
                
                const card = this.nextElementSibling; 
                card.style.border = '2px solid #f96332'; 
                card.querySelector('.radio-select-indicator').classList.add('btn-primary');
                card.querySelector('.radio-select-indicator').classList.remove('btn-outline-primary');

                productoSeleccionadoId = this.value;
                stockDisponible = parseInt(this.dataset.stock, 10);
                
                const cantidadInput = document.getElementById('cantidad');
                cantidadInput.max = stockDisponible;
                cantidadInput.disabled = false;
                if (cantidadInput.value > stockDisponible || cantidadInput.value <= 0) {
                     cantidadInput.value = 1;
                }
                validarCantidad();
                actualizarBotonRegistrar();
                document.getElementById('error_no_seleccion').style.display = 'none';
            });
        });
    }

    // Listener para el campo de búsqueda (filtra localmente)
    document.getElementById('buscadorProductos').addEventListener('keyup', function() {
        filterAndRenderProducts(this.value);
    });

    // Función de validación de cantidad
    function validarCantidad() {
        const cantidadInput = document.getElementById('cantidad');
        const errorStockDiv = document.getElementById('error_stock');
        
        if (cantidadInput.disabled) {
            return false;
        }
        const cantidad = parseInt(cantidadInput.value, 10);

        if (isNaN(cantidad) || cantidad <= 0) {
            errorStockDiv.textContent = 'La cantidad debe ser al menos 1.';
            errorStockDiv.style.display = 'block';
            cantidadInput.classList.add('is-invalid');
            return false;
        } else if (cantidad > stockDisponible) {
            errorStockDiv.textContent = `No hay suficiente stock. Disponible: ${stockDisponible}`;
            errorStockDiv.style.display = 'block';
            cantidadInput.classList.add('is-invalid');
            return false;
        } else {
            errorStockDiv.style.display = 'none';
            cantidadInput.classList.remove('is-invalid');
            return true;
        }
    }

    // Listener para el campo de cantidad
    const cantidadInput = document.getElementById('cantidad');
    if(cantidadInput) {
        cantidadInput.addEventListener('input', function() {
            validarCantidad();
            actualizarBotonRegistrar();
        });
    }

    // Función para actualizar el botón de registro
    function actualizarBotonRegistrar() {
        const btnRegistrar = document.getElementById('btn_registrar_venta');
        const productoSeleccionado = productoSeleccionadoId !== null;
        const cantidadValida = validarCantidad(); 

        if (productoSeleccionado && cantidadValida) {
            btnRegistrar.disabled = false;
        } else {
            btnRegistrar.disabled = true;
        }
    }

    // Listener para el submit del formulario
    document.getElementById('formVenta').addEventListener('submit', function(event) {
        if (productoSeleccionadoId === null) {
            document.getElementById('error_no_seleccion').style.display = 'block';
            event.preventDefault(); 
            return;
        }
        
        if (!validarCantidad()) {
             event.preventDefault();
             return;
        }
        
        // ¡Ya no es necesario añadir el 'producto_id' oculto!
    });

    // Carga inicial de productos
    fetchAllProducts();
    // Validar estado inicial del botón
    actualizarBotonRegistrar();

</script>
@endsection