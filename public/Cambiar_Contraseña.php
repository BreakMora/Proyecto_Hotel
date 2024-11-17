<?php
session_start();
if (!isset($_SESSION['codigo_validado']) || !$_SESSION['codigo_validado']) {
    header("Location: Validar_Codigo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <header>
        <nav>
            <a href="Login.php">Iniciar Sesion</a>
            <a href="Registro.php">Registrarse</a>
        </nav>
    </header>

    <!-- Formulario para cambiar la contraseña -->
    <form action="../app/controllers/Cambiar_Contraseña.php" method="post" name="Cambia_Contraseña">
        <div> 
            <label for="nueva_contraseña">Nueva Contraseña</label><br>
            <input type="password" name="nueva_contraseña">
        </div>

        <div>
            <label for="confirmar_contraseña">Confirmar Contraseña</label><br>
            <input type="password" name="confirmar_contraseña">
        </div>

        <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña">
    </form>

</body>
</html>
