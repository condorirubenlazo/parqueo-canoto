<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard del Administrador</h1>
    </div>

    <!-- INICIO: Tarjetas de KPIs -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase fw-bold small">Ingresos (Mes Actual)</div>
                            <div class="h3 fw-bold mb-0">{{ number_format($ingresosTotalesMes, 2) }} Bs.</div>
                        </div>
                        <i class="bi bi-cash-coin" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase fw-bold small">Abonados Activos</div>
                            <div class="h3 fw-bold mb-0">{{ $abonadosActivos }}</div>
                        </div>
                        <i class="bi bi-person-check-fill" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow h-100">
                <div class="card-body">
                     <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase fw-bold small">Total Clientes Registrados</div>
                            <div class="h3 fw-bold mb-0">{{ $totalClientes }}</div>
                        </div>
                        <i class="bi bi-people-fill" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjetas de KPIs -->

    <!-- INICIO: Fila de Gráficos -->
    <div class="row">
        <!-- Gráfico de Ingresos Diarios -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-bar-chart-line-fill me-2"></i>Ingresos de Visitantes (Últimos 7 Días)</h6>
                </div>
                <div class="card-body">
                    <canvas id="ingresosDiariosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Tipos de Cliente -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-pie-chart-fill me-2"></i>Distribución de Abonados Activos</h6>
                </div>
                <div class="card-body">
                    <canvas id="tiposClienteChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Fila de Gráficos -->

    @push('scripts')
    <script>
        // --- GRÁFICO 1: INGRESOS DIARIOS (GRÁFICO DE BARRAS) ---
        const ctxIngresos = document.getElementById('ingresosDiariosChart').getContext('2d');
        new Chart(ctxIngresos, {
            type: 'bar',
            data: {
                labels: @json($labelsIngresosDiarios),
                datasets: [{
                    label: 'Ingresos por Día (Bs.)',
                    data: @json($dataIngresosDiarios),
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderColor: 'rgba(25, 135, 84, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return value + ' Bs.';
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Ingresos: ${context.raw.toFixed(2)} Bs.`;
                            }
                        }
                    }
                }
            }
        });

        // --- GRÁFICO 2: TIPOS DE CLIENTE (GRÁFICO DE DONA) ---
        const ctxTipos = document.getElementById('tiposClienteChart').getContext('2d');
        new Chart(ctxTipos, {
            type: 'doughnut',
            data: {
                labels: @json($labelsTiposCliente),
                datasets: [{
                    label: 'Tipos de Abonados',
                    data: @json($dataTiposCliente),
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.7)', // Azul (Primary)
                        'rgba(255, 193, 7, 0.7)'  // Amarillo (Warning)
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>