<form action="{{ isset($cliente) ? route('clientes.update', $cliente) : route('clientes.store') }}" method="POST">
    @csrf
    @if(isset($cliente))
        @method('PUT')
    @endif

    <div class="row">
        {{-- Fila de Datos Personales --}}
        <div class="col-md-6 mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cliente->nombre ?? '') }}" required autofocus>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="apellido" class="form-label">Apellido:</label>
            <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido', $cliente->apellido ?? '') }}" required>
            @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="ci" class="form-label">Cédula de Identidad (CI):</label>
            <input type="text" name="ci" id="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci', $cliente->ci ?? '') }}" required>
            @error('ci') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="telefono" class="form-label">Teléfono (Opcional):</label>
            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $cliente->telefono ?? '') }}">
            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        {{-- CAMPO PARA VINCULAR USUARIO --}}
        <div class="col-md-6 mb-3">
            <label for="user_id" class="form-label fw-bold">Cuenta de Usuario Vinculada:</label>
            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                <option value="">Ninguna (El cliente no podrá iniciar sesión)</option>
                @foreach($usuarios_disponibles as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('user_id', $cliente->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }} ({{ $usuario->email }})
                    </option>
                @endforeach
            </select>
            <div class="form-text">
                <i class="bi bi-info-circle"></i> Solo se muestran usuarios con rol 'cliente' que no estén ya asignados.
            </div>
            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tipo" class="form-label">Tipo de Cliente:</label>
            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                <option value="" disabled {{ old('tipo', $cliente->tipo ?? '') == '' ? 'selected' : '' }}>Seleccione un tipo...</option>
                {{-- LÍNEA AÑADIDA --}}
                <option value="visitante" {{ old('tipo', $cliente->tipo ?? '') == 'visitante' ? 'selected' : '' }}>Visitante</option>
                <option value="abonado" {{ old('tipo', $cliente->tipo ?? '') == 'abonado' ? 'selected' : '' }}>Abonado</option>
                <option value="abonado_vip" {{ old('tipo', $cliente->tipo ?? '') == 'abonado_vip' ? 'selected' : '' }}>Abonado VIP</option>
            </select>
            @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    
    <hr>

    <div class="mt-3 text-end">
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i>Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ isset($cliente) ? 'Actualizar Cliente' : 'Guardar Cliente' }}
        </button>
    </div>
</form>