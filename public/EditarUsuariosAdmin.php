<?php
require_once(__DIR__ . "/../app/controllers/EditarUsuariosAdmin.php");

$cliente = $_SESSION['cliente'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
</head>
<body>
    <h2>Formulario de Actualizacion</h2>
    <hr>
    <form action="../app/controllers/ActualizarUsuario.php" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" require>
        </div>
        <div>
            <label for="apellido">Apellido: </label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $cliente['apellido']; ?>" require>
        </div>
        <div>
            <label for="email">Email: </label>
            <input type="text" id="email" name="email" value="<?php echo $cliente['email']; ?>" require>
        </div>
        <div>
            <label for="telefono">Telefono: </label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>">
        </div>
        <div>
            <label for="direccion">Direccion: </label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>">
        </div>
        <div>
            <label for="contrasena">Contrasena: </label>
            <input type="text" id="contrasena" name="contrasena" value="Clave de acceso" disabled>
        </div>
        <input type="hidden" id="cliente_id" name="cliente_id" value="<?php echo $cliente['cliente_id']; ?>">
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>