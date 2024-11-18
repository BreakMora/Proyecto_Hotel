<?php

session_start(); // Iniciar sesión

// Conexión a la base de datos
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');

class Login {
    private $clientes;
    private $logFile = __DIR__ . '/../../logs/log.txt';

    public function __construct($conn) {
        $this->clientes = new Clientes($conn);
    }

    // Función para guardar el mensaje de error en sesión
    public function escribirLogs($mensaje) {
        $fecha = date('Y-m-d H:i:s');
        $mensaje = "[$fecha] $mensaje" . PHP_EOL;
        file_put_contents($this->logFile, $mensaje, FILE_APPEND);
    }

    // Redirigir a la URL con el mensaje de error
    public function redireccion($redireccion) {
        header("Location: $redireccion");
        exit;
    }

    public function validarCampos($iniciarSesion){
        foreach ($iniciarSesion as $dato => $campo) {
            if (empty($campo)) {
                $this->escribirLogs("Error: El campo '$dato' vacío.");
                $this->redireccion("../../public/Login.php");
            }
        }
    }

    public function iniciarSesion($iniciarSesion){
        $this->validarCampos($iniciarSesion);

        if($this->clientes->verificarUsuario($iniciarSesion['email'])){
            $datos = $this->clientes->getDatosUsuarios($iniciarSesion['email']);

            if($datos->num_rows > 0){
                $usuario = $datos->fetch_assoc();

                if($iniciarSesion['contrasena'] === $usuario['contrasena']){
                    $_SESSION['cliente_id'] = $usuario['cliente_id'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    $this->redireccion("../../public/index.php");
                } else {
                    $this->escribirLogs("Error: Contraseña incorrecta para el email: " . $iniciarSesion['email']);
                    $this->redireccion("../../public/Login.php");
                }

            }

        } else {
            $this->escribirLogs("Error: Correo no registrado.");
            $this->redireccion("../../public/Registro.php");
        }
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new Login($conn);
    // Obtener los datos del formulario
    $iniciar_sesion = [
        'email' => trim($_POST['email']),
        'contrasena' => trim($_POST['contrasena'])
    ];

    if(!isset($conn)){
        $controller->escribirLogs('Error de conexión con la base de datos.');
        header('Location: ../../public/Login.php');
        exit;
    }
    
    // Iniciar Sesion
    $controller->iniciarSesion($iniciar_sesion);
}
?>
