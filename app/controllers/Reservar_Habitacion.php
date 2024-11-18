<?php

session_start();
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../models/Habitaciones.php');
require_once(__DIR__ . '/../utils/Enviar_Correos.php');

if (isset($_SESSION['cliente_id'])) {
    $id_usuario = $_SESSION['cliente_id'];
    $email_usuario = $_SESSION['usuario_email'];
} else {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: Login.php");
    // Finaliza el script para evitar que el resto del código se ejecute
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['habitacion_id'])) {
    $habitacion_id = htmlspecialchars($_POST['habitacion_id']);
    $habitacion = new Habitaciones($conn);
    $resultado = $habitacion->reservarHabitacion($id_usuario, $habitacion_id);
    $habitacion->eliminarDisponibilidad($habitacion_id);
    if ($resultado) {
        $habitacion_reservada = $habitacion->obtenerHabitacionReservada($habitacion_id);
        if ($habitacion_reservada->num_rows > 0) {
            $datos_habitacion = $habitacion_reservada->fetch_assoc(); // Obtiene los datos de la habitación
            $asunto = 'Reservación Completada';
            $mensaje = 'Usted ha reservado la ' . $datos_habitacion['nombre'] .
                '. Con un precio de: ' . $datos_habitacion['precio'] . '.';
            // Crear y enviar el correo
            $correo = new EnviarCorreos($email_usuario, $asunto, $mensaje);
            $correo->enviar($correo);
        }
        header('Location: ../../public/Busqueda.php');
        exit();
    }
}
