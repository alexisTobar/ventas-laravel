@extends('layout')

@section('content')

<h1>Dashboard - Ventas del Día</h1>
<p class="text-muted">Mostrando las ventas registradas hoy, {{ now()->format('d \d\e M \d\e Y') }}</p>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Vendido Hoy</h5>
                <h2 class="card-text">${{ number_format($totalHoy, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Cantidad de Ventas Hoy</h5>
                <h2 class="card-text">{{ $cantidadHoy }}</h2>
            </div>
        </div>
    </div>
</div>

<hr>
<h3>Detalle de Ventas de Hoy</h3>

<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Hora</th>
            <th>Producto Vendido</th>
            <th>Imagen</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Tipo de Pago</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ventasHoy as $venta)
            <tr>
                <td>{{ $venta->fecha->format('h:i A') }}</td>
                <td>{{ $venta->producto->nombre ?? 'Producto Eliminado' }}</td>
                <td>
                    @if ($venta->producto && $venta->producto->imagen)
                        <img src="{{ asset('storage/' . $venta->producto->imagen) }}" alt="{{ $venta->producto->nombre }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                    @else
                        <span style="font-size: 12px; color: #888;">Sin imagen</span>
                    @endif
                </td>
                <td>{{ $venta->cantidad }}</td>
                <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>{{ $venta->tipo_pago }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Aún no se han registrado ventas hoy.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection