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
    }

?>