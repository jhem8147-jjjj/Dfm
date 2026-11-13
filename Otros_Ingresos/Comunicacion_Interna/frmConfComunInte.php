<?php
header('Content-Type: text/html; charset=UTF-8');
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require '../Conexion_BD/Dbms.php';

function comunicacionInternaRequestValue($name, $includeGet = false)
{
	$sources = $includeGet ? array($_POST, $_GET) : array($_POST);
	foreach ($sources as $source) {
		if (isset($source[$name]) && is_scalar($source[$name])) {
			return (string)$source[$name];
		}
	}
	return '';
}

$REG = comunicacionInternaRequestValue('REG');
$REGMOD = comunicacionInternaRequestValue('REGMOD');
$ELIMINAR = comunicacionInternaRequestValue('ELIMINAR');
$NIVEL = comunicacionInternaRequestValue('NIVEL', true);
$sltNivel = comunicacionInternaRequestValue('sltNivel');
$txtGrado = trim(comunicacionInternaRequestValue('txtGrado'));
$txtNombres = trim(comunicacionInternaRequestValue('txtNombres'));
$txtCargo = trim(comunicacionInternaRequestValue('txtCargo'));
$mensajeConfiguracion = '';
$CODIGO_REGISTRO=date('Ymd His');
$accion = '';
$nivelActivo = mysql_real_escape_string($sltNivel);
$nivelAnterior = mysql_real_escape_string($NIVEL);
$nombreAutoridad = trim($txtGrado . ' ' . $txtNombres);
$nombreAutoridad = mysql_real_escape_string($nombreAutoridad);
$nivelAuditoria = $NIVEL;
$cargoAutoridad = mysql_real_escape_string($txtCargo);
$usuarioSql = mysql_real_escape_string($US_SIOI);
$nombreUsuarioSql = mysql_real_escape_string("$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO");
$hostSql = mysql_real_escape_string($hostname);
$ipSql = mysql_real_escape_string($hostlocal);
$fechaSql = mysql_real_escape_string($FECHA);
$horaSql = mysql_real_escape_string($HORA);

if ($REG == '1' || $REGMOD == '1') {
	if ($sltNivel === '' || $nombreAutoridad === '' || $cargoAutoridad === '' || ($REGMOD == '1' && $NIVEL === '')) {
		$mensajeConfiguracion = 'Complete el nivel, nombre y cargo de la autoridad.';
	} else {
		$nivelBuscado = $REGMOD == '1' ? $nivelAnterior : $nivelActivo;
		$consultaNivel = mysql_query("select id from reg_comunicacion_interna_autoridades where NIVEL='$nivelBuscado' and ESTADO='ACTIVO'") or die("No se pudo verificar el nivel de comunicación interna: " . mysql_error());
		if (($REG == '1' && mysql_num_rows($consultaNivel) > 0) || ($REGMOD == '1' && mysql_num_rows($consultaNivel) == 0)) {
			$mensajeConfiguracion = $REG == '1' ? 'El nivel seleccionado ya está configurado.' : 'No se encontró una configuración activa para modificar.';
		} else {
			if ($REGMOD == '1') {
				$observacion = mysql_real_escape_string("CONFIGURACION MODIFICADA POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA.");
				mysql_query("UPDATE reg_comunicacion_interna_autoridades SET ESTADO='NO ACTIVO', OBSERVACIONES='$observacion' WHERE NIVEL='$nivelAnterior' AND ESTADO='ACTIVO'") or die("No se pudo actualizar la autoridad de comunicación interna: " . mysql_error());
				$accion = 'MODIFICACION DE CONFIGURACION DE COMUNICACION INTERNA';
			} else {
				$accion = 'CONFIGURACION DE COMUNICACION INTERNA';
			}

			mysql_query("insert into reg_comunicacion_interna_autoridades(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,NIVEL,NOMBRE_A,CARGO_A) values('$hostSql','$ipSql','$usuarioSql','$nombreUsuarioSql','$fechaSql','$horaSql','$CODIGO_REGISTRO','$nivelActivo','$nombreAutoridad','$cargoAutoridad')") or die("No se pudo guardar la autoridad de comunicación interna: " . mysql_error());
			$nivelAuditoria = $sltNivel;
			$mensajeConfiguracion = $REGMOD == '1' ? 'La configuración fue modificada.' : 'La autoridad fue registrada.';
		}
	}
} elseif ($ELIMINAR == '1') {
	if ($NIVEL === '') {
		$mensajeConfiguracion = 'No se recibió el nivel que se desea eliminar.';
	} else {
		$nivelEscapado = mysql_real_escape_string($NIVEL);
		$nivelAuditoria = $NIVEL;
		$observacion = mysql_real_escape_string("CONFIGURACION ELIMINADA POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA.");
		$eliminacion = mysql_query("UPDATE reg_comunicacion_interna_autoridades SET ESTADO='NO ACTIVO', OBSERVACIONES='$observacion' WHERE NIVEL='$nivelEscapado' AND ESTADO='ACTIVO'") or die("No se pudo eliminar la autoridad de comunicación interna: " . mysql_error());
		if (mysql_affected_rows() > 0) {
			$accion = 'ELIMINACION DE CONFIGURACION DE COMUNICACION INTERNA';
			$mensajeConfiguracion = 'La autoridad fue desactivada.';
		} else {
			$mensajeConfiguracion = 'No se encontró una autoridad activa para ese nivel.';
		}
	}
}

