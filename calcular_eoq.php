<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de configuración
    $tasa_descuento = $_POST["tasa_descuento"] ?? 0;
    $costo_envio = $_POST["costo_envio"] ?? 0;
    $politica_inventario = $_POST["politica_inventario"] ?? '';

    // Guardar la configuración en la base de datos
    $configuracionGuardada = guardarConfiguracion($tasa_descuento, $costo_envio, $politica_inventario);

    if ($configuracionGuardada) {
        // Obtener los datos del formulario de cálculo de EoQ
        $demanda_anual = $_POST["demanda"];
        $costo_pedido = $_POST["costo_pedido"];
        $costo_mantenimiento = $_POST["costo_mantenimiento"];

        // Calcular la Cantidad Económica de Pedido (EoQ)
        $eoq = calcularEoQ($demanda_anual, $costo_pedido, $costo_mantenimiento);

        // Guardar los resultados de EoQ en la base de datos
        guardarResultadosEoQ($demanda_anual, $costo_pedido, $costo_mantenimiento, $eoq);

        // Redirigir a la página principal con el resultado de EoQ
        header("Location: resultado_eoq.php?eoq=$eoq");
        exit;
    } else {
        // Si la configuración no se guardó correctamente, redirigir a la página principal o mostrar un mensaje de error
        // Puedes personalizar este mensaje según tus necesidades
        header("Location: resultado_eoq.php");
        exit;
    }
}

// Función para guardar la configuración en la base de datos
function guardarConfiguracion($tasa_descuento, $costo_envio, $politica_inventario) {
    // Establecer la conexión a la base de datos (reemplaza con tus propios datos)
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

    // Preparar la consulta SQL para insertar los datos de configuración
    $sql = "INSERT INTO configuracion (tasa_descuento, costo_envio, politica_inventario)
            VALUES (?, ?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("dds", $tasa_descuento, $costo_envio, $politica_inventario);

    // Ejecutar la consulta
    $resultado = $stmt->execute();

    // Cerrar conexión
    $stmt->close();
    $conn->close();

    // Devolver el resultado de la operación
    return $resultado;
}

// Función para guardar los resultados de EoQ en la base de datos
function guardarResultadosEoQ($demanda_anual, $costo_pedido, $costo_mantenimiento, $eoq) {
    // Establecer la conexión a la base de datos (reemplaza con tus propios datos)
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

    // Preparar la consulta SQL para insertar los resultados de EoQ
    $sql = "INSERT INTO resultados_eoq (demanda_anual, costo_pedido, costo_mantenimiento, eoq)
            VALUES (?, ?, ?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("dddd", $demanda_anual, $costo_pedido, $costo_mantenimiento, $eoq);

    // Ejecutar la consulta
    $stmt->execute();

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>