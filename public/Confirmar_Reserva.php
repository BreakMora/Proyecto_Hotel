<?php

require_once(__DIR__ . '/../app/controllers/Reservar_Habitacion.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva</title>
    <link rel="stylesheet" href="">
    <script>
        function calcularReserva() {
            const precioNoche = <?php echo json_encode($habitacion['precio']) ?>;
            const fechaEntrada = new Date(document.getElementById('fecha_entrada').value);
            const fechaSalida = new Date(document.getElementById('fecha_salida').value);

            if (fechaEntrada && fechaSalida && fechaEntrada < fechaSalida) {
                // Calcular la diferencia en días
                const numNoches = (fechaSalida - fechaEntrada) / (1000 * 60 * 60 * 24);
                const costoTotal = numNoches * precioNoche;

                document.getElementById('costo_total').textContent = "$" + costoTotal.toFixed(2);
                document.getElementById('costo_total_hidden').value = costoTotal.toFixed(2);
            } else {
                document.getElementById('costo_total').textContent = " ";
            }
        }
    </script>
</head>

<body>
    <h2>Confirmar Reserva</h2>
    <form method="POST" action="Confirmar_Reserva.php">
        <!-- Tabla con los detalles de la habitación y costo -->
        <table border="1">
            <tr>
                <td rowspan="7"><img src="../assets/<?php echo htmlspecialchars($habitacion['imagen']); ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>" width="150"></td>
                <td><strong>Nombre de la Habitación:</strong> <?php echo htmlspecialchars($habitacion['nombre']); ?></td>
            </tr>
            <tr>
                <td><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacion['descripcion']); ?></td>
            </tr>
            <tr>
                <td><strong>Precio por noche:</strong> $<?php echo number_format($habitacion['precio'], 2); ?></td>
            </tr>
            <tr>
                <td><strong>Tipo:</strong> <?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Entrada:</strong> <input type="date" name="fecha_entrada" id="fecha_entrada" required onchange="calcularReserva()"></td>
            </tr>
            <tr>
                <td><strong>Fecha de Salida:</strong> <input type="date" name="fecha_salida" id="fecha_salida" required onchange="calcularReserva()"></td>
            </tr>
            <tr>
                <td><strong>Costo Total por la Estancia:</strong> <span id="costo_total"> </span></td>
            </tr>
        </table>

        <!-- Formulario para confirmar reserva -->
        <input type="hidden" name="habitacion_id" value="<?php echo htmlspecialchars($habitacion_id); ?>">
        <input type="hidden" name="costo_total" id="costo_total_hidden">
        <button type="submit" name="confirmar_reserva">Confirmar Reserva</button>
    </form>

    <a href="Busqueda.php">Volver al catálogo</a>
</body>

</html>