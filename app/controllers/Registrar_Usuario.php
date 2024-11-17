<?php

session_start(); // Iniciar sesión

// Conexión a la base de datos
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');

class RegistrarUsuario {
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

    public function validarCampos($data_usuario){
        foreach ($data_usuario as $dato => $campo) {
            if (empty($campo)) {
                $this->escribirLogs("Error: El campo '$dato' vacío.");
                $this->redireccion("../../public/Registro.php");
            }
        }
    }

    public function registrarUsuario($data_usuario){
        if($data_usuario['contrasena'] !== $data_usuario['confirmar_contrasena']){
            $this->escribirLogs ("Error: Las contraseñas no coinciden.");
            $this->redireccion("../../public/Registro.php");
        }
        
        $this->validarCampos($data_usuario);

        if(!filter_var($data_usuario['email'], FILTER_VALIDATE_EMAIL)){
            $this->escribirLogs ("Error: Campo ". $data_usuario['email'] . " no valido.");
            $this->redireccion("../../public/Registro.php");
        }

        if ($this->clientes->guardarUsuario($data_usuario)) {
            $this->escribirLogs("Usuario registrado exitosamente.");
            $this->redireccion("../../public/Login.php");
        } else {
            $this->escribirLogs("Error: Usuario no pudo ser registrado.");
            $this->redireccion("../../public/Registro.php");
        }
        
    }
}

// Comprobar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller =  new RegistrarUsuario($conn);
    $data_usuario = [
        'nombre' => trim($_POST['nombre']),
        'apellido' => trim($_POST['apellido']),
        'email' => trim($_POST['email']),
        'telefono' => trim($_POST['telefono']),
        'direccion' => trim($_POST['direccion']),
        'contrasena' =>  trim($_POST['contrasena']),
        'confirmar_contrasena' => trim($_POST['contrasena_confirm'])
    ];

    if(!isset($conn)){
        $controller->escribirLogs('Error de conexión con la base de datos.');
        header('Location: ../../public/Registro.php');
        exit;
    } 

    // Registrar Usuario
    $controller->registrarUsuario($data_usuario);
}

?>
