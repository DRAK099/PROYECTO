<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado EoQ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado del cálculo de la Cantidad Económica de Pedido (EoQ)</h1>
        <?php
        // Verificar si se ha enviado el resultado del cálculo
        if (isset($_GET["eoq"])) {
            // Obtener el resultado del cálculo de la URL
            $eoq = $_GET["eoq"];

            // Mostrar el resultado
            echo "<p>La Cantidad Económica de Pedido (EoQ) es: " . $eoq . " unidades</p>";
        } else {
            // Si no se ha enviado el resultado, mostrar un mensaje de error
            echo "<p>Error: No se ha proporcionado la Cantidad Económica de Pedido (EoQ).</p>";
        }
        ?>
    </div>
</body>
</html>
