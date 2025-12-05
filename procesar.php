<?php

require_once "config/db.php";

require_once "logic/cultivos.php";


$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$dias = filter_input(INPUT_POST, 'dias', FILTER_VALIDATE_INT);


if (!$nombre || trim($nombre) === '') {
    $error = "Nombre inválido o vacío.";
} elseif (!$tipo || !validarTipoCultivo($tipo)) {
    $error = "Tipo de cultivo inválido.";
} elseif ($dias === false || $dias <= 0) {
    $error = "Días para cosecha inválidos.";
}

if (isset($error)) {
    header("Location: nuevo.php?error=" . urlencode($error));
    exit;
}


$sql = "INSERT INTO cultivos (nombre, tipo, dias_cosecha) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
    
    error_log("Error preparando sentencia: " . mysqli_error($conexion));
    header("Location: nuevo.php?error=" . urlencode("Error interno del sistema."));
    exit;
}


mysqli_stmt_bind_param($stmt, "ssi", $nombre, $tipo, $dias);


if (mysqli_stmt_execute($stmt)) {
    
    header("Location: index.php?success=1");
    exit;
} else {
    
    error_log("Error ejecutando sentencia: " . mysqli_stmt_error($stmt));
    header("Location: nuevo.php?error=" . urlencode("No se pudo guardar el cultivo. Intente nuevamente."));
    exit;
}


mysqli_stmt_close($stmt);
?>