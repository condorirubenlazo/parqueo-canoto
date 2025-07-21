<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestión de Usuarios</h1>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle-fill me-1"></i>
            Crear Nuevo Usuario
        </a>
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Usuarios del Sistema</h6>
        </div>
        <div class="card-body">
            
            {{-- INICIO DE LA LÓGICA DE CONTROL --}}
            @if($usuarios->isNotEmpty())
                {{-- Si HAY usuarios, mostramos la tabla completa --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="usuariosTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        <span class="badge fs-6 
                                            @if($usuario->role == 'admin') bg-primary
                                            @elseif($usuario->role == 'cajero') bg-secondary
                                            @else bg-info @endif">
                                            {{ ucfirst($usuario->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-secondary btn-sm" title="Editar Usuario"><i class="bi bi-pencil-fill"></i></a>
                                            @if($usuario->role !== 'admin')
                                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Está seguro?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Usuario"><i class="bi bi-trash-fill"></i></button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger btn-sm" title="Los administradores no se pueden eliminar" disabled><i class="bi bi-trash-fill"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                {{-- Si NO HAY usuarios, mostramos un mensaje amigable SIN tabla --}}
                <div class="text-center py-4">
                    <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">No hay otros usuarios registrados en el sistema.</p>
                </div>
            @endif
            {{-- FIN DE LA LÓGICA DE CONTROL --}}

        </div>
    </div>

    {{-- El script SÓLO se incluirá si hay usuarios, evitando el error --}}
    @if($usuarios->isNotEmpty())
        @push('scripts')
        <script>
            $(document).ready(function() {
                $('#usuariosTable').DataTable({
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
                        "aria": { "sortAscending": ": Activar para ordenar la columna de manera ascendente", "sortDescending": ": Activar para ordenar la columna de manera descendente" }
                    },
                    order: [[0, 'asc']],
                    "columnDefs": [ { "orderable": false, "targets": -1 } ]
                });
            });
        </script>
        @endpush
    @endif
    
</x-app-layout>