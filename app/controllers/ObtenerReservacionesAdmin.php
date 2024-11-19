<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Reservaciones.php');

if (isset($_SESSION['id'])) {
    $id_usuario = $_SESSION['id'];
} else {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: Login.php");
    // Finaliza el script para evitar que el resto del código se ejecute
    exit();
}

$reservacion_controller = new Reservaciones($conn);
$resultado = $reservacion_controller->obtenerReservaciones();
$reservaciones = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $habitacion_id = $fila['habitacion_id'];
        $fecha_reservacion = $fila['fecha_reservacion']; // Obtener la fecha de la reservación
        $reservacion_id = $fila['reservacion_id'];

        // Obtener los detalles de la habitación
        $habitacion_controller = new Habitaciones($conn);
        $datos_habitacion = $habitacion_controller->obtenerHabitacionReservada($habitacion_id);

        if ($datos_habitacion->num_rows > 0) {
            $habitacion = $datos_habitacion->fetch_assoc();
            // Agregar la fecha de la reservación a los detalles de la habitación
            $habitacion['fecha_reservacion'] = $fecha_reservacion;
            $habitacion['reservacion_id'] = $reservacion_id;
            $reservaciones[] = $habitacion;
        }
    }
}

?>