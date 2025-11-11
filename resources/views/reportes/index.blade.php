@extends('layout')

@section('content')

<h1>Reportes de Ventas</h1>
<p class="text-muted">Estadísticas clave de tu negocio</p>
<hr>

<div class="row">
    
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Total de Ingresos (Histórico)</h5>
            </div>
            <div class="card-body text-center">
                <h1 class="display-4 fw-bold">
                    ${{ number_format($totalIngresos, 0, ',', '.') }}
                </h1>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Productos más vendidos (Unidades)</h5>
            </div>
            <div class="card-body" style="min-height: 300px;">
                <canvas id="graficoPastel"></canvas>
            </div>
        </div>
    </div>

</div> <div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ventas Diarias (Últimos 30 días)</h5>
            </div>
            <div class="card-body" style="min-height: 300px;">
                <canvas id="graficoBarras"></canvas>
            </div>
        </div>
    </div>
</div> <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Espera a que el documento esté listo
    document.addEventListener('DOMContentLoaded', function() {

        // --- CONFIGURACIÓN GRÁFICO DE PASTEL ---
        const ctxPastel = document.getElementById('graficoPastel');
        if (ctxPastel) {
            new Chart(ctxPastel, {
                type: 'doughnut', // Tipo de gráfico (dona/pastel)
                data: {
                  
                    labels: @json($pieLabels),
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: @json($pieData),
                        backgroundColor: [ // Puedes añadir más colores
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Para que se ajuste al alto del card
                    plugins: {
                        legend: {
                            position: 'right', // Mueve las etiquetas a la derecha
                        }
                    }
                }
            });
        }


        // --- CONFIGURACIÓN GRÁFICO DE BARRAS ---
        const ctxBarras = document.getElementById('graficoBarras');
        if (ctxBarras) {
            new Chart(ctxBarras, {
                type: 'bar', // Tipo de gráfico (barras)
                data: {
                    labels: @json($barLabels),
                    datasets: [{
                        label: 'Total Vendido ($)',
                        data: @json($barData),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Para que se ajuste al alto del card
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Formatear el eje Y como dinero
                                callback: function(value, index, values) {
                                    return '$' + new Intl.NumberFormat().format(value);
                                }
                            }
                        }
                    }
                }
            });
        }

    });
</script>

@endsection