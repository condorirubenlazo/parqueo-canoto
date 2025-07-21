<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago Mensual - Parqueo "Cañoto"</title>
    
    <!-- Bootstrap CSS para estilizar los botones y el layout general -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #e9ecef; /* Un fondo gris claro para la página */
            font-family: 'Courier New', Courier, monospace; /* Fuente de estilo máquina de escribir */
        }
        .recibo-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .recibo-header, .recibo-footer, .recibo-total {
            text-align: center;
        }
        .recibo-header h4, .recibo-header p {
            margin: 0;
        }
        .item-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .dotted-line {
            border-top: 1px dashed #333;
            margin: 1rem 0;
        }
        .recibo-total h5 {
            font-weight: bold;
        }
        
        /* --- LA MAGIA PARA LA IMPRESIÓN --- */
        /* Esta sección se aplica SÓLO cuando se va a imprimir */
        @media print {
            body {
                background-color: white; /* Fondo blanco en la impresión */
            }
            /* Ocultamos los elementos que no queremos imprimir */
            .no-print {
                display: none !important;
            }
            .recibo-container {
                max-width: 100%;
                margin: 0;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

    <div class="recibo-container">
        <div class="recibo-header">
            <h4>Parqueo "Cañoto"</h4>
            <p>Recibo de Pago de Abono</p>
        </div>

        <div class="dotted-line"></div>

        <div>
            <div class="item-line">
                <span>Fecha:</span>
                <span>{{ \Carbon\Carbon::parse($contrato->created_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="item-line">
                <span>Recibo #:</span>
                <span>{{ str_pad($contrato->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <div class="dotted-line"></div>
        
        <div>
            <p class="mb-1"><strong>Recibido de:</strong></p>
            <p class="ms-2 mb-0">{{ $contrato->cliente->nombre }} {{ $contrato->cliente->apellido }}</p>
            <p class="ms-2">CI: {{ $contrato->cliente->ci }}</p>
        </div>

        <div class="dotted-line"></div>

        <div>
            <p class="mb-2"><strong>Por concepto de:</strong></p>
            <div class="item-line ms-2">
                <span>Plan:</span>
                <span>{{ ucfirst(str_replace('_', ' ', $contrato->tipo)) }}</span>
            </div>
            <div class="item-line ms-2">
                <span>Periodo:</span>
                <span>{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="dotted-line"></div>

        <div class="recibo-total my-3">
            <h5>TOTAL PAGADO: {{ number_format($contrato->monto, 2) }} Bs.</h5>
        </div>

        <div class="dotted-line"></div>

        <div class="recibo-footer">
            <p><small>Este recibo confirma su pago mensual.</small></p>
        </div>
    </div>

    <!-- Contenedor para los botones que NO se imprimirán -->
    <div class="text-center mt-4 no-print">
        <button onclick="window.print();" class="btn btn-primary">Imprimir Recibo</button>
        <a href="{{ route('clientes.show', $contrato->cliente) }}" class="btn btn-secondary">Volver al Cliente</a>
    </div>

</body>
</html>