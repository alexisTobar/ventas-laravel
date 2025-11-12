@extends('layout')

@section('page-title', 'Reportes de Ventas')

@section('content')

    <div class="row">
        
        <div class="col-lg-5 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="now-ui-icons business_bank text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total de Ingresos (Histórico)</p>
                                <p class="card-title" style="font-size: 2em;">${{ number_format($totalIngresos, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-md-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">Productos más vendidos (Unidades)</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="graficoPastel"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> <div class="row">
        <div class="col-md-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">Ventas Diarias (Últimos 30 días)</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="graficoBarras"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> @endsection

@section('scripts')
<script>
    // Espera a que el documento esté listo
    document.addEventListener('DOMContentLoaded', function() {

        // --- CONFIGURACIÓN GRÁFICO DE PASTEL ---
        const ctxPastel = document.getElementById('graficoPastel');
        if (ctxPastel) {
            new Chart(ctxPastel, {
                type: 'doughnut',
                data: {
                    labels: @json($pieLabels),
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: @json($pieData),
                        backgroundColor: [ // Colores de Now UI
                            '#f96332', // Naranja
                            '#2ca8ff', // Azul
                            '#00f2c3', // Verde
                            '#ffb236', // Amarillo
                            '#e14eca'  // Rosa
                        ],
                        borderWidth: 0 // Sin bordes
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { color: '#9A9A9A' } // Color de texto para el modo oscuro
                        }
                    },
                    cutout: '70%' // Hace el "agujero" de la dona
                }
            });
        }


        // --- CONFIGURACIÓN GRÁFICO DE BARRAS ---
        const ctxBarras = document.getElementById('graficoBarras');
        if (ctxBarras) {
            new Chart(ctxBarras, {
                type: 'bar',
                data: {
                    labels: @json($barLabels),
                    datasets: [{
                        label: 'Total Vendido ($)',
                        data: @json($barData),
                        backgroundColor: 'rgba(44, 168, 255, 0.6)', // Azul Now UI
                        borderColor: 'rgba(44, 168, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } // Ocultamos la leyenda
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#9A9A9A', // Color de texto para eje Y
                                callback: function(value, index, values) {
                                    return '$' + new Intl.NumberFormat().format(value);
                                }
                            },
                            grid: { color: 'rgba(255,255,255,0.1)' } // Líneas de la cuadrícula
                        },
                        x: {
                            ticks: { color: '#9A9A9A' }, // Color de texto para eje X
                            grid: { display: false } // Ocultamos cuadrícula X
                        }
                    }
                }
            });
        }

    });
</script>
@endsection