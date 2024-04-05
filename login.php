<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Estilos CSS -->
    <style>
        /* Estilos CSS aquí */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <!-- Formulario de inicio de sesión -->
        <form action="login.php" method="post">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>

            <input type="submit" value="Iniciar Sesión">
        </form>

        <!-- Mensaje de error (si hay) -->
        <?php
        // Verificar si se han enviado datos del formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los datos del formulario
            $nombre_usuario = $_POST["nombre_usuario"];
            $contraseña = $_POST["contraseña"];

            // Conectar a la base de datos (reemplaza con tus propios datos)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "erp";

            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Error de conexión a la base de datos: " . $conn->connect_error);
            }

            // Consulta SQL para verificar las credenciales del usuario
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                // El usuario existe, verificar la contraseña
                $row = $result->fetch_assoc();
                if (password_verify($contraseña, $row["contraseña"])) {
                    // Contraseña válida, iniciar sesión y redirigir al usuario a la página de inicio
                    session_start();
                    $_SESSION["nombre_usuario"] = $nombre_usuario;

                    // Redirigir al usuario al index
                    header("Location: index.html");
                    exit;
                } else {
                    // Contraseña incorrecta, mostrar mensaje de error
                    echo '<p class="error">La contraseña ingresada es incorrecta.</p>';
                }
            } else {
                // El usuario no existe, mostrar mensaje de error
                echo '<p class="error">El nombre de usuario ingresado no existe.</p>';
            }

            // Cerrar conexión
            $conn->close();
        }
        ?>
        <!-- Enlace para registrarse -->
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
    </div>
</body>
</html>
