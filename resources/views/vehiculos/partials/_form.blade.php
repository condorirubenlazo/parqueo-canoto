{{--
    Formulario inteligente para Vehículos.
    Requiere que la variable $cliente siempre esté presente.
    Detecta el modo "Edición" si la variable $vehiculo existe.
--}}
<form action="{{ isset($vehiculo) ? route('vehiculos.update', $vehiculo) : route('clientes.vehiculos.store', $cliente) }}" method="POST">
    @csrf
    @if(isset($vehiculo))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="placa" class="form-label">Placa:</label>
        <input type="text" name="placa" id="placa" class="form-control text-uppercase @error('placa') is-invalid @enderror" value="{{ old('placa', $vehiculo->placa ?? '') }}" required autofocus>
        @error('placa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="marca" class="form-label">Marca:</label>
        <input type="text" name="marca" id="marca" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca', $vehiculo->marca ?? '') }}" required>
        @error('marca')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="modelo" class="form-label">Modelo:</label>
        <input type="text" name="modelo" id="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo', $vehiculo->modelo ?? '') }}" required>
         @error('modelo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="color" class="form-label">Color:</label>
        <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $vehiculo->color ?? '') }}" required>
        @error('color')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <hr>

    <!-- Botones de Acción -->
    <div class="mt-3 text-end">
        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i>
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ isset($vehiculo) ? 'Actualizar Vehículo' : 'Guardar Vehículo' }}
        </button>
    </div>
</form>