<?php
date_default_timezone_set('America/La_Paz');
require_once('../../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../../Conexion_BD/Dbms.php';

$COD_ASOCIACION = isset($_SESSION['COD_ASOCIACION']) ? $_SESSION['COD_ASOCIACION'] : '';
$COD_REGISTRO = isset($_SESSION['COD_REGISTRO']) ? $_SESSION['COD_REGISTRO'] : '';
$txtCodigoRegistro = isset($_SESSION['txtCodigoRegistro']) ? $_SESSION['txtCodigoRegistro'] : '';
$txtDocumento = isset($_SESSION['txtDocumento']) ? $_SESSION['txtDocumento'] : '';
$txtFecha = isset($_SESSION['txtFecha']) ? $_SESSION['txtFecha'] : '';
$txtObservaciones = isset($_SESSION['txtObservaciones']) ? $_SESSION['txtObservaciones'] : '';
$sltGestion = isset($_SESSION['sltGestion']) ? $_SESSION['sltGestion'] : '';
$SIOICARGO = isset($_SESSION['SIOICARGO']) ? $_SESSION['SIOICARGO'] : '';
$ASOCIACION_SESION = isset($_SESSION['ASOCIACION']) ? $_SESSION['ASOCIACION'] : '';
$OMS_SESION = isset($_SESSION['OMS']) ? $_SESSION['OMS'] : '';

if ($COD_ASOCIACION === '' || $COD_REGISTRO === '' || $txtCodigoRegistro === '' || $txtDocumento === '' || $txtFecha === '' || $sltGestion === '' || $ASOCIACION_SESION === '' || $OMS_SESION === '' || $SIOICARGO === '') {
    die('FALTAN DATOS DE LA SOLICITUD DE COMPLEMENTACION. VUELVA A INICIAR EL TRAMITE.');
}

$GESTION = date('Y');
$GESTIONPAGO = $sltGestion;
$ANIOS = $sltGestion;
if (!preg_match('/^[0-9]{4}$/', $GESTIONPAGO)) {
    die('LA GESTION DE PAGO DE LA SOLICITUD NO ES VALIDA.');
}
$fechaPartes = array();
if (!preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $txtFecha, $fechaPartes) ||
    !checkdate((int)$fechaPartes[2], (int)$fechaPartes[3], (int)$fechaPartes[1])) {
    die('LA FECHA DEL DOCUMENTO DE SOLICITUD NO ES VALIDA.');
}
$FECHA_DOCUMENTO = $fechaPartes[3].'/'.$fechaPartes[2].'/'.$fechaPartes[1];
$cont = 0;
$conts = 0;
$ENCONTRADO = 0;
$SEC_GENERAL = 'NO DEFINIDO';
$CONTACTOS = '';
$AFILIADOS = '';
$OM = '';
$ASOCIACION = '';
$LUGARES_ASENT = '';
$LUGARES_ASENTA = '';
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$TXT_CODIGO_REGISTRO_SQL = mysql_real_escape_string($txtCodigoRegistro);
$GESTION_SQL = mysql_real_escape_string($GESTION);
$ANIOS_SQL = mysql_real_escape_string($ANIOS);

$directorioBase = dirname(__FILE__) . '/generated';
$ruta = $directorioBase . '/' . $GESTION;
if (!is_dir($directorioBase) && !mkdir($directorioBase, 0755) && !is_dir($directorioBase)) {
    trigger_error('No se pudo crear el directorio de almacenamiento de Comunicaciones Internas: ' . $directorioBase, E_USER_ERROR);
}
if (!is_dir($ruta) && !mkdir($ruta, 0755, true) && !is_dir($ruta)) {
    trigger_error('No se pudo crear el directorio de Comunicaciones Internas: ' . $ruta, E_USER_ERROR);
}
if (!is_writable($ruta)) {
    trigger_error('El directorio de Comunicaciones Internas no tiene permisos de escritura: ' . $ruta, E_USER_ERROR);
}
$res=mysql_query("select * from nros_comunicacion_interna_complemento where GESTION='$GESTION_SQL' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$ENCONTRADO=1;
}
if($ENCONTRADO==1){}else{
$query = mysql_query("UPDATE nros_comunicacion_interna_complemento  SET ESTADO='NO ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna_complemento.");
$sql1="insert into nros_comunicacion_interna_complemento(GESTION,NRO)values('$GESTION','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_comunicacion_interna_complemento.");
	}
