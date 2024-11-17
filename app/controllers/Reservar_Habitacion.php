<?php

    session_start();
    require_once(__DIR__ . '/../../config/Config.php');
    require_once(__DIR__ . '/../models/Clientes.php');
    require_once(__DIR__ . '/../models/Habitaciones.php');

    if (isset($_SESSION['cliente_id'])) {
        $id_usuario = $_SESSION['cliente_id'];
    } else {
        // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
        header("Location: Login.php");
        // Finaliza el script para evitar que el resto del código se ejecute
        exit();
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['habitacion_id'])){
        $habitacion_id = htmlspecialchars($_POST['habitacion_id']);

        $habitacion = new Habitaciones($conn);
        $resultado = $habitacion->reservarHabitacion($id_usuario,$habitacion_id);
        if($resultado){
            $habitacion->eliminarDisponibilidad($habitacion_id);
            header('Location: ../../public/Busqueda.php');
            exit();
        }
    }



?>