<?php
date_default_timezone_set('America/La_Paz');
require_once('../../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../../Conexion_BD/Dbms.php';
$regenerarWord = isset($_GET['REGENERAR_WORD']) && $_GET['REGENERAR_WORD'] === '1';
$COD_ASOCIACION = $regenerarWord && isset($_GET['COD_ASOCIACION']) && is_scalar($_GET['COD_ASOCIACION'])
    ? (string)$_GET['COD_ASOCIACION']
    : (isset($_POST['COD_ASOCIACION']) && is_scalar($_POST['COD_ASOCIACION'])
    ? (string)$_POST['COD_ASOCIACION']
    : '');
$COD_ASOCIACION = $COD_ASOCIACION !== '' ? $COD_ASOCIACION : (isset($_SESSION['COD_ASOCIACION']) ? $_SESSION['COD_ASOCIACION'] : '');
$COD_REGISTRO = $regenerarWord && isset($_GET['COD_REGISTRO']) && is_scalar($_GET['COD_REGISTRO'])
    ? (string)$_GET['COD_REGISTRO']
    : (isset($_SESSION['COD_REGISTRO']) ? $_SESSION['COD_REGISTRO'] : '');
$ASOCIACION = isset($_SESSION['ASOCIACION']) ? $_SESSION['ASOCIACION'] : '';
$txtDocumento = isset($_SESSION['txtDocumento']) ? $_SESSION['txtDocumento'] : '';
$txtFecha = isset($_SESSION['txtFecha']) ? $_SESSION['txtFecha'] : '';
$txtCont = isset($_POST['txtCont']) && is_scalar($_POST['txtCont'])
    ? trim((string)$_POST['txtCont'])
    : '';
$SIOICARGO = isset($_SESSION['SIOICARGO']) ? $_SESSION['SIOICARGO'] : '';
if ($COD_ASOCIACION === '' || $COD_REGISTRO === '' || $SIOICARGO === '' ||
    (!$regenerarWord && ($ASOCIACION === '' || $txtDocumento === '' || $txtFecha === '' || !preg_match('/^[0-9]+$/', $txtCont)))) {
    die('NO SE PUEDE GENERAR LA COMUNICACIÓN INTERNA: FALTAN DATOS DEL TRÁMITE O DEL USUARIO.');
}
$COD_ASOCIACION = mysql_real_escape_string($COD_ASOCIACION);
$COD_REGISTRO = mysql_real_escape_string($COD_REGISTRO);
$GESTION = date('Y');
$ENLACE = '';
$NOMBRE_ARCHIVO = '';
$CODIGO_NRO = 0;
$GESTION_PAGO = $GESTION - 1;
$ANIOS = $GESTION - 1;
if ($regenerarWord) {
    $registroQuery = mysql_query("select ENLACE,COMUNICACION_INTERNA,DOCUMENTO,FECHA_DOCUMENTO,GESTION from reg_contribuyente_habilitado_pago_cambio_nombre where CODIGO_REGISTRO='$COD_REGISTRO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' limit 1") or die('NO SE PUDO CONSULTAR EL REGISTRO PARA REGENERAR LA COMUNICACION INTERNA EN WORD.');
    $registro = mysql_fetch_assoc($registroQuery);
    if (!$registro || !preg_match('/^[0-9]{4}\/[A-Za-z0-9_-]+$/', $registro['ENLACE'])) {
        die('NO SE PUEDE REGENERAR EL DOCUMENTO WORD: EL REGISTRO NO TIENE UN ENLACE DE COMUNICACION INTERNA VALIDO.');
    }
    $enlacePartes = explode('/', $registro['ENLACE'], 2);
    $GESTION = $enlacePartes[0];
    $ENLACE = $enlacePartes[1];
    if (!preg_match('/^([A-Za-z0-9_]+_CN_0)([0-9]+)_([0-9]{4})$/', $ENLACE, $numeroPartes) ||
        $numeroPartes[3] !== $GESTION) {
        die('NO SE PUEDE REGENERAR EL DOCUMENTO WORD: EL NUMERO DE COMUNICACION NO ES VALIDO.');
    }
    $CODIGO_NRO = (int)$numeroPartes[2];
    $NOMBRE_ARCHIVO = str_replace('_', '/', $ENLACE);
    $NUMERO_COMUNICACION = str_replace('_', '/', $numeroPartes[1]).$CODIGO_NRO.'/'.$GESTION;
    $GESTION_PAGO = $registro['GESTION'];
    $ANIOS = $GESTION_PAGO;
    $txtDocumento = $registro['DOCUMENTO'];
    $txtFecha = $registro['FECHA_DOCUMENTO'];
    $txtContQuery = mysql_query("select count(*) as TOTAL from reg_contribuyente_habilitado_pago_cambio_nombre where CODIGO_REGISTRO='$COD_REGISTRO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'") or die('NO SE PUDO CONTAR LA NOMINA PARA REGENERAR LA COMUNICACION INTERNA EN WORD.');
    $txtContRow = mysql_fetch_assoc($txtContQuery);
    $txtCont = $txtContRow ? (string)$txtContRow['TOTAL'] : '0';
    $nombreQuery = mysql_query("select DESCRIPCION from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' limit 1") or die('NO SE PUDO CONSULTAR LA ASOCIACION DEL REGISTRO.');
    $nombreRow = mysql_fetch_assoc($nombreQuery);
    $ASOCIACION = $nombreRow ? $nombreRow['DESCRIPCION'] : '';
    if ($ASOCIACION === '' || $txtDocumento === '' || $txtFecha === '' || (int)$txtCont === 0) {
        die('NO SE PUEDE REGENERAR EL DOCUMENTO WORD: FALTAN DATOS ACTIVOS DEL TRAMITE.');
    }
}
$cont=0;
$ANIOS = $regenerarWord ? $ANIOS : date('Y') - 1;
$ENCONTRADO=0;
$SEC_GENERAL='NO DEFINIDO';
$CONTACTOS='';
//crea carpeta
$serv = dirname(__FILE__) . '/';
$ruta = $serv . $GESTION;
if (!is_dir($ruta) && !mkdir($ruta, 0755, true) && !is_dir($ruta)) {
    die('NO SE PUDO CREAR EL DIRECTORIO DE COMUNICACIONES INTERNAS.');
}
if (!$regenerarWord) {
    $res=mysql_query("select * from nros_comunicacion_interna_cambio_nombre where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
    $ENCONTRADO=1;
    }
    if($ENCONTRADO==1){}else{
    $query = mysql_query("UPDATE nros_comunicacion_interna_cambio_nombre  SET ESTADO='NO ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna_cambio_nombre.");
    $sql1="insert into nros_comunicacion_interna_cambio_nombre(GESTION,NRO)values('$GESTION','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_comunicacion_interna_cambio_nombre.");
    }
}
//extrae DATOS del secretario general
$res=mysql_query("select SG.DOC_IDENTIDAD,SG.DOC_IDENTIDAD_ALFA,SG.EXPEDIDO,SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,SG.APELLIDO_ESPOSO,SG.TELEFONO,SG.CELULAR,SG.EMAIL  from reg_secretario_general_asociacion RSGA, secretario_general SG where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL and RSGA.ESTADO='ACTIVO' and RSGA.GESTION='$ANIOS' and SG.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ if($row[6]== null){$SEC_GENERAL=$row[3].' '.$row[4].' '.$row[5].', REFERENCIAS: ';}else{$SEC_GENERAL= $row[3].' '.$row[4].' '.$row[5].' de '.$row[6].', REFERENCIA (S):';}
			  if(strlen($row[7])>6 ){$CONTACTOS=' TEL.'.$row[7].'.';}
			   if(strlen($row[8])>7){$CONTACTOS=$CONTACTOS.' CEL.'.$row[8].'.';}
			   if(strlen($row[9])>10){$CONTACTOS=$CONTACTOS.' EMAIL '.$row[9].'.';}
			  
			  }
