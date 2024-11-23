<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Habitaciones.php');
require_once(__DIR__ . '/../utils/Logger.php');

session_start();
if (!isset($_SESSION['id'])){
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location:  http://localhost/ProyectoFinal/Proyecto_Hotel/public/Login.php");
    exit();
}

$habitacion_controller = new Habitaciones($conn);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $habitacion_id = $_POST['habitacion_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponibilidad = isset($_POST['disponibilidad']) && $_POST['disponibilidad'] === 'Si' ? 1 : 0;
    $cantidad_habitaciones = $_POST['cantidad_habitaciones'];
    $imagen = $_POST['imagen'];
    $tipo = $_POST['tipo'];

    try{
        $habitacion_controller->actualizarHabitacion($habitacion_id, $nombre, $descripcion, $precio, $disponibilidad, $cantidad_habitaciones, $imagen, $tipo);
        header('Location: ../../public/Admin.php');
        exit();
    } catch (Exception $e){
        Logger::escribirLogs("Excepción: Error al actualizar la habitación " . $e->getMessage());
        header('Location: ../../public/EditarHabitacionAdmin.php');
        exit();
    }
}

?>