<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editando a: {{ $cliente->nombre }} {{ $cliente->apellido }}</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary">Datos del Cliente</h6>
        </div>
        <div class="card-body">
            {{-- Incluimos el mismo formulario, pero esta vez le pasamos los datos del cliente. Esto lo pondrá en modo "Edición". --}}
            @include('clientes.partials._form', ['cliente' => $cliente])
        </div>
    </div>
</x-app-layout>