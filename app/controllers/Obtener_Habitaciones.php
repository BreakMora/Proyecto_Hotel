<?php

require_once(__DIR__ . '/../../config/Config.php'); // Incluir conexión a la base de datos

// Consulta para obtener las habitaciones disponibles sin filtros
$sql = "SELECT * FROM habitaciones WHERE disponibilidad = 1";
$resultado = $conn->query($sql);

// Guardar resultados en un array
$habitaciones = [];
if ($resultado->num_rows > 0) {
    while ($habitacion = $resultado->fetch_assoc()) {
        $habitaciones[] = $habitacion;
    }
}

$conn->close();
?>
