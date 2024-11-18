<?php
    session_start();

    require '../app/controllers/Procesar_Filtros.php';

    // Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
    if (!isset($_SESSION['cliente_id'])) {
        // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
        header("Location: Login.php");
        // Finaliza el script para evitar que el resto del código se ejecute
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../assets/estilo_habitaciones.css">
</head>

<body>

    <section>
        <a href="Logout.php">Cerrar Sesión</a>
        <a href="Busqueda.php">volver</a>
    </section>

    <!-- Mostrar los resultados filtrados -->
    <h2>Catálogo de Habitaciones Disponibles</h2>
    <?php if (count($habitaciones) > 0): ?>
        <div class="habitaciones-container">
            <?php foreach ($habitaciones as $habitacion): ?>
                <div class="habitacion">
                    <?php
                    // Ruta de la imagen
                    $imagen = $habitacion['imagen'];
                    ?>
                    <img src="../assets/<?php echo htmlspecialchars($imagen); ?>"
                        alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>"
                        class="habitacion-img">
                    <h3><?php echo htmlspecialchars($habitacion['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                    <p><strong>Precio por noche: </strong>$<?php echo number_format($habitacion['precio'], 2); ?></p>
                    <p><strong>Tipo: </strong><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></p>

                    
                    <form method="POST" action="../app/controllers/Reservar_Habitacion.php">
                        <input type="hidden" name="habitacion_id" value="<?php echo htmlspecialchars($habitacion['habitacion_id']); ?>">
                        <button class="reservar-btn">Reservar ahora</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay habitaciones disponibles según los filtros seleccionados.</p>
    <?php endif; ?>

</body>

</html>