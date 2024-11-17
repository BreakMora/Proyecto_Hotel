<?php

require_once(__DIR__ . '/../../config/Config.php'); // Incluir conexión a la base de datos
require_once(__DIR__ . '/../models/Habitaciones.php'); // Llama al modelo de habitaciones

// Obtener los parámetros del formulario
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : 150;

// se llama al model habitaciones para que busque las habitaciones
$controller = new Habitaciones($conn);
// Llamar al método obtenerHabitacionesFiltradas y pasar los parámetros
$resultado = $controller->obtenerHabitacionesFiltradas($tipo,$precio_min,$precio_max);

// Guardar los resultados en un array para pasarlos al archivo HTML
$habitaciones = [];
while ($habitacion = $resultado->fetch_assoc()) {
    $habitaciones[] = $habitacion;
}

$conn->close();
?>