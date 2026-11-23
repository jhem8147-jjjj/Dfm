<?php $hostname_conexion_usuarios = getenv('DB_HOST') ?: "localhost";
$database_conexion_usuarios = "usuarios_drm";
$username_conexion_usuarios = getenv('DB_USER') ?: "root";
$password_conexion_usuarios = getenv('DB_PASSWORD') ?: "cysgodion";
$conexion_usuarios = mysql_pconnect($hostname_conexion_usuarios, $username_conexion_usuarios, $password_conexion_usuarios) or trigger_error(mysql_error(), E_USER_ERROR);
mysql_select_db($database_conexion_usuarios, $conexion_usuarios);

mysql_set_charset("utf8", $conexion_usuarios)
    or trigger_error(mysql_error($conexion_usuarios), E_USER_ERROR);