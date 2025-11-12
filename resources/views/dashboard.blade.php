@extends('layout')

@section('page-title', 'Dashboard')

@section('content')

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="now-ui-icons business_money-coins text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total Vendido Hoy</p>
                                <p class="card-title" style="font-size: 2em;">${{ number_format($totalHoy, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="now-ui-icons shopping_cart-simple text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Cantidad de Ventas Hoy</p>
                                <p class="card-title" style="font-size: 2em;">{{ $cantidadHoy }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detalle de Ventas de Hoy</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="text-primary">
                                <tr>
                                    <th>Hora</th>
                                    <th>Producto</th>
                                    <th>Imagen</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Total</th>
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
                                                <img src="{{ asset('storage/' . $venta->producto->imagen) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                            @else
                                                <span class="text-muted small">Sin imagen</span>
                                            @endif
                                        </td>
                                        <td class="text-right">{{ $venta->cantidad }}</td>
                                        <td class="text-right">${{ number_format($venta->total, 0, ',', '.') }}</td>
                                        <td>{{ $venta->tipo_pago }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aún no se han registrado ventas hoy.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role == 'admin' && !$productosBajoStock->isEmpty())
    <div class="row">
        <div class="col-md-12">
            <div class="card card-stats" style="background-color: #f9d6d5; border: 1px solid #f5c6cb;">
                <div class="card-header">
                    <h5 class="card-title text-danger">🚨 ¡Alerta de Stock Bajo!</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Los siguientes productos tienen 5 unidades o menos y necesitan reponerse.</p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="text-danger">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Stock Actual</th>
                                    <th class="text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productosBajoStock as $producto)
                                <tr>
                                    <td><strong>{{ $producto->nombre }}</strong></td>
                                    <td class="text-center"><span class="badge badge-danger" style="font-size: 1em;">{{ $producto->stock }}</span></td>
                                    <td class="text-right">
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm btn-round">
                                            Reponer Stock
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection