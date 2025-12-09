<?php
function cargarEnv() {
    $envPath = dirname(__DIR__) . '/.env';
    
    if (!file_exists($envPath)) {
       
        return [
            'DB_HOST' => 'localhost',
            'DB_USER' => '', 
            'DB_PASS' => '', 
            'DB_NAME' => 'huerta_db'
        ];
    }
    
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $envVars = [];
    
    foreach ($lines as $line) {
       
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $envVars[trim($name)] = trim($value);
    }
    
    return $envVars;
}


$env = cargarEnv();


$host = $env['DB_HOST'];
$usuario = $env['DB_USER'];     
$contra = $env['DB_PASS'];     
$basedatos = $env['DB_NAME'];


$conexion = mysqli_connect($host, $usuario, $contra, $basedatos);

if (!$conexion) {
    
    error_log("Error de conexión MySQL para usuario: $usuario en host: $host");
    
   
    header('HTTP/1.1 500 Internal Server Error');
    die('<h2>Error de conexión</h2><p>No se puede conectar a la base de datos. Contacta al administrador.</p>');
}

mysqli_set_charset($conexion, "utf8mb4");

?>