$res=mysql_query("select RCHPC.TIPO_VENTA,RCHPC.FILA,RCHPC.PUESTO,C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO from reg_contribuyente_habilitado_pago_complementacion RCHPC inner join contribuyentes C on C.CODIGO_CONTRIBUYENTE=RCHPC.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO' where RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RCHPC.CODIGO_REGISTRO='$TXT_CODIGO_REGISTRO_SQL' and RCHPC.ESTADO='ACTIVO' order by RCHPC.ID") or die('NO SE PUDO CONSULTAR LA LISTA DE CONTRIBUYENTES DE LA COMPLEMENTACION.');
$contribuyentes = array();
while($row=mysql_fetch_assoc($res)){
    $contribuyentes[] = $row;
    $cont++;
}
if ($cont === 0) {
    die('NO HAY CONTRIBUYENTES ACTIVOS EN ESTA COMPLEMENTACION. NO SE GENERO LA COMUNICACION.');
}
//extrae DATOS del secretario general
$res=mysql_query("select SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,SG.APELLIDO_ESPOSO,SG.TELEFONO,SG.CELULAR,SG.EMAIL from reg_secretario_general_asociacion RSGA inner join secretario_general SG on RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL and SG.ESTADO='ACTIVO' where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RSGA.ESTADO='ACTIVO' and RSGA.GESTION='$ANIOS_SQL' order by SG.CODIGO_SECRETARIO_GENERAL desc limit 1") or die('NO SE PUDO CONSULTAR EL SECRETARIO GENERAL.');
$row = mysql_fetch_assoc($res);
if ($row) {
    $SEC_GENERAL = trim($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'].($row['APELLIDO_ESPOSO'] !== null && $row['APELLIDO_ESPOSO'] !== '' ? ' de '.$row['APELLIDO_ESPOSO'] : ''));
    if (strlen($row['TELEFONO']) > 6) { $CONTACTOS .= ' TEL.'.$row['TELEFONO'].'.'; }
    if (strlen($row['CELULAR']) > 7) { $CONTACTOS .= ' CEL.'.$row['CELULAR'].'.'; }
    if (strlen($row['EMAIL']) > 10) { $CONTACTOS .= ' EMAIL '.$row['EMAIL'].'.'; }
}

$result=mysql_query("select AFILIADOS,OBSERVACIONES,ORDENANZA_MUNICIPAL,DESCRIPCION,ZONA_UBICACION,DIRECCION from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO' limit 1") or die('NO SE PUDO CONSULTAR LA ASOCIACION.');
$row = mysql_fetch_assoc($result);
if (!$row) {
    die('LA ASOCIACION DE LA SOLICITUD YA NO ESTA ACTIVA.');
}
	if($row['AFILIADOS']==0){$AFILIADOS=$row['OBSERVACIONES'];}else{
$AFILIADOS=$row['AFILIADOS'];}
$OM=$row['ORDENANZA_MUNICIPAL'];
$ASOCIACION=$row['DESCRIPCION'];
$LUGARES_ASENT=$row['ZONA_UBICACION'];
$LUGARES_ASENTA=$row['DIRECCION'];

//OBTIENE LA ZONA TRIBUTARIA
$result=mysql_query("select ZT.DESCRIPCION from reg_asociacion_zona_tributaria AZT inner join zona_tributaria ZT on ZT.CODIGO_ZONA=AZT.CODIGO_ZONA and ZT.ESTADO='ACTIVO' where AZT.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and AZT.ESTADO='ACTIVO' order by ZT.DESCRIPCION limit 1") or die('NO SE PUDO CONSULTAR LA ZONA TRIBUTARIA.');
$row = mysql_fetch_assoc($result);
$ZONATRIBUTARIA = $row ? $row['DESCRIPCION'] : '';

$res=mysql_query("select * from nros_comunicacion_interna_complemento where GESTION='$GESTION_SQL' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO']+1;
}
$CODIGO_NRO = isset($CODIGO_NRO) ? (int)$CODIGO_NRO : 1;
$query = mysql_query("UPDATE nros_comunicacion_interna_complemento SET NRO='$CODIGO_NRO' where GESTION='$GESTION_SQL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna_complemento.");

$NOMBRE_ARCHIVO='SMSC/DFM/UF/ARP/CC/'.$CODIGO_NRO.'/'.$GESTION;
$ENLACE='SMSC_DFM_UF_ARP_CC_'.$CODIGO_NRO.'_'.$GESTION;
require_once(dirname(__FILE__) . '/WordComplemento.php');
$NOMB_EMISOR = trim($SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO);
$resulty = mysql_query("select NOMBRE_A,CARGO_A,NIVEL from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' and NIVEL is not null and trim(NOMBRE_A)<>'' and trim(CARGO_A)<>'' order by NIVEL") or die('NO SE PUDIERON CONSULTAR LAS AUTORIDADES.');
$destinatarios = array();
while ($rowy = mysql_fetch_assoc($resulty)) {
    $nombreAutoridad = complementoWordNormalizeAuthorityValue($rowy['NOMBRE_A']);
    $cargoAutoridad = complementoWordNormalizeAuthorityValue($rowy['CARGO_A']);
    $nivelAutoridad = complementoWordNormalizeAuthorityValue($rowy['NIVEL']);
    if ($nombreAutoridad === '' || $cargoAutoridad === '' || $nivelAutoridad === '') {
        continue;
    }
    if (strcasecmp($nombreAutoridad, $NOMB_EMISOR) === 0) {
        continue;
    }
    $destinatarios[] = array(
        'etiqueta' => strcasecmp($nivelAutoridad, 'NIVEL 1') === 0 ? 'A:' : 'VIA:',
        'nombre' => $nombreAutoridad,
        'cargo' => $cargoAutoridad
    );
}
$resumen = array(
    array('NOMBRE DE LA ASOCIACION', $ASOCIACION),
    array('CANTIDAD DE AFILIADOS SEGUN '.$OM, (string)$AFILIADOS),
    array('CANTIDAD AUTORIZADA PARA PAGO DE COMPLEMENTACION', $cont.' CONTRIBUYENTE(S)'),
    array('LUGAR DE ASENTAMIENTO', trim($LUGARES_ASENT.' - '.$LUGARES_ASENTA)),
    array('NOMBRE DEL (LA) SECRETARIO (A) GENERAL', trim($SEC_GENERAL.' '.$CONTACTOS))
);
if (trim($txtObservaciones) !== '' && strtoupper(trim($txtObservaciones)) !== 'SIN OBSERVACION.') {
    $resumen[] = array('OBSERVACIONES', $txtObservaciones);
}
$filasContribuyentes = array();
foreach ($contribuyentes as $indice => $row) {
    $CIS = $row['DOC_IDENTIDAD_ALFA'] === null || $row['DOC_IDENTIDAD_ALFA'] === ''
        ? $row['DOC_IDENTIDAD'].' '.$row['EXPEDIDO']
        : $row['DOC_IDENTIDAD'].' - '.$row['DOC_IDENTIDAD_ALFA'].' '.$row['EXPEDIDO'];
    $NOMBRES = $row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'];
    if ($row['APELLIDO_ESPOSO'] !== null && $row['APELLIDO_ESPOSO'] !== '') {
        $NOMBRES .= ' de '.$row['APELLIDO_ESPOSO'];
    }
    $filasContribuyentes[] = array(
        (string)($indice + 1),
        $CIS,
        trim($NOMBRES),
        $row['TIPO_VENTA'],
        $row['FILA'],
        $row['PUESTO']
    );
}
$fechaEmisionTimestamp = time();
$fechaDocumentoCompleta = $dias[date('w', $fechaEmisionTimestamp)].', '.date('d', $fechaEmisionTimestamp).' de '.$meses[date('n', $fechaEmisionTimestamp) - 1].' de '.date('Y', $fechaEmisionTimestamp);
$introduccion = 'En atención a la solicitud de complementación presentada por la '.$ASOCIACION.', mediante documento interno '.$txtDocumento.' de fecha '.$FECHA_DOCUMENTO.', correspondiente a la gestión '.$GESTIONPAGO.', y una vez revisada la nómina de contribuyentes comprendidos en dicha solicitud, se remite la presente Comunicación Interna para la autorización de pago del complemento, conforme al siguiente detalle.';
$wordPath = generarWordComplementacion(
    $ruta,
    $ENLACE,
    array(
        'numero' => 'SMSC/DFM/UF/ARP/CC/'.$CODIGO_NRO.'/'.$GESTION,
        'fecha' => $fechaDocumentoCompleta,
        'destinatarios' => $destinatarios,
        'emisor' => $NOMB_EMISOR,
        'cargoEmisor' => $SIOICARGO,
        'gestion' => $GESTIONPAGO,
        'introduccion' => $introduccion,
        'resumen' => $resumen,
        'contribuyentes' => $filasContribuyentes,
        'usuario' => $US_SIOI
    )
);
$NOMBRE_ARCHIVO_SQL = mysql_real_escape_string($NOMBRE_ARCHIVO);
$ENLACE_SQL = mysql_real_escape_string($GESTION.'/'.$ENLACE);
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion SET COMUNICACION_INTERNA='$NOMBRE_ARCHIVO_SQL',ENLACE='$ENLACE_SQL',ESTADO_COMUNICACION_INTERNA='GENERADO' where CODIGO_REGISTRO='$TXT_CODIGO_REGISTRO_SQL' and CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago_complementacion.");

$USUARIO_SQL = mysql_real_escape_string($US_SIOI);
$NOMBRE_USUARIO_SQL = mysql_real_escape_string($NOMB_EMISOR);
$COD_REGISTRO_AUDIT_SQL = mysql_real_escape_string($COD_REGISTRO);
$ASOCIACION_AUDIT_SQL = mysql_real_escape_string($ASOCIACION);
$AUDIT_DESCRIPTION_SQL = mysql_real_escape_string('GENERO COMUNICACION INTERNA COMPLEMENTO DE CONTRIBUYENTE '.$NOMBRE_ARCHIVO);
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$USUARIO_SQL','$NOMBRE_USUARIO_SQL','$FECHA','$HORA','$COD_REGISTRO_AUDIT_SQL','$COD_ASOCIACION_SQL','$ASOCIACION_AUDIT_SQL','COMUNICACION INTERNA COMPLEMENTO DE CONTRIBUYENTE','$AUDIT_DESCRIPTION_SQL','$AUDIT_DESCRIPTION_SQL','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
require '../../Conexion_BD/Cerrar_Dbms.php';
$nombreDescarga = $ENLACE.'.docx';
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.$nombreDescarga.'"');
header('Content-Length: '.filesize($wordPath));
readfile($wordPath);
?>