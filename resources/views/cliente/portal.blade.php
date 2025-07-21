<x-app-layout>
    <div class="container py-4">
        <!-- Encabezado de Bienvenida -->
        <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bienvenido a tu portal, {{ $user->name }}</h1>
            <p class="text-muted">Aquí puedes consultar el estado de tu abono y tus vehículos registrados.</p>
        </div>

        <div class="row">
            <!-- Columna Izquierda (Principal) -->
            <div class="col-lg-8">
                
                <!-- Tarjeta de Estado del Abono -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h6 class="m-0 font-weight-bold"><i class="bi bi-star-fill me-2"></i>Estado de tu Abono</h6>
                    </div>
                    <div class="card-body">
                        @if ($contratoActivo)
                            {{-- La clase del 'alert' cambia dinámicamente --}}
                            <div class="alert @if(now()->diffInDays($contratoActivo->fecha_fin, false) < 7) alert-warning @else alert-success @endif" role="alert">
                                <h4 class="alert-heading">
                                    <i class="bi bi-check-circle-fill"></i> ¡Plan Activo!
                                </h4>
                                <p>Tu plan de abono <strong>{{ ucfirst(str_replace('_', ' ', $contratoActivo->tipo)) }}</strong> está vigente.</p>
                                <hr>
                                <p class="mb-0">
                                    Tu plan vence el: <strong class="fs-5">{{ \Carbon\Carbon::parse($contratoActivo->fecha_fin)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</strong>.
                                    <br>
                                    <span class="text-muted"> ({{ \Carbon\Carbon::parse($contratoActivo->fecha_fin)->diffForHumans() }})</span>
                                </p>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">
                                    <i class="bi bi-exclamation-triangle-fill"></i> ¡Plan Vencido!
                                </h4>
                                <p class="mb-0">Actualmente no tienes un abono activo. Por favor, acércate a nuestras oficinas para renovar tu plan y seguir disfrutando de nuestros beneficios.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tarjeta de Vehículos Registrados -->
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-car-front-fill me-2"></i>Tus Vehículos Registrados</h6>
                    </div>
                    <div class="card-body">
                        @if($cliente->vehiculos->isNotEmpty())
                            <ul class="list-group list-group-flush">
                                @foreach($cliente->vehiculos as $vehiculo)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <strong class="font-monospace fs-5 me-3">{{ $vehiculo->placa }}</strong>
                                    </div>
                                    <span class="text-muted">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} - {{ $vehiculo->color }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center text-muted my-3">No tienes vehículos registrados en tu cuenta.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Columna Derecha (Lateral) -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-person-lines-fill me-2"></i>Tu Información de Contacto</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-5">Nombre:</dt>
                            <dd class="col-sm-7">{{ $cliente->nombre }} {{ $cliente->apellido }}</dd>

                            <dt class="col-sm-5">C.I.:</dt>
                            <dd class="col-sm-7">{{ $cliente->ci }}</dd>

                            <dt class="col-sm-5">Teléfono:</dt>
                            <dd class="col-sm-7">{{ $cliente->telefono ?? 'No registrado' }}</dd>

                            <dt class="col-sm-5">Email:</dt>
                            <dd class="col-sm-7">{{ $user->email }}</dd>
                        </dl>
                        <hr>
                        <div class="d-grid">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-key-fill me-1"></i> Editar Perfil y Contraseña
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>