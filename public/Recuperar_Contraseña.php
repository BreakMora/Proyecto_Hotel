<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <header>
        <nav>
            <a href="Login.php">Iniciar Sesion</a>
            <a href="Registro.php">Registrarse</a>
        </nav>
    </header>
    
    <body>

        <section>
            <form action="../app/controllers/Autenticar_Usuario.php" method="post" name="Datos_Recuperacion">

                <div>
                    <label for="usuario_email">Correo</label><br>
                    <input type="text" name="usuario_email" require>
                </div>

                <input type="submit" name="recuperar_contrasena" value="Recuperar Contraseña">
        </section>

        </form>
    </body>
</body>
</html>