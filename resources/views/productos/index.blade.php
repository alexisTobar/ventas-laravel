@extends('layout')

@section('page-title', 'Gestión de Productos') 

@section('content')

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Lista de Productos</h5>
                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-round float-right">
                        <i class="now-ui-icons ui-1_simple-add"></i> Crear Nuevo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="text-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th class="text-right">Precio</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>
                                        @if ($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                        @else
                                            <span class="text-muted small">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td class="text-right">${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $producto->stock }}</td>
                                    
                                    <td class="text-right">
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" style="display: inline-block;">
                                            
                                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm btn-icon">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                            </a>
                                            
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
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
                    </div>
                </div>
                <div class="card-footer">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection