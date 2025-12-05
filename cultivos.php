<?php
function cicloCultivo(int $dias): string {
    if ($dias <= 60) {
        return "Corto";
    } elseif ($dias <= 120) {
        return "Medio";
    } else {
        return "Tardío";
    }
}


function validarTipoCultivo(string $tipo): bool {
    $tiposValidos = [
        "Cereal", "Leguminosa", "Oleaginosa", "Hortaliza", 
        "Frutal", "Ornamental", "Tubérculo", "Forrajera", "Aromática"
    ];
    return in_array($tipo, $tiposValidos);
}


function sanitizarSalida(?string $texto): string {
    if ($texto === null) {
        return '';
    }
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>