@extends('layout')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-md-10">
        <h1>Historial de Ventas</h1>
    </div>
    <div class="col-md-2 text-end">
        <a href="{{ route('ventas.create') }}" class="btn btn-primary">Registrar Venta</a>
    </div>
</div>

<hr>

<form action="{{ route('ventas.index') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="fecha_inicio" class="form-label">Desde:</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
        </div>
        <div class="col-md-4">
            <label for="fecha_fin" class="form-label">Hasta:</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-info">Filtrar</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary ms-2">Limpiar</a>
        </div>
    </div>
</form>
<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Producto Vendido</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Tipo de Pago</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d-m-Y') }}</td>
            <td>{{ $venta->producto->nombre ?? 'Producto Eliminado' }}</td>
            <td>{{ $venta->cantidad }}</td>
            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
            <td>{{ $venta->tipo_pago }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No se ha registrado ninguna venta.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $ventas->appends(request()->query())->links() }}
</div>
@endsection