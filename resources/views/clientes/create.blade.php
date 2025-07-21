<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Crear Nuevo Cliente</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary">Datos del Cliente</h6>
        </div>
        <div class="card-body">
            {{-- Incluimos el formulario parcial. No pasamos la variable $cliente, por lo que estará en modo "Creación". --}}
            @include('clientes.partials._form')
        </div>
    </div>
</x-app-layout>