if($SEC_GENERAL==null){$SEC_GENERAL='NO DEFINIDO';}

$result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
	if($row['AFILIADOS']==0){$AFILIADOS=$row['OBSERVACIONES'];}else{
$AFILIADOS=$row['AFILIADOS'];}
$OM=$row['ORDENANZA_MUNICIPAL'];
$ASOCIACION=$row['DESCRIPCION'];
$LUGARES_ASENT=$row['ZONA_UBICACION'];
$LUGARES_ASENTA=$row['DIRECCION'];
	}
//OBTIENE LA ZONA TRIBUTARIA
$result=mysql_query("select ZT.DESCRIPCION from reg_asociacion_zona_tributaria AZT,zona_tributaria ZT where AZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and ZT.CODIGO_ZONA=AZT.CODIGO_ZONA and AZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
$ZONATRIBUTARIA=$row['0'];

	}

if (!$regenerarWord) {
    $res=mysql_query("select * from nros_comunicacion_interna_cambio_nombre where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
    $CODIGO_NRO=$ro['NRO']+1;
    }
    if (!isset($CODIGO_NRO) || (int)$CODIGO_NRO < 1) {
        die('NO SE PUDO OBTENER EL NUMERO DE COMUNICACION INTERNA.');
    }
    $query = mysql_query("UPDATE nros_comunicacion_interna_cambio_nombre SET NRO='$CODIGO_NRO' where GESTION='$GESTION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna_cambio_nombre.");
    $NOMBRE_ARCHIVO='SMSC/DFM/UF/ARP/CN/0'.$CODIGO_NRO.'/'.$GESTION;
    $ENLACE='SMSC_DFM_UF_ARP_CN_0'.$CODIGO_NRO.'_'.$GESTION;
    $NUMERO_COMUNICACION='SMSC/DFM/UF/ARP/CN/0'.$CODIGO_NRO.'/'.$GESTION;
    $GESTION_PAGO=$GESTION-1;
}

