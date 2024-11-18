<?php
session_start();
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Reservaciones.php');

if (!isset($_SESSION['cliente_id'])){
    header("Location: ../../public/Login.php");
    exit();
}

$reservacion_controller = new Reservaciones($conn);
$habitacion_controller = new Habitaciones($conn);
// Verificar si se ha pasado un ID de reservación
if (isset($_GET['id']) && isset($_GET['habitacion_id'])) {
    $reservacion_id = intval($_GET['id']);
    $habitacion_id = intval($_GET['habitacion_id']);
    // Eliminar la reservación
    $resultado = $reservacion_controller->eliminarReservacion($reservacion_id);

    if ($resultado) {
        $habitacion_controller->incrementarDisponibilidad($habitacion_id);
        header('Location: ../../public/Admin.php');
        exit();
    }
}
?>