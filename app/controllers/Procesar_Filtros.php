<?php

require_once(__DIR__ . '/../../config/Config.php'); // Incluir conexión a la base de datos

// Obtener los parámetros del formulario
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : 150;

// Construir la consulta con filtros
$sql = "SELECT * FROM habitaciones WHERE disponibilidad = 1 AND precio BETWEEN ? AND ?";

// Agregar filtro por tipo si se selecciona
if ($tipo != '') {
    $sql .= " AND tipo = ?";
}

$stmt = $conn->prepare($sql);

// Bind de los parámetros para evitar inyecciones SQL
if ($tipo != '') {
    $stmt->bind_param('dss', $precio_min, $precio_max, $tipo);
} else {
    $stmt->bind_param('dd', $precio_min, $precio_max);
}

$stmt->execute();
$resultado = $stmt->get_result();

// Guardar los resultados en un array para pasarlos al archivo HTML
$habitaciones = [];
while ($habitacion = $resultado->fetch_assoc()) {
    $habitaciones[] = $habitacion;
}

$conn->close();
?>