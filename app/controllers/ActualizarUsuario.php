<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Logger.php');

session_start();
if (!isset($_SESSION['id'])){
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location:  http://localhost/ProyectoFinal/Proyecto_Hotel/public/Login.php");
    exit();
}

$usuario_controller = new Clientes($conn);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $cliente_id = $_POST['cliente_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    try{
        $usuario_controller->actualizarUsuario($cliente_id, $nombre, $apellido, $email, $telefono, $direccion);
        header('Location: ../../public/Admin.php');
        exit();
    } catch (Exception $e){
        Logger::escribirLogs("Excepción: Error al actualizar la habitación " . $e->getMessage());
        header('Location: ../../public/EditarHabitacionAdmin.php');
        exit();
    }
}

?>