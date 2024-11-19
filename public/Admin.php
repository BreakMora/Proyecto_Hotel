<?php

// Inicia la sesión para acceder a las variables de sesión
session_start();
require_once(__DIR__ . "/../app/controllers/ObtenerReservacionesAdmin.php");

// Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['id'])) {
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
    <link rel="stylesheet" href="">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        td{
            height: 80px;
        }
        th {
            background-color: #f2f2f2;
        }
        .acciones {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }
        .boton {
            padding: 5px 10px;
            border: none;
            color: white;
            cursor: pointer;
        }
        .editar {
            height: 40px;
            background-color: #4CAF50; /* Verde */
        }
        .eliminar {
            height: 40px;
            background-color: #f44336; /* Rojo */
        }
    </style>
</head>

<body>

    <section>
        <a href="Logout.php">Cerrar Sesión</a>
        <a href="Busqueda.php">Buscar Habitaciones</a>
    </section>

    <h2>
        Bienvenido, <?php echo htmlspecialchars_decode($_SESSION['nombre']); ?> !
    </h2>

    <!-- Mostrar todas las reservaciones hechas -->
    <h2>Reservaciones</h2>
    <?php if (count($reservaciones) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio por noche</th>
                    <th>Costo Total</th>
                    <th>Tipo</th>
                    <th>Fecha de la reservación</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservaciones as $habitacion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($habitacion['reservacion_id']); ?></td>
                        <td>
                            <?php
                            // Verificar si la imagen existe o tiene un valor
                            $imagen = !empty($habitacion['imagen']) ? htmlspecialchars($habitacion['imagen']) : 'imagen_por_defecto.jpg';
                            ?>
                            <img src="../assets/<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>" class="habitacion-img" style="width: 100px; height: auto;">
                        </td>
                        <td><?php echo htmlspecialchars($habitacion['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($habitacion['descripcion']); ?></td>
                        <td>$<?php echo number_format($habitacion['precio'], 2); ?></td>
                        
                        <td><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></td>
                        <td><?php echo htmlspecialchars($habitacion['fecha_reservacion']); ?></td>
                        <td class="acciones">
                            <button class="boton eliminar" onclick="if(confirm('¿Estás seguro de que deseas eliminar esta reservación?')) location.href='../app/controllers/EliminarReservacionAdmin.php?id=<?php echo $habitacion['reservacion_id']; ?>&habitacion_id=<?php echo $habitacion['habitacion_id'];?>'">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Actualmente no hay reservado ninguna habitacion aún.</p>
    <?php endif; ?>
</body>
