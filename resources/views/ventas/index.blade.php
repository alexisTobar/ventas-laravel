@extends('layout')

@section('page-title', 'Historial de Ventas')

@section('content')

    <!-- Alertas -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- Fin Alertas -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Filtros de Búsqueda</h5>
                    <!-- Botón de Crear Venta -->
                    <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-round">
                        <i class="now-ui-icons ui-1_simple-add"></i> Registrar Nueva Venta
                    </a>
                </div>
                <div class="card-body">
                    <!-- Formulario de Filtro por Fechas -->
                    <form action="{{ route('ventas.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Desde:</label>
                                    <input type="date" class="form-control" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hasta:</label>
                                    <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin') }}">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center pt-3">
                                <button type="submit" class="btn btn-info btn-round">
                                    <i class="now-ui-icons ui-1_zoom-bold"></i> Filtrar
                                </button>
                                <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-round ms-2">Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Resultados del Historial</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="text-primary">
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Producto Vendido</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Total</th>
                                    <th>Tipo de Pago</th>
                                    
                                    @if(auth()->check() && auth()->user()->role == 'admin')
                                        <th>Vendedor</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->id }}</td>
                                    <td>{{ $venta->fecha->format('d-m-Y h:i A') }}</td>
                                    <td>{{ $venta->producto->nombre ?? 'Producto Eliminado' }}</td>
                                    <td class="text-right">{{ $venta->cantidad }}</td>
                                    <td class="text-right">${{ number_format($venta->total, 0, ',', '.') }}</td>
                                    <td>{{ $venta->tipo_pago }}</td>

                                    @if(auth()->check() && auth()->user()->role == 'admin')
                                        <td>{{ $venta->user->name ?? 'N/A' }}</td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    @php
                                        $colspan = (auth()->check() && auth()->user()->role == 'admin') ? 7 : 6;
                                    @endphp
                                    <td colspan="{{ $colspan }}" class="text-center">No se han registrado ventas para este filtro.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Enlaces de Paginación -->
                    {{ $ventas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
