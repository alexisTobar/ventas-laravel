@extends('layout')

@section('content')

<div class="row">
    <div class="col-md-10">
        <h1>Lista de Productos</h1>
    </div>
    <div class="col-md-2 text-end">
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear Nuevo Producto</a>
    </div>
</div>


@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<hr>

<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($productos as $producto)
        <tr>
            <td>{{ $producto->id }}</td>
            <td>
                @if ($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                @else
                <span style="font-size: 12px; color: #888;">Sin imagen</span>
                @endif
            </td>
            <td>{{ $producto->nombre }}</td>
            <td>{{$producto->descripcion}}</td>
            <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
            <td>{{ $producto->stock }}</td>
            <td style="display: flex; gap: 5px;">

                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>
                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No hay productos registrados.</td>
        </tr>
        @endforelse
    </tbody>

</table>

<div class="mt-3">
    {{ $productos->links() }}
</div>
@endsection