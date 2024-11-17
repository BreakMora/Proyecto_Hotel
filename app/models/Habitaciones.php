<?php

require_once (__DIR__ . "/../../config/Config.php");

    class Habitaciones {
        private $conn;

        public function __construct($conn){
            $this->conn=$conn;
        }

        public function obtenerHabitaciones(){
            $sql = "SELECT * FROM habitaciones WHERE disponibilidad = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function obtenerHabitacionesFiltradas($tipo, $precio_min, $precio_max){
            $sql = "SELECT * FROM habitaciones WHERE disponibilidad = 1 AND precio BETWEEN ? AND ?";
            
            if (!empty($tipo)) {
                $sql .= " AND tipo = ?";
            }
            
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($tipo))  {
                $stmt->bind_param('dds', $precio_min, $precio_max, $tipo);
            } else {
                $stmt->bind_param('dd', $precio_min, $precio_max);
            }
            
            $stmt->execute();
            return $stmt->get_result();
        }

        public function reservarHabitacion($id_usuario,$habitacion_id){
            $stmt = $this->conn->prepare("INSERT INTO reservaciones (cliente_id,habitacion_id) VALUES (?,?)");
            $stmt->bind_param("ii",$id_usuario,$habitacion_id);
            return $stmt->execute();
        }

        public function eliminarDisponibilidad($habitacion_id){
            $stmt = $this->conn->prepare("UPDATE habitaciones SET disponibilidad = 0 WHERE habitacion_id = ?");
            $stmt->bind_param("i",$habitacion_id);
            return $stmt->execute();
        }

        public function obtenerHabitacionReservada($habitacion_id){
            $stmt = $this->conn->prepare("SELECT * FROM habitaciones WHERE habitacion_id = ?");
            $stmt->bind_param("i", $habitacion_id);
            $stmt->execute();
            return $stmt->get_result();
        }
        
    }

?>