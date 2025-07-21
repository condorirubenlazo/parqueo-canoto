<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mi Perfil</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Formulario de Información de Perfil -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información de la Cuenta</h6>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Formulario de Actualizar Contraseña -->
            <div class="card shadow-sm">
                 <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Contraseña</h6>
                </div>
                <div class="card-body">
                   @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Columna para Eliminar Cuenta (Opcional) -->
        <div class="col-lg-4">
             <div class="card shadow-sm border-danger">
                 <div class="card-header bg-danger text-white py-3">
                    <h6 class="m-0 font-weight-bold">Eliminar Cuenta</h6>
                </div>
                <div class="card-body">
                   <p class="text-muted">
                       Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
                   </p>
                   {{-- Si tienes el parcial 'delete-user-form.blade.php', puedes incluirlo aquí.
                        Si no lo necesitas, puedes borrar esta sección o el `@include`.
                        @include('profile.partials.delete-user-form') --}}
                   <button class="btn btn-danger" disabled>Eliminar Cuenta (Deshabilitado)</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>