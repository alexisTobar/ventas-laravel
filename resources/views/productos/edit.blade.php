@extends('layout')

@section('page-title', 'Editar Producto')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulario de Edición</h5>
                <p class="card-category">Modificar el producto: {{ $producto->nombre }}</p>
            </div>
            <div class="card-body">
                <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion">{{ $producto->descripcion }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="number" class="form-control" name="precio" step="0.01" value="{{ $producto->precio }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" value="{{ $producto->stock }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- 
                      ==========================================================
                       ARREGLO: Usamos el componente 'custom-file' 
                       de Bootstrap 4 para el input de archivo.
                      ==========================================================
                    -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cambiar Imagen del Producto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="imagen">
                                    <label class="custom-file-label" for="customFile">Seleccionar archivo nuevo...</label>
                                </div>
                                <small class="form-text text-muted">Deja esto en blanco si no quieres cambiar la imagen actual.</small>
                            </div>
                        </div>
                        @if ($producto->imagen)
                            <div class="col-md-12 mt-3">
                                <label>Imagen Actual:</label><br>
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 150px; border-radius: 5px;">
                            </div>
                        @endif
                    </div>

                    <div class="row mt-4"> <!-- Añadido un margen superior -->
                        <div class="col-md-12 text-right">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-round">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-round">Actualizar Producto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script de Bootstrap 4 para que el input de archivo muestre el nombre
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.querySelector('.custom-file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                var fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo...';
                var nextSibling = e.target.nextElementSibling;
                if (nextSibling) {
                    nextSibling.innerText = fileName;
                }
            });
        }
    });
</script>
@endsection