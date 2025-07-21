<x-guest-layout>
    <div class="card shadow-sm">
        <div class="card-header"><h3 class="text-center mb-0">Inicio de Sesión</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
</x-guest-layout>