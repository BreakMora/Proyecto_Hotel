<?php
session_start();

// Inicializar el estado de validación
if (!isset($_SESSION['codigo_validado'])) {
    $_SESSION['codigo_validado'] = false;
}

// Verificar si el código de verificación ya está definido en la sesión
if (isset($_SESSION['codigo_verificacion'])) {
    $codigo_enviado = $_SESSION['codigo_verificacion'];
} else {
    // Si no está definido, asignamos un valor null
    $codigo_enviado = null;
}

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo_verificacion']) && $_POST['codigo_verificacion'] === $codigo_enviado) {
        // El código es correcto, redirigir a la página de cambio de contraseña
        $_SESSION['codigo_validado'] = true;
        header("Location: Cambiar_Contraseña.php");
        exit;
    } else {
        // Si el código es incorrecto, mostrar un mensaje de error
        $_SESSION['error_codigo'] = "El código de verificación es incorrecto.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Código de Verificación</title>
</head>
<body>

<h1>Ingresar Código de Verificación</h1>

<!-- Formulario para ingresar el código de verificación -->
<?php if (!$_SESSION['codigo_validado']): ?>
    <form action="" method="post">
        <label for="codigo_verificacion">Código de Verificación</label><br>
        <input type="text" name="codigo_verificacion">
        <input type="submit" value="Verificar">
    </form>

    <?php
    // Mostrar mensaje de error si el código es incorrecto
    if (isset($_SESSION['error_codigo'])) {
        echo "<p style='color: red;'>{$_SESSION['error_codigo']}</p>";
        unset($_SESSION['error_codigo']);
    }
    ?>

<?php else: ?>
    <!-- Si el código ya fue validado, redirige a la página de cambio de contraseña -->
    <p>El código de verificación es correcto. Serás redirigido a la página de cambio de contraseña...</p>
    <meta http-equiv="refresh" content="2; url=Cambiar_Contraseña.php">
<?php endif; ?>

</body>
</html>
