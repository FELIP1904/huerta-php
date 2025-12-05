<?php

require_once "logic/cultivos.php";

$nombreErr = $tipoErr = $diasErr = "";
$nombre = $tipo = $dias = "";


if (isset($_GET['error'])) {
    $errorGeneral = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    if (!$nombre || trim($nombre) === '') {
        $nombreErr = "El nombre es obligatorio.";
    }

    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
    if (!$tipo) {
        $tipoErr = "El tipo es obligatorio.";
    } elseif (!validarTipoCultivo($tipo)) {
        $tipoErr = "Tipo inválido.";
    }

    $dias = filter_input(INPUT_POST, 'dias', FILTER_VALIDATE_INT);
    if ($dias === false || $dias <= 0) {
        $diasErr = "Ingrese un número válido de días (mayor a 0).";
    }

    if (!$nombreErr && !$tipoErr && !$diasErr) {
        header("Location: procesar.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Cultivo</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f9; 
            padding: 20px; 
        }
        h1 { 
            color: #333; 
        }
        form { 
            background-color: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            width: 400px; 
        }
        label { 
            display: block; 
            margin-top: 10px; 
            font-weight: bold; 
        }
        input[type=text], input[type=number], select { 
            width: 95%; 
            padding: 8px; 
            margin-top: 4px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        input[type=submit] { 
            margin-top: 15px; 
            padding: 10px 20px; 
            background-color: #6c7ae0; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        a { 
            display: inline-block; 
            margin-top: 10px; 
            text-decoration: none; 
            color: #6c7ae0; 
        }
        .error { 
            color: #ff0000; 
            font-size: 0.9em; 
            margin-top: 4px; 
            display: block; 
        }
        .error-general { 
            color: #ff0000; 
            background-color: #ffe6e6; 
            padding: 10px; 
            border-radius: 4px; 
            margin-bottom: 15px; 
        }
    </style>
</head>
<body>
<h1>Agregar Nuevo Cultivo</h1>

<?php if (isset($errorGeneral)): ?>
    <div class="error-general">Error: <?php echo $errorGeneral; ?></div>
<?php endif; ?>

<form method="post" action="">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo sanitizarSalida($nombre); ?>" required>
    <span class="error"><?php echo $nombreErr; ?></span>

    <label>Tipo:</label>
    <select name="tipo" required>
        <option value="">Seleccione un tipo</option>
        <option value="Cereal" <?php if($tipo=="Cereal") echo "selected"; ?>>Cereal</option>
        <option value="Leguminosa" <?php if($tipo=="Leguminosa") echo "selected"; ?>>Leguminosa</option>
        <option value="Oleaginosa" <?php if($tipo=="Oleaginosa") echo "selected"; ?>>Oleaginosa</option>
        <option value="Hortaliza" <?php if($tipo=="Hortaliza") echo "selected"; ?>>Hortaliza</option>
        <option value="Frutal" <?php if($tipo=="Frutal") echo "selected"; ?>>Frutal</option>
        <option value="Ornamental" <?php if($tipo=="Ornamental") echo "selected"; ?>>Ornamental</option>
        <option value="Tubérculo" <?php if($tipo=="Tubérculo") echo "selected"; ?>>Tubérculo</option>
        <option value="Forrajera" <?php if($tipo=="Forrajera") echo "selected"; ?>>Forrajera</option>
        <option value="Aromática" <?php if($tipo=="Aromática") echo "selected"; ?>>Aromática</option>
    </select>
    <span class="error"><?php echo $tipoErr; ?></span>

    <label>Días para cosecha:</label>
    <input type="number" name="dias" value="<?php echo sanitizarSalida($dias); ?>" min="1" required>
    <span class="error"><?php echo $diasErr; ?></span>

    <input type="submit" value="Agregar Cultivo">
</form>

<a href="index.php">Volver al listado</a>

</body>
</html>