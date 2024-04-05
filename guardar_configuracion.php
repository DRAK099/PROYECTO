<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar los datos del formulario
    $tasa_descuento = $_POST["tasa_descuento"] ?? 0; // Utiliza el valor predeterminado 0 si no se proporciona
    $costo_envio = $_POST["costo_envio"] ?? 0; // Utiliza el valor predeterminado 0 si no se proporciona
    $politica_inventario = $_POST["politica_inventario"] ?? '';

    // Validar y limpiar los datos (si es necesario)

    // Establecer la conexión a la base de datos (reemplaza estos valores con los tuyos)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "erp";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para insertar los datos en la tabla de configuración
    $sql = "INSERT INTO configuracion (tasa_descuento, costo_envio, politica_inventario)
            VALUES (?, ?, ?)";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("dds", $tasa_descuento, $costo_envio, $politica_inventario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Mostrar un mensaje de alerta con JavaScript y redirigir después de aceptar
        echo '<script>alert("La configuración se ha guardado correctamente en la base de datos."); window.location.href = "calcular_eoq.php";</script>';
    } else {
        // Mostrar un mensaje de error con JavaScript y redirigir después de aceptar
        echo '<script>alert("Error al guardar la configuración en la base de datos: ' . $conn->error . '"); window.location.href = "calcular_eoq.php";</script>';
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
} else {
    // Si no se han enviado datos del formulario, redirigir a la página principal o mostrar un mensaje de error
    // Puedes personalizar este mensaje según tus necesidades
    header("Location: calcular_eoq.php");
    exit; // Asegúrate de usar exit() después de la redirección para detener la ejecución del script
}
?>



