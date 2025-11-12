@extends('layout')

@section('page-title', 'Crear Producto')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulario de Nuevo Producto</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre del producto" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" placeholder="Descripción (opcional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="number" class="form-control" name="precio" step="0.01" placeholder="Ej: 7000" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" placeholder="Ej: 100" required>
                            </div>
                        </div>
                    </div>

                    <!-- 
                      ==========================================================
                       ARREGLO: Reemplazamos el input de archivo por
                       el componente 'custom-file' de Bootstrap 4.
                      ==========================================================
                    -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Imagen del Producto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="imagen">
                                    <label class="custom-file-label" for="customFile">Seleccionar archivo...</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4"> <!-- Añadido un margen superior -->
                        <div class="col-md-12 text-right">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-round">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-round">Guardar Producto</button>
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