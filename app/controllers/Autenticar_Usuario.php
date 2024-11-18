<?php

session_start();

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Enviar_Correos.php');

class AutenticarUsuario {
    private $clientes;
    private $logFile = __DIR__ . '/../../logs/log.txt';

    public function __construct($conn) {
        $this->clientes = new Clientes($conn);
    }

    // Función para escribir logs de errores en un archivo
    public function escribirLogs($mensaje) {
        $fecha = date('Y-m-d H:i:s');
        $mensaje_log = "[$fecha] $mensaje" . PHP_EOL;
        file_put_contents($this->logFile, $mensaje_log, FILE_APPEND);
    }

    // Redirección a la página indicada
    public function redireccion($redireccion) {
        header("Location: $redireccion");
        exit;
    }

    // Función para enviar el correo de recuperación
    public function enviarCorreoRecuperacion($email_usuario, $codigo_verificacion) {
        $asunto = 'Recuperación de Contraseña';
        $mensaje = 'Código de recuperación de contraseña: ' . $codigo_verificacion;
        // Crea una instancia de EnviarCorreos
        $correo = new EnviarCorreos($email_usuario, $asunto, $mensaje);
        // Retorna si el envío del correo fue exitoso o no
        return $correo->enviar($correo);
    }

    // Función para verificar el usuario y gestionar el flujo de recuperación
    public function verificarUsuario($email_usuario) {
        $email_usuario = trim($email_usuario);

        // Validación de campos vacíos
        if (empty($email_usuario)) {
            $this->escribirLogs("Error: Los campos no pueden estar vacíos.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        // Validación de formato de correo
        if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
            $this->escribirLogs("Error: Formato de correo no válido.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        // Verificar si el usuario existe
        if (!$this->clientes->verificarUsuario($email_usuario)) {
            $this->escribirLogs("Error: El email ingresado no pertenece a ninguna cuenta registrada.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        // Guardar el correo en la sesión
        $_SESSION['usuario_email'] = $email_usuario;

        // Generar un código de verificación de 6 dígitos
        $codigo_verificacion =  rand(100,999) . rand(100,999);

        // Enviar el correo de recuperación
        if ($this->enviarCorreoRecuperacion($email_usuario, $codigo_verificacion)) {
            $this->escribirLogs('Correo de recuperación enviado, verifica tu bandeja de entrada');
            $_SESSION['codigo_verificacion'] = $codigo_verificacion; // Guardar el código de verificación en la sesión
        } else {
            $this->escribirLogs('Error al enviar el correo de recuperación. Inténtalo de nuevo más tarde.');
        }

        // Redirigir a la página de validación de código
        header('Location: ../../public/Validar_Codigo.php');
        exit;
    }
}

// Uso del controlador para manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario_email'])) {
    $controller = new AutenticarUsuario($conn);
    
    // Verificar si la conexión a la base de datos está activa
    if (!isset($conn)) {
        $controller->escribirLogs("Error: Conexión a la base de datos no establecida.");
        header('Location: ../../public/Recuperar_Contraseña.php');
        exit;
    }
    
    // Verificar el usuario
    $controller->verificarUsuario($_POST['usuario_email']);
}
?>
