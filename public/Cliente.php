<?php

// Inicia la sesión para acceder a las variables de sesión
session_start();
require_once(__DIR__ . "/../app/controllers/Obtener_Reservaciones.php");

// Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['id'])) {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: Login.php");
    // Finaliza el script para evitar que el resto del código se ejecute
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link rel="stylesheet" href="../assets/estilo_habitaciones.css">
</head>

<body>

    <section>
        <a href="Logout.php">Cerrar Sesión</a>
        <a href="Busqueda.php">Buscar Habitaciones</a>
    </section>

    <h2>
        <!-- 'htmlspecialchars_decode' se usa para decodificar cualquier entidad HTML especial que se haya almacenado en la variable de sesión 'usuario'-->
        Bienvenido, <?php echo htmlspecialchars_decode($_SESSION['nombre']); ?> !
    </h2>

    <!-- Mostrar todas las reservaciones hechas -->
    <h2>Tus reservaciones</h2>
    <?php if (count($habitaciones_reservadas) > 0): ?>
        <div class="habitaciones-container">
            <?php foreach ($habitaciones_reservadas as $habitacion): ?>
                <div class="habitacion">
                    <?php
                    // Verificar si la imagen existe o tiene un valor
                    $imagen = !empty($habitacion['imagen']) ? htmlspecialchars($habitacion['imagen']) : 'imagen_por_defecto.jpg';
                    ?>
                    <img src="../assets/<?php echo $imagen; ?>"
                        alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>"
                        class="habitacion-img">
                    <h3><?php echo htmlspecialchars($habitacion['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                    <p><strong>Tipo: </strong><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></p>
                    <p><strong>Precio por noche: </strong>$<?php echo number_format($habitacion['precio'], 2); ?></p>
                    <p><strong>Fecha de entrada: </strong> <?php echo htmlspecialchars($habitacion['fecha_entrada']); ?></p>
                    <p><strong>Fecha de salida: </strong> <?php echo htmlspecialchars($habitacion['fecha_salida']); ?></p>
                    <p><strong>Costo total: </strong>$<?php echo number_format($habitacion['costo'], 2); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No has reservado habitaciones aún.</p>
    <?php endif; ?>
</body>

</html>