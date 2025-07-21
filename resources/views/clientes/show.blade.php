<x-app-layout>
    {{-- Encabezado de la Página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalles del Cliente</h1>
        <div>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver a la lista
            </a>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Editar Cliente
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Datos principales y Contratos -->
        <div class="col-lg-8">
            
            <!-- Tarjeta de Datos Personales -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Datos Personales</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Nombre Completo:</dt>
                        <dd class="col-sm-9">{{ $cliente->nombre }} {{ $cliente->apellido }}</dd>

                        <dt class="col-sm-3">Cédula:</dt>
                        <dd class="col-sm-9">{{ $cliente->ci }}</dd>

                        <dt class="col-sm-3">Teléfono:</dt>
                        <dd class="col-sm-9">{{ $cliente->telefono ?? 'No registrado' }}</dd>

                        <dt class="col-sm-3">Tipo de Cliente:</dt>
                        <dd class="col-sm-9">
                            <span class="badge fs-6 @if($cliente->tipo == 'abonado_vip') bg-info text-dark @elseif($cliente->tipo == 'abonado') bg-success @else bg-secondary @endif">
                                {{ ucfirst(str_replace('_', ' ', $cliente->tipo)) }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Tarjeta de Historial de Contratos -->
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Contratos</h6>
                    <a href="{{ route('clientes.contratos.create', $cliente) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-plus-fill me-1"></i> Añadir/Renovar Contrato
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="contratosTable" width="100%">
                            <thead class="table-dark">
                                <tr>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Monto (Bs.)</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cliente->contratos->sortByDesc('fecha_inicio') as $contrato)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</td>
                                        <td>{{ $contrato->monto }}</td>
                                        <td class="text-center">
                                            @if($contrato->activo)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('contratos.destroy', $contrato) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar este registro de pago?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Borrar Contrato">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-3">Este cliente no tiene contratos registrados.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Columna Derecha: Vehículos -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Vehículos Registrados</h6>
                    <a href="{{ route('clientes.vehiculos.create', $cliente) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle-fill me-1"></i> Añadir
                    </a>
                </div>
                <div class="card-body">
                    @if($cliente->vehiculos->isNotEmpty())
                        <div class="list-group list-group-flush">
                        @foreach($cliente->vehiculos as $vehiculo)
                            <div class="list-group-item px-0">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 font-monospace">{{ $vehiculo->placa }}</h6>
                                        <small class="text-muted">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} - {{ $vehiculo->color }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="btn btn-secondary btn-sm" title="Editar Vehículo">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('vehiculos.destroy', $vehiculo) }}" method="POST" onsubmit="return confirm('¿Eliminar el vehículo {{ $vehiculo->placa }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar Vehículo"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="mb-0">Este cliente no tiene vehículos registrados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#contratosTable').DataTable({
                // CAMBIO: Se reemplaza la URL por el objeto de traducción completo
                language: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                order: [[0, 'desc']],
                "columnDefs": [ { "orderable": false, "targets": -1 } ]
            });
        });
    </script>
    @endpush

</x-app-layout>