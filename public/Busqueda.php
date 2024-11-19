<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}

// Incluir el archivo correspondiente según los filtros enviados
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (!empty($_GET['tipo']) || isset($_GET['precio_min']) || isset($_GET['precio_max']))) {
    require_once(__DIR__ . '/../app/controllers/Procesar_Filtros.php');
} else {
    require_once(__DIR__ . '/../app/controllers/Obtener_Habitaciones.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Habitaciones</title>
    <link rel="stylesheet" href="../assets/estilo_habitaciones.css">
</head>

<body>

    <section>
        <a href="Logout.php">Cerrar Sesión</a>
        <a href="cliente.php">Volver</a>
    </section>

    <!-- Formulario de filtros de búsqueda -->
    <form method="GET" action="Busqueda.php">
        <h2>Buscar Habitaciones</h2>

        <label for="tipo">Tipo de Habitación:</label>
        <select name="tipo" id="tipo">
            <option value="">Todos</option>
            <option value="sencilla" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'sencilla' ? 'selected' : ''; ?>>Sencilla</option>
            <option value="doble" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'doble' ? 'selected' : ''; ?>>Doble</option>
            <option value="suite" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'suite' ? 'selected' : ''; ?>>Suite</option>
            <option value="familiar" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'familiar' ? 'selected' : ''; ?>>Familiar</option>
        </select>

        <label for="precio_min">Precio Mínimo:</label>
        <input type="number" name="precio_min" id="precio_min" placeholder="0" min="0" value="<?php echo isset($_GET['precio_min']) ? htmlspecialchars($_GET['precio_min']) : 0; ?>">

        <label for="precio_max">Precio Máximo:</label>
        <input type="number" name="precio_max" id="precio_max" placeholder="150" min="0" value="<?php echo isset($_GET['precio_max']) ? htmlspecialchars($_GET['precio_max']) : 150; ?>">

        <button type="submit">Buscar</button>
    </form>

    <!-- Mostrar habitaciones (todas o filtradas) -->
    <h2>Catálogo de Habitaciones Disponibles</h2>
    <?php if (count($habitaciones) > 0): ?>
        <div class="habitaciones-container">
            <?php foreach ($habitaciones as $habitacion): ?>
                <div class="habitacion">
                    <?php $imagen = $habitacion['imagen']; ?>
                    <img src="../assets/<?php echo htmlspecialchars($imagen); ?>"
                        alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>"
                        class="habitacion-img">
                    <h3><?php echo htmlspecialchars($habitacion['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                    <p><strong>Estado: </strong><?php echo htmlspecialchars($habitacion['disponibilidad'] ? "Disponible" : "No disponible"); ?></p>
                    <p><strong>Precio por noche: </strong>$<?php echo number_format($habitacion['precio'], 2); ?></p>
                    <p><strong>Tipo: </strong><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></p>

                    <form method="POST" action="Confirmar_Reserva.php">
                        <input type="hidden" name="habitacion_id" value="<?php echo htmlspecialchars($habitacion['habitacion_id']); ?>">
                        <button class="reservar-btn">Reservar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay habitaciones disponibles<?php echo isset($_GET['tipo']) || isset($_GET['precio_min']) || isset($_GET['precio_max']) ? ' según los filtros seleccionados' : ''; ?>.</p>
    <?php endif; ?>

</body>

</html>