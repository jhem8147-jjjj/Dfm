<?php

$host = getenv('DB_HOST') ?: 'db';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '123456';

$conexion = @mysql_connect($host, $user, $pass);

if (!$conexion) {
    exit(1);
}

$resultado = @mysql_query(
    'SELECT 1 FROM otros_ingresos.__dfm_init_done LIMIT 1',
    $conexion
);

if (!$resultado) {
    mysql_close($conexion);
    exit(1);
}

mysql_close($conexion);
exit(0);
