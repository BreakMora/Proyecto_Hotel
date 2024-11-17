<?php

session_start();

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');

class CambiarContrasena {
    private $clientes;
    private $logFile = __DIR__ . '/../../logs/log.txt';

    public function __construct($conn) {
        $this->clientes = new Clientes($conn);
    }

    // Función para guardar el mensaje de error en sesión
    private function escribirLogs($mensaje) {
        $fecha = date('Y-m-d H:i:s');
        $mensaje = "[$fecha] $mensaje" . PHP_EOL;
        file_put_contents($this->logFile, $mensaje, FILE_APPEND);
    }

    // Redirigir a la URL con el mensaje de error
    public function redireccion($redireccion) {
        header("Location: $redireccion");
        exit;
    }

    public function validarCampos($nueva_contraseña, $confirmar_contraseña){
        if (empty($nueva_contraseña) || empty($confirmar_contraseña)) {
            $this->escribirLogs("Error: Uno de los campo esta vacío.");
            $this->redireccion("../../public/Cambiar_Contraseña.php");
        }
    }

    // Validar las contraseñas y proceder a cambiarla si son correctas
    public function validarNuevaContraseña($nueva_contraseña, $confirmar_contraseña) {
        $nueva_contraseña = trim($nueva_contraseña);
        $confirmar_contraseña = trim($confirmar_contraseña);

        $this->validarCampos($nueva_contraseña, $confirmar_contraseña);

        if ($nueva_contraseña === $confirmar_contraseña) {
            $this->cambiarContrasena($nueva_contraseña);
        } else {
            $this->escribirLogs("Error: Las contraseñas no coinciden.");
            $this->redireccion("../../public/Cambiar_Contraseña.php");
        }
    }

    // Cambiar la contraseña en la base de datos
    public function cambiarContrasena($nueva_contraseña) {
        if (!isset($_SESSION['usuario_email'])) {
            $this->escribirLogs("Error: No se pudo recuperar el correo del usuario.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        $email_usuario = $_SESSION['usuario_email'];

        if ($this->clientes->actualizarContrasena($email_usuario, $nueva_contraseña)) {
            $this->escribirLogs("Contraseña cambiada exitosamente.");
            $this->redireccion("../../public/Login.php");
        } else {
            $this->escribirLogs("Error: No se pudo actualizar la contraseña. Inténtalo de nuevo.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }
    }
}

// Uso del controlador para manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nueva_contraseña']) && isset($_POST['confirmar_contraseña'])) {
    // Asegurarse de que la conexión a la base de datos ($conn) esté definida
    if (isset($conn)) {
        $controller = new CambiarContrasena($conn);
        $controller->validarNuevaContraseña($_POST['nueva_contraseña'], $_POST['confirmar_contraseña']);
    } else {
        $this->escribirLogs('Error de conexión con la base de datos.');
        header('Location: ../../public/Recuperar_Contraseña.php');
        exit;
    }
}

?>
