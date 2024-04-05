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

    // Verificar si el nombre de usuario ya está en uso
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // El nombre de usuario ya está en uso, mostrar mensaje de error
        echo '<script>alert("El nombre de usuario ya está en uso. Por favor, elige otro."); window.location.href = "registro.php";</script>';
        exit;
    }

    // Hash de la contraseña
    $hash_contraseña = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre_usuario, contraseña) VALUES ('$nombre_usuario', '$hash_contraseña')";
    if ($conn->query($sql) === TRUE) {
        // Registro exitoso, mostrar mensaje de éxito y redirigir al inicio de sesión
        echo '<script>alert("Registro exitoso. Ahora puedes iniciar sesión."); window.location.href = "login.php";</script>';
    } else {
        // Error al registrar el usuario, mostrar mensaje de error
        echo '<script>alert("Error al registrar el usuario: ' . $conn->error . '"); window.location.href = "registro.php";</script>';
    }

    // Cerrar conexión
    $conn->close();
}
?>

