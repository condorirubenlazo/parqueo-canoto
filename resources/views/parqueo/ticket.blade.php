<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago - Parqueo Cañoto</title>
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
        h1 { font-size: 1.2em; }
        h2 { font-size: 1.8em; color: #000; font-weight: bold; }
        hr { border: 1px dashed #ccc; margin: 15px 0; }
        .details p {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .details p span:first-child { font-weight: bold; }
        .total {
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 15px;
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

        /* Estilos para la impresión */
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
        <p style="text-align:center;">Comprobante de Pago</p>
        <hr>
        <div class="details">
            <p><span>Placa:</span> <span>{{ $registro->placa }}</span></p>
            <p><span>Ingreso:</span> <span>{{ \Carbon\Carbon::parse($registro->fecha_hora_ingreso)->format('d/m/y H:i') }}</span></p>
            <p><span>Salida:</span> <span>{{ \Carbon\Carbon::parse($registro->fecha_hora_salida)->format('d/m/y H:i') }}</span></p>
            <p><span>Tiempo:</span> <span>{{ $tiempoEstadia }}</span></p>
        </div>
        <div class="total">
            <h2>TOTAL: {{ $registro->monto_cobrado }} Bs.</h2>
        </div>
        <hr>
        <p style="text-align:center; font-size: 0.8em;">¡Gracias por su visita!</p>
    </div>

    <div class="actions">
        <button onclick="window.print()" class="btn-print">Imprimir Ticket</button>
        <a href="{{ route('parqueo.index') }}" class="btn-back">Volver al Panel</a>
    </div>
</body>
</html>