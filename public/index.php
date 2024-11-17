<?php

    // Inicia la sesión para acceder a las variables de sesión
    session_start();

    // Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
    if (!isset($_SESSION['cliente_id'])) {
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
</body>
</html>

