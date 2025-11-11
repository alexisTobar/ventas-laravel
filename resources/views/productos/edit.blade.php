@extends('layout')

@section('content')

<h1>Editar Producto: {{ $producto->nombre }}</h1>
<hr>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        Formulario de Edición
    </div>
    <div class="card-body">

        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Cambiar Imagen del Producto:</label>
                <input type="file" id="imagen" name="imagen" class="form-control">
                <small class="form-text text-muted">Deja esto en blanco si no quieres cambiar la imagen actual.</small>
            </div>

            @if ($producto->imagen)
            <div class="mb-3">
                <label>Imagen Actual:</label><br>
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 150px; border-radius: 5px;">
            </div>
            @endif
            <div class="row">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" id="precio" name="precio" step="0.01" class="form-control" value="{{ $producto->precio }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stock:</label>
                        <input type="number" id="stock" name="stock" class="form-control" value="{{ $producto->stock }}" required>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                </div>
        </form>
    </div>
</div>

@endsection