if ($accion !== '') {
	$accionSql = mysql_real_escape_string($accion);
	$detalleSql = mysql_real_escape_string("$accion - $nivelAuditoria");
	mysql_query("insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE) values('$hostSql','$ipSql','$usuarioSql','$nombreUsuarioSql','$fechaSql','$horaSql','$CODIGO_REGISTRO','NO DEFINIDO','NO DEFINIDO','$accionSql','$detalleSql','$detalleSql','0')") or die("No se pudo registrar la auditoría de comunicación interna: " . mysql_error());
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
</head>

<body>
<?php if ($mensajeConfiguracion !== '') { ?>
<p align="center"><?php echo htmlspecialchars($mensajeConfiguracion, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO"> <?php $result=mysql_query("select * from nombre_formularios where UBICACION='CONFIGURAR COMUNICACION INTERNA' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Comunicación Interna</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Configuración de Comunicación Interna.</td>
      </tr>
      <tr>
        <td><img src="../Img/Linea_Negra.png" width="1070" height="19" /></td>
      </tr>
      <tr>
        <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
          <thead>
            <tr>
              <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">NIVEL</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">NOMBRE DE AUTORIDAD</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">CARGO DE AUTORIDAD</td>
              <td align="center" style="font-weight: bold">&nbsp;</td>
            </tr>
          </thead>
          <tbody>
            <?php $result=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' and NIVEL is not null and trim(NOMBRE_A)<>'' and trim(CARGO_A)<>'' order by NIVEL "); while($row=mysql_fetch_array($result)){ ?>
            <tr>
              <td><?php $CONT++; echo $CONT; ?></td>
              <td><?php if($row['NIVEL']=='NIVEL 1'){echo 'A';}else{echo $row['NIVEL'];} ?></td>
              <td><?php echo $row['NOMBRE_A']; ?></td>
              <td><?php echo $row['CARGO_A']; ?></td>
              <td align="center" style="font-weight: bold"><table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%"><img src="../Img/Modificares.jpg" width="30" height="30" /></td>
                  <td width="47%"><a href="frmConfComunInte2.php?NIVEL=<?php echo urlencode($row['NIVEL']);?>">Modificar</a></td>
                  <td width="7%" align="right"><img src="../Img/Eliminar.png" width="35" height="30" /></td>
                  <td width="33%"><form method="post" accept-charset="UTF-8" action="frmConfComunInte.php" onsubmit="return confirm('¿Desea desactivar esta autoridad?');"><input type="hidden" name="ELIMINAR" value="1" /><input type="hidden" name="NIVEL" value="<?php echo htmlspecialchars($row['NIVEL'], ENT_QUOTES, 'UTF-8'); ?>" /><button type="submit">Eliminar</button></form></td>
                </tr>
              </table>                <a href="frmSecretarioGeneral1.php?COD_ASOCIACION=<?php echo $row['5'];?>&ASOCIACION=<?php echo $row['1'];?>"></a></td>
            </tr> <?php } ?>
            <tr>
              <td><?php echo $CONT=$CONT+1;?></td>
              <td align="center"><a href="frmConfComunInte1.php">................</a></td>
              <td align="center"><a href="frmConfComunInte1.php">................</a></td>
              <td align="center"><a href="frmConfComunInte1.php">................</a></td>
              <td align="center" style="font-weight: bold"><table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right"><img src="../Img/Agregar.png" width="35" height="35" /></td>
                  <td><a href="frmConfComunInte1.php">Agregar Nuevo Nivel</a></td>
                </tr>
              </table>                <a href="frmConfComunInte1.php"></a></td>
            </tr>
            <tr>
              <td><?php echo $CONT=$CONT+1;?></td>
              <td>DE</td>
              <td><?php echo $SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO;?></td>
              <td><?php echo $SIOICARGO;?></td>
              <td align="center" style="font-weight: bold"></td>
            </tr>
           
            
          </tbody>
          <tfoot>
          </tfoot>
          <tfoot>
          </tfoot>
        </table></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 0</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>