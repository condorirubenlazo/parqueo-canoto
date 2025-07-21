<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Ingreso - Parqueo Cañoto</title>
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
            border: 2px dashed #333;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; margin-top: 0; }
        hr { border: 1px dashed #ccc; margin: 15px 0; }
        .details p {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 1.1em;
        }
        .details p span:first-child { font-weight: bold; }
        .espacio {
            text-align: center;
            font-size: 2.5em;
            font-weight: bold;
            margin: 15px 0;
            border: 2px solid #000;
            padding: 10px;
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
            .ticket { box-shadow: none; border: 2px dashed #333; }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Parqueo "Cañoto"</h1>
        <p style="text-align:center;">TICKET DE INGRESO</p>
        <hr>
        <div class="details">
            <p><span>Placa:</span> <span>{{ $registro->placa }}</span></p>
            <p><span>Ingreso:</span> <span>{{ \Carbon\Carbon::parse($registro->fecha_hora_ingreso)->format('d/m/y H:i') }}</span></p>
            <p><span>Tipo:</span> <span>{{ ucfirst(str_replace('_', ' ', $registro->tipo_cliente)) }}</span></p>
        </div>
        <p style="text-align:center; margin-top:20px; font-weight:bold;">Su espacio asignado es:</p>
        <div class="espacio">{{ $registro->espacio_asignado }}</div>
        <hr>
        <p style="text-align:center; font-weight:bold;">Presente este ticket al salir.</p>
    </div>

    <div class="actions">
        <button onclick="window.print()" class="btn-print">Imprimir Ticket</button>
        <a href="{{ route('parqueo.index') }}" class="btn-back">Volver al Panel</a>
    </div>
</body>
</html>