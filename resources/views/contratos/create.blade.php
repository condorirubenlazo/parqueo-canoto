<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registrar Abono para: {{ $cliente->nombre }} {{ $cliente->apellido }}</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalles del Nuevo Contrato</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.contratos.store', $cliente) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">Tipo de Abono:</label>
                                <select name="tipo" id="tipo" class="form-select form-select-lg @error('tipo') is-invalid @enderror" required>
                                    <option value="abonado" {{ old('tipo', $cliente->tipo) == 'abonado' ? 'selected' : '' }}>Abonado (200 Bs/mes)</option>
                                    <option value="abonado_vip" {{ old('tipo', $cliente->tipo) == 'abonado_vip' ? 'selected' : '' }}>Abonado VIP (400 Bs/mes)</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio del Pago:</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control form-control-lg @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}" required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <h5 class="alert-heading"><i class="bi bi-info-circle-fill"></i> Importante</h5>
                            <p>Al guardar, el abono tendrá una vigencia de <strong>un mes calendario</strong> a partir de la fecha de inicio. Cualquier contrato activo anterior será desactivado.</p>
                            <hr>
                            <p class="mb-0">El tipo de cliente se actualizará al plan que selecciones.</p>
                        </div>

                        <hr>

                        <div class="mt-3 text-end">
                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-cash-stack me-1"></i>
                                Procesar Pago y Generar Recibo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>