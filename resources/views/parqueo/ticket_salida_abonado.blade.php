<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Salida - Parqueo Cañoto</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-top: 20px;
        }
        .ticket {
            width: 300px;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            margin: 0;
        }
        hr { border: 1px dashed #ccc; margin: 15px 0; }
        .details p {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .details p span:first-child { font-weight: bold; }
        .status-message {
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            margin: 20px 0;
        }
        .recordatorio {
            border: 2px solid #dc3545;
            padding: 10px;
            margin-top: 15px;
            text-align: center;
            color: #721c24;
            background-color: #f8d7da;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        .actions button, .actions a {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
            margin: 0 5px;
        }
        .btn-print { background-color: #007bff; color: white; }
        .btn-back { background-color: #6c757d; color: white; }

        @media print {
            body { background-color: #fff; }
            .actions { display: none; }
            .ticket { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Parqueo "Cañoto"</h1>
        <p style="text-align:center;">Comprobante de Salida</p>
        <hr>
        <div class="details">
            <p><span>Cliente:</span> <span>{{ $cliente->nombre ?? 'N/A' }} {{ $cliente->apellido ?? '' }}</span></p>
            <p><span>Placa:</span> <span>{{ $registro->placa }}</span></p>
            <p><span>Tipo:</span> <span>{{ ucfirst(str_replace('_', ' ', $registro->tipo_cliente)) }}</span></p>
        </div>

        <div class="status-message">SALIDA AUTORIZADA</div>

        {{-- Lógica para mostrar el recordatorio SÓLO si es necesario --}}
        @if ($contrato && \Carbon\Carbon::parse($contrato->fecha_fin)->diffInDays(now()) <= 2 && \Carbon\Carbon::parse($contrato->fecha_fin)->isFuture())
            <div class="recordatorio">
                <p><strong>¡ATENCIÓN!</strong></p>
                <p>Su abono vence el:<br><strong>{{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</strong></p>
            </div>
        @endif
        
        <hr>
        <p style="text-align:center;">¡Gracias por su preferencia!</p>
    </div>

    <div class="actions">
        <button onclick="window.print()" class="btn-print">Imprimir</button>
        <a href="{{ route('parqueo.index') }}" class="btn-back">Volver al Panel</a>
    </div>
</body>
</html>