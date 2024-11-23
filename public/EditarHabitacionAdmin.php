<?php
require_once(__DIR__ . "/../app/controllers/EditarHabitacionAdmin.php");

$habitacion = $_SESSION['habitacion'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Habitacion</title>
</head>
<body>
    <h2>Formulario de Actualizacion</h2>
    <hr>
    <form action="../app/controllers/ActualizarHabitacion.php" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $habitacion['nombre']; ?>" require>
        </div>
        <div>
            <label for="descripcion">Descripcion: </label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo $habitacion['descripcion']; ?>" require>
        </div>
        <div>
            <label for="precio">Precio: </label>
            <input type="number" id="precio" name="precio" value="<?php echo $habitacion['precio']; ?>" require>
        </div>
        <div>
            <label for="disponibilidad">Disponibilidad: </label>
            <input type="text" id="disponibilidad" name="disponibilidad" value="<?php echo $habitacion['disponibilidad'] == 1 ? 'Si': 'No'; ?>" require>
        </div>
        <div>
            <label for="cantidad_habitaciones">Cantidad habitaciones: </label>
            <input type="number" id="cantidad_habitaciones" name="cantidad_habitaciones" value="<?php echo $habitacion['cantidad_habitaciones']; ?>" require>
        </div>
        <div>
            <label for="imagen">Imagen: </label>
            <input type="text" id="imagen" name="imagen" value="<?php echo $habitacion['imagen']; ?>" require>
        </div>
        <div>
            <label for="tipo">Tipo: </label>
            <input type="text" id="tipo" name="tipo" value="<?php echo $habitacion['tipo']; ?>" require>
        </div>
        <input type="hidden" id="habitacion_id" name="habitacion_id" value="<?php echo $habitacion['habitacion_id']; ?>">
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>