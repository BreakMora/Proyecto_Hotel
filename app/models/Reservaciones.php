<?php

require_once (__DIR__ . "/../../config/Config.php");
require 'Clientes.php';
require 'Habitaciones.php';

    class Reservaciones{
        private $conn;

        public function __construct($conn){
            $this->conn=$conn;
        }

        public function obtenerReservaciones($id_usuario){
            $stmt = $this->conn->prepare("SELECT habitacion_id,fecha_reservacion FROM reservaciones WHERE cliente_id = ?");
            $stmt->bind_param("i",$id_usuario);
            $stmt->execute();
            return $stmt->get_result();
        }
    }

?>