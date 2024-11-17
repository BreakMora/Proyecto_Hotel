<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="../app/controllers/Procesar_Login.php" method="POST">
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena">
        </div>
        <input type="submit" value="Iniciar sesión"></input>
    </form>
    <p>¿Olvidaste tu contraseña? <a href="Recuperar_Contraseña.php">Recuperar Contraseña</a></p>
    <p>¿No tienes cuenta? <a href="Registro.php">Regístrate</a></p>
</body>
</html>
