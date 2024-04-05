<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Estilos CSS -->
    <style>
        /* Estilos CSS aquí */
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>

        <!-- Formulario de registro -->
        <form action="procesar_registro.php" method="post">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>

            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>
