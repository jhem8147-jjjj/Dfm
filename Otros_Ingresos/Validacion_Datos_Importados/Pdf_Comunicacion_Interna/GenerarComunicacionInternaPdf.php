<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/Complemento_Contribuyentes/Pdf_Complementos/WordComplemento.php');

$COMUNICACION_INTERNA = 'DFM/AC/AP/00'.$CODIGO_NRO.'/'.$GESTION;
$wordRelativePath = $GESTION.'/'.$NOMBRE;
$wordDirectory = dirname(__FILE__).'/generated/'.$GESTION;
if (!is_dir($wordDirectory) && !mkdir($wordDirectory, 0755, true) && !is_dir($wordDirectory)) {
    die('No se pudo crear el directorio de Comunicaciones Internas en Word.');
}
if (!is_writable($wordDirectory)) {
    die('El directorio de Comunicaciones Internas en Word no tiene permisos de escritura.');
}

$NOMB_EMISOR = trim($SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO);
$resulty=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' and NIVEL is not null and trim(NOMBRE_A)<>'' and trim(CARGO_A)<>'' order by NIVEL ");
$destinatarios = array();
while ($rowy=mysql_fetch_array($resulty)) {
    if (strcasecmp(trim($rowy['NOMBRE_A']), $NOMB_EMISOR) === 0) {
        continue;
    }
    $destinatarios[] = array(
        'etiqueta' => $rowy['NIVEL'] == 'NIVEL 1' ? 'A:' : 'VIA:',
        'nombre' => $rowy['NOMBRE_A'],
        'cargo' => $rowy['CARGO_A']
    );
}

$filasContribuyentes = array();
$idsContribuyentes = array();
$conts = 0;
$res=mysql_query("select  CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCA.GESTION,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO,RCA.Id,CONTRI.APELLIDO_ESPOSO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO_SQL' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion_SQL'");
while ($row=mysql_fetch_array($res)) {
    $conts++;
    if ($row[1] == null) {
        $CIS = $row[0].' '.$row[2];
    } else {
        $CIS = $row[0].' - '.$row[1].' '.$row[2];
    }
    if ($row[6] == null) {
        $NOMBRES = $row[3].' '.$row[4].' '.$row[5];
    } else {
        $NOMBRES = $row[3].' '.$row[4].' '.$row[5].' de '.$row[6];
    }
    $filasContribuyentes[] = array(
        (string)$conts,
        $CIS,
        trim($NOMBRES),
        $row[7],
        $row[8],
        $row[9],
        $row[10]
    );
    $idsContribuyentes[] = $row[14];
}

$datosWord = array(
    'numero' => $COMUNICACION_INTERNA,
    'fecha' => $HOY_ES,
    'destinatarios' => $destinatarios,
    'emisor' => $NOMB_EMISOR,
    'cargoEmisor' => $SIOICARGO,
    'referencia' => 'AUTORIZACIÓN DE PAGO DE PATENTE EVENTUAL',
    'gestion' => $sltGestion,
    'introduccion' => 'En atención a la solicitud de pago de Patente presentada por la Asociación, se remite la autorización para el pago de patente eventual de acuerdo a las siguientes características:',
    'resumen' => array(
        array('NOMBRE DE LA ASOCIACIÓN', $ASOCIACION),
        array('CANTIDAD DE AFILIADOS SEGÚN '.$OM, $AFILIADOS.' PUESTOS DE VENTA.'),
        array('CANTIDAD AUTORIZADA PARA EL PAGO DE PATENTE', $conts.' PUESTOS DE VENTA.'),
        array('ZONIFICACIÓN', '"'.$ZONATRIBUTARIA.'"'),
        array('GESTIÓN CORRESPONDIENTE AL PAGO', $sltGestion),
        array('LUGAR DE ASENTAMIENTO', $LUGARES_ASENT.' - '.$LUGARES_ASENTA),
        array('NOMBRE DEL (LA) SECRETARIO (A) GENERAL', $SEC_GENERAL.' '.$CONTACTOS)
    ),
    'parrafoAdicional' => 'El asentamiento en vía pública es de carácter estrictamente provisional según lo establece la Ley Municipal 291/2015 y su reglamentación Decreto Municipal 046/2015. A la presente se adjunta la lista de contribuyente(s) autorizados para la emisión de los comprobantes de pago de Impuesto Anual Eventual para la gestión: '.$sltGestion.'.',
    'tituloLista' => 'LISTA DE AFILIADOS AUTORIZADOS - '.$OM.' - '.$ASOCIACION,
    'encabezadoContribuyentes' => array('No.', 'NRO. DE DOCUMENTO', 'NOMBRE(S) Y APELLIDO(S)', 'GESTIÓN', 'DESCRIPCIÓN DE PUESTO', 'FILA', 'PUESTO'),
    'anchosContribuyentes' => array(450, 1190, 2040, 850, 2100, 1080, 1130),
    'tamanoLetraTablaContribuyentes' => 7,
    'contribuyentes' => $filasContribuyentes,
    'detalleFinal' => 'Cantidad de afiliados habilitados para el Pago de Patente Eventual: '.$conts.' Registro(s).',
    'copias' => array('Adjunto lo indicado', 'c.c./Archivo', 'c.c. FilePersonal'),
    'usuario' => $NOMB_EMISOR
);
try {
    $wordPath = generarWordComplementacion($wordDirectory, $NOMBRE, $datosWord);
} catch (Exception $exception) {
    die($exception->getMessage());
}

$wordRelativePathSql = mysql_real_escape_string($wordRelativePath);
$COMUNICACION_INTERNA_SQL = mysql_real_escape_string($COMUNICACION_INTERNA);
foreach ($idsContribuyentes as $idContribuyente) {
    $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago SET COMUNICACION_INTERNA='$COMUNICACION_INTERNA_SQL', ENLACE='$wordRelativePathSql' where Id='$idContribuyente' and CODIGO_REGISTRO='$CODIGO_REGISTRO_SQL' and ESTADO='ACTIVO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");
}

$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION_SQL','$ASOCIACION_SQL','COMUNICACION INTERNA PAGO IMPUESTO ANUAL $sltGestion_SQL','COMUNICACION INTERNA - $COMUNICACION_INTERNA.','COMUNICACION INTERNA - $COMUNICACION_INTERNA.','0')";
$result=mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
$sql1="insert into reg_comunicacion_interna(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,COMUNICACION_INTERNA,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION_SQL','$ASOCIACION_SQL','$COMUNICACION_INTERNA','$wordRelativePathSql - PARA LA GESTION $sltGestion_SQL')";
$result=mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");

require '../../Conexion_BD/Cerrar_Dbms.php';
$nombreDescarga = $NOMBRE.'.docx';
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.$nombreDescarga.'"');
header('Content-Length: '.filesize($wordPath));
readfile($wordPath);
?>
