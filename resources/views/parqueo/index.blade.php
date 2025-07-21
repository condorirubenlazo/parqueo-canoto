{{-- resources/views/parqueo/index.blade.php --}}

<x-app-layout>
    <div class="container-fluid">
        
        <!-- INICIO: Tarjetas de Estadísticas (KPIs) -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Espacios Disponibles</h5>
                            <p class="h2 fw-bold mb-0">{{ $espaciosDisponibles }}</p>
                        </div>
                        <i class="bi bi-p-circle-fill" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Vehículos Dentro</h5>
                            <p class="h2 fw-bold mb-0">{{ $espaciosOcupados }}</p>
                        </div>
                        <i class="bi bi-car-front-fill" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Capacidad Total</h5>
                            <p class="h2 fw-bold mb-0">{{ $totalEspacios }}</p>
                        </div>
                        <i class="bi bi-building" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN: Tarjetas de Estadísticas (KPIs) -->

        <div class="row">
            <!-- Columna de Formularios y Acciones -->
            <div class="col-lg-4">
                <!-- INICIO: Formularios con Pestañas -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="ingreso-tab" data-bs-toggle="tab" data-bs-target="#ingreso-tab-pane" type="button" role="tab" aria-controls="ingreso-tab-pane" aria-selected="true">
                                    <i class="bi bi-arrow-down-circle-fill text-success"></i> Ingreso
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="salida-tab" data-bs-toggle="tab" data-bs-target="#salida-tab-pane" type="button" role="tab" aria-controls="salida-tab-pane" aria-selected="false">
                                    <i class="bi bi-arrow-up-circle-fill text-danger"></i> Salida
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <!-- Pestaña de Ingreso -->
                            <div class="tab-pane fade show active" id="ingreso-tab-pane" role="tabpanel" aria-labelledby="ingreso-tab" tabindex="0">
                                <h5 class="card-title mb-3">Registrar Ingreso de Vehículo</h5>
                                <form action="{{ route('parqueo.ingreso') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="placa_ingreso" class="form-label">Placa del Vehículo:</label>
                                        <input type="text" id="placa_ingreso" name="placa" class="form-control form-control-lg text-uppercase" value="{{ old('placa') }}" required placeholder="AAA-123" autofocus>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">Registrar Ingreso</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Pestaña de Salida -->
                            <div class="tab-pane fade" id="salida-tab-pane" role="tabpanel" aria-labelledby="salida-tab" tabindex="0">
                                <h5 class="card-title mb-3">Registrar Salida y Cobrar</h5>
                                <form action="{{ route('parqueo.salida') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="placa_salida" class="form-label">Placa del Vehículo:</label>
                                        <input type="text" id="placa_salida" name="placa" class="form-control form-control-lg text-uppercase" required placeholder="AAA-123">
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-danger btn-lg">Registrar Salida</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN: Formularios con Pestañas -->
            </div>

            <!-- Columna de Estado del Parqueo (Tabla) -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Estado Actual del Parqueo</h5>
                        <span class="badge bg-dark rounded-pill">{{ $vehiculos_dentro->count() }} Vehículos</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 60vh;">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>#</th>
                                        <th>Placa</th>
                                        <th>Tipo Cliente</th>
                                        <th>Espacio Asignado</th>
                                        <th>Hora de Ingreso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vehiculos_dentro as $key => $registro)
                                        <tr>
                                            <td class="fw-bold">{{ $key + 1 }}</td>
                                            <td><span class="font-monospace fs-5">{{ $registro->placa }}</span></td>
                                            <td>
                                                <span class="badge fs-6 @if($registro->tipo_cliente == 'abonado_vip') bg-info text-dark @elseif($registro->tipo_cliente == 'abonado') bg-success @else bg-secondary @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $registro->tipo_cliente)) }}
                                                </span>
                                            </td>
                                            <td>{{ $registro->espacio_asignado }}</td>
                                            <td>{{ \Carbon\Carbon::parse($registro->fecha_hora_ingreso)->format('H:i:s') }} <small class="text-muted">({{ \Carbon\Carbon::parse($registro->fecha_hora_ingreso)->diffForHumans() }})</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                                                <h4 class="mt-2">¡El parqueo está vacío!</h4>
                                                <p class="text-muted">Un buen momento para tomar un café.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>