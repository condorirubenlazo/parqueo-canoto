<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Añadir Vehículo a: {{ $cliente->nombre }} {{ $cliente->apellido }}</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Datos del Vehículo</h6>
                </div>
                <div class="card-body">
                    {{-- Esta línea ahora encontrará el formulario --}}
                    @include('vehiculos.partials._form', ['cliente' => $cliente])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>