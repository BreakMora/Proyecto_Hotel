<?php

require_once(__DIR__ . '/../../config/Config.php'); // Incluir conexión a la base de datos
require_once(__DIR__ . '/../models/Habitaciones.php'); // Llama al modelo de habitaciones
require_once(__DIR__ . '/../utils/Logger.php');

// se llama al model habitaciones para que busque las habitaciones
$controller = new Habitaciones($conn);

try {
    $resultado = $controller->obtenerHabitaciones();

    // Guardar resultados en un array
    $habitaciones = [];
    if ($resultado->num_rows > 0) {
        while ($habitacion = $resultado->fetch_assoc()) {
            $habitaciones[] = $habitacion;
        }
    } else {
        Logger::escribirLogs("Advertencia: No se encontraron habitaciones disponibles.");
    }
} catch (Exception $e) {
    Logger::escribirLogs("Error: Excepción al intentar obtener las habitaciones. E:" . $e->getMessage());
}
?>