@extends('layout')

@section('content')

<h1>Crear Nuevo Producto</h1>
<hr>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        Formulario de Nuevo Producto
    </div>
    <div class="card-body">

        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen del Producto:</label>
        <input type="file" id="imagen" name="imagen" class="form-control">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stock:</label>
            <input type="number" id="stock" name="stock" class="form-control" required>
        </div>
    </div>

    <div class="text-end">
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar Producto</button>
    </div>
    </form>
</div>
</div>

@endsection