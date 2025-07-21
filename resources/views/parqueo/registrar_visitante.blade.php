<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Visitante - Parqueo Cañoto</title>
    <style>
        /* (Puedes copiar los mismos estilos del index.blade.php) */
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; }
        .container { max-width: 500px; margin: auto; }
        .form-section { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
        h1 { color: #333; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ddd; }
        button { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .placa-display { background-color: #e9ecef; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h1>Registrar Datos de Visitante</h1>
            <p>El vehículo con la placa indicada no está registrado. Por favor, complete los siguientes datos.</p>
            <form action="{{ route('parqueo.ingreso') }}" method="POST">
                @csrf
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" value="{{ $placa }}" readonly class="placa-display">

                <input type="hidden" name="vehiculo_conocido" value="0">
                
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>

                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required>
                
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required>

                <button type="submit">Confirmar y Registrar Ingreso</button>
            </form>
        </div>
    </div>
</body>
</html>