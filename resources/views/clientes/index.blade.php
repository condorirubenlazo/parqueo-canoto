<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestión de Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle-fill me-1"></i>
            Crear Nuevo Cliente
        </a>
    </div>

    {{-- Alertas de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Clientes Registrados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="clientesTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>CI</th>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Tipo de Cliente</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->ci }}</td>
                                <td>{{ $cliente->apellido }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge fs-6 @if($cliente->tipo == 'abonado_vip') bg-info text-dark @elseif($cliente->tipo == 'abonado') bg-success @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ', $cliente->tipo)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-info btn-sm" title="Ver Detalles"><i class="bi bi-eye-fill"></i></a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-secondary btn-sm" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay clientes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#clientesTable').DataTable({
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
                order: [[1, 'asc']] // Ordenar por la segunda columna (Apellido)
            });
        });
    </script>
    @endpush

</x-app-layout>