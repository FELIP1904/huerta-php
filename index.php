<?php

require_once "config/db.php";

require_once "logic/cultivos.php";


$sql = "SELECT id, nombre, tipo, dias_cosecha FROM cultivos ORDER BY id";
$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
   
    error_log("Error preparando consulta: " . mysqli_error($conexion));
    $error = "Error al cargar los cultivos.";
} else {
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if (!$resultado) {
        error_log("Error obteniendo resultados: " . mysqli_error($conexion));
        $error = "Error al procesar los datos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Cultivos</title>
    <style>
    body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f9; 
            padding: 20px; 
        }
        h1 { 
            color: #333;
            text-align: center; 
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            background-color: #fff; 
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: center; 
        }
        th { 
            background-color: #6c7ae0; 
            color: #fff;
         }
        .btn-nuevo { 
            padding: 8px 16px;
             background-color: #6c7ae0;
             color: white; 
             border: none; 
             border-radius: 4px; 
             text-decoration: none; 
             display: inline-block; 
             margin-bottom: 15px; 
            }
        .error { 
            color: #ff0000; 
            padding: 10px; 
            background-color: #ffe6e6; 
            border-radius: 4px; 
            margin-bottom: 15px; 
        }
    </style>
</head>
<body>

<h1>Listado de Cultivos</h1>

<a href="nuevo.php" class="btn-nuevo">Agregar Nuevo Cultivo</a>

<?php if (isset($error)): ?>
    <div class="error"><?php echo sanitizarSalida($error); ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Días para cosecha</th>
        <th>Ciclo</th>
    </tr>

    <?php if (isset($resultado) && mysqli_num_rows($resultado) > 0): ?>
        <?php while ($fila = mysqli_fetch_assoc($resultado)): 
            $ciclo = cicloCultivo($fila["dias_cosecha"]);
        ?>
            <tr>
                <td><?php echo sanitizarSalida($fila["id"]); ?></td>
                <td><?php echo sanitizarSalida($fila["nombre"]); ?></td>
                <td><?php echo sanitizarSalida($fila["tipo"]); ?></td>
                <td><?php echo sanitizarSalida($fila["dias_cosecha"]); ?></td>
                <td><?php echo sanitizarSalida($ciclo); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No hay cultivos registrados.</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>
<?php

if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}
?>