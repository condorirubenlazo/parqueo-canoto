<x-app-layout>
    <h1 class="h3 mb-3">Editar Usuario: {{ $usuario->name }}</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT') {{-- Importante para la actualización --}}

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre Completo</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rol del Usuario</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="cajero" {{ old('role', $usuario->role) == 'cajero' ? 'selected' : '' }}>Cajero</option>
                        <option value="cliente" {{ old('role', $usuario->role) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        {{-- Opcional: solo muestra la opción de admin si el usuario actual es admin --}}
                        @if(Auth::user()->role === 'admin')
                        <option value="admin" {{ old('role', $usuario->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                        @endif
                    </select>
                </div>
                
                <p class="text-muted small">Nota: La contraseña no se puede cambiar desde este formulario.</p>

                <hr>

                <div class="text-end">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>