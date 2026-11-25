<?php
session_start();

if (empty($_SESSION['US_SIOI'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Debe iniciar sesión para descargar documentos.');
}

$archivo = isset($_GET['archivo']) && is_scalar($_GET['archivo'])
    ? (string)$_GET['archivo']
    : '';
$archivo = basename(str_replace('\\', '/', $archivo));

if ($archivo === '' || $archivo === '.' || $archivo === '..') {
    header('HTTP/1.1 400 Bad Request');
    exit('El nombre del documento no es válido.');
}

$extension = strtolower(substr(strrchr($archivo, '.'), 1));
$extensionesPermitidas = array('doc', 'docx', 'dotx', 'xls', 'xlsx', 'xltx', 'pdf', 'zip');
if (!in_array($extension, $extensionesPermitidas, true)) {
    header('HTTP/1.1 403 Forbidden');
    exit('El tipo de documento no está permitido para descarga.');
}

$directorio = realpath(dirname(__FILE__));
$ruta = realpath($directorio . DIRECTORY_SEPARATOR . $archivo);
$prefijoDirectorio = $directorio . DIRECTORY_SEPARATOR;
$estaDentroDelDirectorio = $ruta !== false &&
    (DIRECTORY_SEPARATOR === '\\'
        ? strncasecmp($ruta, $prefijoDirectorio, strlen($prefijoDirectorio)) === 0
        : strncmp($ruta, $prefijoDirectorio, strlen($prefijoDirectorio)) === 0);

if (!$estaDentroDelDirectorio || !is_file($ruta) || !is_readable($ruta)) {
    header('HTTP/1.1 404 Not Found');
    exit('El documento solicitado no está disponible.');
}

$tiposContenido = array(
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
    'xls' => 'application/vnd.ms-excel',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
    'pdf' => 'application/pdf',
    'zip' => 'application/zip'
);
$nombreSeguro = preg_replace('/[^A-Za-z0-9._-]/', '_', $archivo);

header('Content-Type: ' . $tiposContenido[$extension]);
header('Content-Disposition: attachment; filename="' . $nombreSeguro . '"; filename*=UTF-8\'\'' . rawurlencode($archivo));
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($ruta));
header('Cache-Control: private, must-revalidate');
header('Pragma: public');
readfile($ruta);
exit;
