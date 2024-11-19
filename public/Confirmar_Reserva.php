<?php

require_once(__DIR__.'/../app/controllers/Reservar_Habitacion.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h2>Confirmar Reserva</h2>
    <div class="habitacion-detalle">
        <img src="../assets/<?php echo htmlspecialchars($habitacion['imagen']); ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>" class="habitacion-img">
        <h3><?php echo htmlspecialchars($habitacion['nombre']); ?></h3>
        <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
        <p><strong>Precio por noche: </strong>$<?php echo number_format($habitacion['precio'], 2); ?></p>
        <p><strong>Tipo: </strong><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></p>
    </div>

    <!-- Formulario para fechas de reserva -->
    <form method="POST" action="Confirmar_Reserva.php">
        <input type="hidden" name="habitacion_id" value="<?php echo htmlspecialchars($habitacion_id); ?>">
        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" name="fecha_entrada" id="fecha_entrada" required>

        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" name="fecha_salida" id="fecha_salida" required>

        <button type="submit" name="confirmar_reserva">Calcular Costo y Confirmar Reserva</button>
    </form>

    <a href="Busqueda.php">Volver al catálogo</a>
</body>
</html>