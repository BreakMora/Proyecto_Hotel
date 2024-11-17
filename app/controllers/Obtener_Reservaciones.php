<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Reservaciones.php');

if (isset($_SESSION['cliente_id'])) {
    $id_usuario = $_SESSION['cliente_id'];
} else {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: Login.php");
    // Finaliza el script para evitar que el resto del código se ejecute
    exit();
}

$reservacion_controller = new Reservaciones($conn);
$resultado = $reservacion_controller->obtenerReservaciones($id_usuario);
$habitaciones_reservadas = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $habitacion_id = $fila['habitacion_id'];
        
        // Obtener los detalles de la habitación
        $habitacion_controller = new Habitaciones($conn);
        $habitacion_resultado = $habitacion_controller->obtenerHabitacionReservada($habitacion_id);

        if ($habitacion_resultado->num_rows > 0) {
            $habitaciones_reservadas[] = $habitacion_resultado->fetch_assoc();
        }
    }
}

$conn->close();
?>