$dias = array('domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado');
$meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
$fechaEmisionTimestamp = time();
$HOY_ES = $dias[date('w', $fechaEmisionTimestamp)].', '.date('d', $fechaEmisionTimestamp).' de '.$meses[(int)date('n', $fechaEmisionTimestamp) - 1].' de '.date('Y', $fechaEmisionTimestamp);
require_once(dirname(__FILE__) . '/../../Complemento_Contribuyentes/Pdf_Complementos/WordComplemento.php');
$NOMB_EMISOR = trim($SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO);
$resulty=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' and NIVEL is not null and trim(NOMBRE_A)<>'' and trim(CARGO_A)<>'' order by NIVEL ") or die('NO SE PUDO CONSULTAR LA CONFIGURACION DE AUTORIDADES PARA LA COMUNICACION INTERNA.');
$destinatarios = array();
while($rowy=mysql_fetch_array($resulty)){
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
    array('NOMBRE LA ASOCIACION', $ASOCIACION),
    array('CANTIDAD DE AFILIADOS SEGUN '.$OM, $AFILIADOS),
    array('CANTIDAD AUTORIZADO PARA PAGAR EL CAMBIO DE NOMBRE ', $txtCont.' PUESTO(S) DE VENTA'),
    array('LUGAR DE ASENTAMIENTO', $LUGARES_ASENT.' - '.$LUGARES_ASENTA),
    array('NOMBRE DEL (LA) SECRETARIO (A) GENERAL', $SEC_GENERAL.' '.$CONTACTOS)
);
$encabezadoContribuyentes = array(
    'Nro.',
    'DOCUMENTO DE IDENTIFICACION',
    'NOMBRE(S) Y APELLIDO(S)',
    'POR TIPO DE CAMBIO',
    'DOCUMENTO DE IDENTIFICACION',
    'NOMBRE(S) Y APELLIDO(S)',
    'ACTIVIDAD',
    'FILA',
    'PUESTO'
);
$filasContribuyentes = array();
$conts = 0;
$res=mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,C.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_CAMBIO,RCHPC.TIPO_PUESTO,RCHPC.FILA,RCHPC.PUESTO,RCHPC.CODIGO_CONTRIBUYENTE_ENTRANTE from reg_contribuyente_habilitado_pago_cambio_nombre RCHPC,contribuyentes C where RCHPC.CODIGO_REGISTRO='$COD_REGISTRO' and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHPC.ESTADO='ACTIVO' and RCHPC.CODIGO_CONTRIBUYENTE_SALIENTE=C.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){
    $conts++;
    $CIS = $row[1] == null ? $row[0].' '.$row[2] : $row[0].' - '.$row[1].' '.$row[2];
    $NOMBRES = $row[6] == null
        ? $row[3].' '.$row[4].' '.$row[5]
        : $row[3].' '.$row[4].' '.$row[5].' de '.$row[6];
    $CISE = '';
    $NOMBRESE = '';
    $CODIGO_CONTRIBUYENTE_ENTRANTE = mysql_real_escape_string($row[13]);
    $rest=mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,C.CODIGO_CONTRIBUYENTE from reg_contribuyente_habilitado_pago_cambio_nombre RCHPC,contribuyentes C where RCHPC.CODIGO_REGISTRO='$COD_REGISTRO' and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHPC.ESTADO='ACTIVO' and C.CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE_ENTRANTE' and C.ESTADO='ACTIVO'");
    while($rowt=mysql_fetch_array($rest)){
        $CISE = $rowt[1] == null ? $rowt[0].' '.$rowt[2] : $rowt[0].' - '.$rowt[1].' '.$rowt[2];
        $NOMBRESE = $rowt[6] == null
            ? $rowt[3].' '.$rowt[4].' '.$rowt[5]
            : $rowt[3].' '.$rowt[4].' '.$rowt[5].' de '.$rowt[6];
    }
    $filasContribuyentes[] = array(
        (string)$conts,
        $CIS,
        trim($NOMBRES),
        $row[9],
        $CISE,
        trim($NOMBRESE),
        $row[10],
        $row[11],
        $row[12]
    );
}
$introduccion = 'En atención a solicitud de cambio de nombre, presentada por la '.$ASOCIACION.', en hoja de ruta con registro interno '.$txtDocumento.' en fecha '.$txtFecha.', y en cumplimiento a la RESOLUCION ADMINISTRATIVA MUNICIPAL BI-SECTORIAL No. 001/2019 "DE LOS REQUISITOS Y PROCEDIMIENTOS PARA EL CAMBIO DE NOMBRE POR ALTAS Y BAJAS, ABANDONO Y FALLECIMIENTO POR ASENTAMIENTO DE TRABAJADORES GREMIALES, ARTESANOS, COMERCIANTES MINORISTAS Y VIVANDEROS Y MERCADOS EN EL MUNICIPIO DE EL ALTO". Se remite la autorización para el pago de cambio de nombre, haciendo constar que el nombre del entrante ya se encuentra registrado en la Herramienta Informática Gremial de acuerdo a las siguientes características:';
$wordPath = generarWordComplementacion(
    $ruta,
    $ENLACE,
    array(
        'numero' => $NUMERO_COMUNICACION,
        'fecha' => $HOY_ES,
        'destinatarios' => $destinatarios,
        'emisor' => $NOMB_EMISOR,
        'cargoEmisor' => $SIOICARGO,
        'gestion' => $GESTION_PAGO,
        'referencia' => 'AUTORIZACIÓN DE PAGO POR CAMBIO DE NOMBRE GESTIÓN '.$GESTION_PAGO,
        'introduccion' => $introduccion,
        'resumen' => $resumen,
        'tituloLista' => 'A continuación se detalla la lista de contribuyente(s) Autorizados para el CAMBIO DE NOMBRE:',
        'grupoEncabezadoContribuyentes' => array(
			array('text' => 'PRUEBA ENCABEZADO 4 COLUMNAS', 'span' => 4, 'align' => 'center'),
			array('text' => 'DATOS CONTRIBUYENTE ENTRANTE', 'span' => 2, 'align' => 'center'),
			array('text' => 'DESCRIPCION PUESTO DE VENTA', 'span' => 3, 'align' => 'center')
		),
        'encabezadoContribuyentes' => $encabezadoContribuyentes,
        'anchosContribuyentes' => array(420, 950, 1450, 900, 950, 1450, 1050, 800, 870),
        'tamanoLetraTablaContribuyentes' => 6,
        'contribuyentes' => $filasContribuyentes,
        'usuario' => $US_SIOI,
        'cierre' => 'Atentamente,',
        'copias' => array('c.c./Arch.', 'c.c./D.F.M. '.$US_SIOI)
    )
);
if (!$regenerarWord) {
    $NOMBRE_ARCHIVO_SQL = mysql_real_escape_string($NOMBRE_ARCHIVO);
    $ENLACE_SQL = mysql_real_escape_string($GESTION.'/'.$ENLACE);
    $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_cambio_nombre SET COMUNICACION_INTERNA='$NOMBRE_ARCHIVO_SQL',ENLACE='$ENLACE_SQL',ESTADO_COMUNICACION_INTERNA='GENERADO' where CODIGO_REGISTRO='$COD_REGISTRO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago_cambio_nombre.");

    $USUARIO_SQL = mysql_real_escape_string($US_SIOI);
    $NOMBRE_USUARIO_SQL = mysql_real_escape_string($NOMB_EMISOR);
    $COD_REGISTRO_SQL = mysql_real_escape_string($COD_REGISTRO);
    $ASOCIACION_SQL = mysql_real_escape_string($ASOCIACION);
    $AUDIT_DESCRIPTION_SQL = mysql_real_escape_string('GENERO COMUNICACION INTERNA DE CAMBIO DE NOMBRE '.$NOMBRE_ARCHIVO);
    $sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$USUARIO_SQL','$NOMBRE_USUARIO_SQL','$FECHA','$HORA','$COD_REGISTRO_SQL','$COD_ASOCIACION','$ASOCIACION_SQL','COMUNICACION INTERNA CAMBIO DE NOMBRE','$AUDIT_DESCRIPTION_SQL','$AUDIT_DESCRIPTION_SQL','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
}
require '../../Conexion_BD/Cerrar_Dbms.php';
$nombreDescarga = $ENLACE.'.docx';
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.$nombreDescarga.'"');
header('Content-Length: '.filesize($wordPath));
readfile($wordPath);
?>