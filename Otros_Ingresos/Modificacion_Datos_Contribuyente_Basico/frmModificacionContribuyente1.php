<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$txtCodigoContribuyente = isset($txtCodigoContribuyente) ? $txtCodigoContribuyente : (isset($_REQUEST['txtCodigoContribuyente']) ? $_REQUEST['txtCodigoContribuyente'] : '');
$txtCi = isset($txtCi) ? $txtCi : (isset($_REQUEST['txtCi']) ? $_REQUEST['txtCi'] : '');
$txtCi2 = isset($txtCi2) ? $txtCi2 : (isset($_REQUEST['txtCi2']) ? $_REQUEST['txtCi2'] : '');
$CodigoRegistro = isset($CodigoRegistro) ? $CodigoRegistro : (isset($_REQUEST['txtCodigoRegistro']) ? $_REQUEST['txtCodigoRegistro'] : '');
$cont = 0;
if (isset($_POST['REG']) && $_POST['REG'] == '1') {
    $txtCodigoContribuyente = isset($_POST['txtCodigoContribuyente']) ? trim($_POST['txtCodigoContribuyente']) : '';
    $txtCodigoRegistro = isset($_POST['txtCodigoRegistro']) ? trim($_POST['txtCodigoRegistro']) : '';
    $txtCi = isset($_POST['txtCi']) ? trim($_POST['txtCi']) : '';
    $txtCi2 = isset($_POST['txtCi2']) ? limpia_espacios(trim($_POST['txtCi2'])) : '';
    $sltExpedido = isset($_POST['sltExpedido']) ? limpia_puntos(trim($_POST['sltExpedido'])) : '';
    $txtNombres = isset($_POST['txtNombres']) ? normaliza($_POST['txtNombres']) : '';
    $txtPrimerApellido = isset($_POST['txtPrimerApellido']) ? normaliza($_POST['txtPrimerApellido']) : '';
    $txtSegundoApellido = isset($_POST['txtSegundoApellido']) ? normaliza($_POST['txtSegundoApellido']) : '';
    $txtApellidoEsposo = isset($_POST['txtApellidoEsposo']) ? normaliza($_POST['txtApellidoEsposo']) : '';
    $txtObservaciones = isset($_POST['txtObservaciones']) ? normaliza($_POST['txtObservaciones']) : '';
    $error = '';

    if (!isset($_POST['checkbox'])) {
        $error = 'Debe marcar la casilla de autorizacion.';
    } elseif ($txtCodigoContribuyente === '' || $txtCodigoRegistro === '' || $txtCi === '' || $txtNombres === '' || $txtPrimerApellido === '' || $txtObservaciones === '') {
        $error = 'Complete todos los campos obligatorios.';
    } elseif (!preg_match('/^[0-9]+$/', $txtCi)) {
        $error = 'El numero de carnet debe contener solamente numeros.';
    }

    $codigoSeguro = mysql_real_escape_string($txtCodigoContribuyente);
    $registroSeguro = mysql_real_escape_string($txtCodigoRegistro);
    $ciSeguro = mysql_real_escape_string($txtCi);
    $ci2Seguro = mysql_real_escape_string($txtCi2);
    $expedidoSeguro = mysql_real_escape_string($sltExpedido);
    $nombresSeguro = mysql_real_escape_string($txtNombres);
    $primerSeguro = mysql_real_escape_string($txtPrimerApellido);
    $segundoSeguro = mysql_real_escape_string($txtSegundoApellido);
    $esposoSeguro = mysql_real_escape_string($txtApellidoEsposo);

    if ($error === '') {
        $resActual = mysql_query("SELECT Id, DOC_IDENTIDAD FROM contribuyentes WHERE CODIGO_CONTRIBUYENTE='$codigoSeguro' AND ESTADO='ACTIVO'");
        if (!$resActual) {
            $error = 'No se pudo consultar el contribuyente.';
        } elseif (mysql_num_rows($resActual) != 1) {
            $error = 'No existe exactamente un registro activo para este contribuyente.';
        } else {
            $actual = mysql_fetch_assoc($resActual);
            $carnetAnterior = $actual['DOC_IDENTIDAD'];
            $idAnterior = (int)$actual['Id'];
        }
    }

    if ($error === '') {
        $resDuplicado = mysql_query("SELECT CODIGO_CONTRIBUYENTE FROM contribuyentes WHERE DOC_IDENTIDAD='$ciSeguro' AND ESTADO='ACTIVO' AND CODIGO_CONTRIBUYENTE<>'$codigoSeguro' LIMIT 1");
        if (!$resDuplicado) {
            $error = 'No se pudo comprobar si el carnet ya esta registrado.';
        } elseif (mysql_num_rows($resDuplicado) > 0) {
            $error = 'El numero de carnet ya pertenece a otro contribuyente activo.';
        }
    }

    if ($error === '') {
        $observacionCompleta = 'CEDULA DE IDENTIDAD MODIFICADA DE '.$carnetAnterior.' A '.$txtCi.'. EXPEDIDO, NOMBRE(S) Y APELLIDO(S) MODIFICADOS. '.$txtObservaciones;
        $observacionSegura = mysql_real_escape_string($observacionCompleta);
        $sql = "INSERT INTO contribuyentes (CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,DOC_IDENTIDAD,DOC_IDENTIDAD_ALFA,EXPEDIDO,TIPO_DOCUMENTO,NOMBRE_RSOCIAL,PRIMER_APELLIDO,SEGUNDO_APELLIDO,APELLIDO_ESPOSO,OBSERVACIONES) VALUES ('$registroSeguro','$codigoSeguro','$ciSeguro','$ci2Seguro','$expedidoSeguro','CEDULA DE IDENTIDAD','$nombresSeguro','$primerSeguro','$segundoSeguro','$esposoSeguro','$observacionSegura')";
        // Primero se inserta la nueva version; si falla, la anterior permanece activa.
        if (!mysql_query($sql)) {
            $numeroErrorMysql = mysql_errno();
            $detalleErrorMysql = mysql_error();
            error_log('MODIFICACION CONTRIBUYENTE - INSERT fallido. Codigo MySQL: '.$numeroErrorMysql.' - '.$detalleErrorMysql.' - Codigo contribuyente: '.$txtCodigoContribuyente);
            $error = 'No se pudo registrar la correccion del contribuyente. Codigo MySQL: '.$numeroErrorMysql.'. No vuelva a enviar; revise el log de errores del servidor.';
        } else {
            $estadoAnterior = 'NO ACTIVO, MODIFICADO POR EL USUARIO: '.$US_SIOI.' - '.$SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO.' EN FECHA '.$FECHA.' HORA '.$HORA;
            $estadoSeguro = mysql_real_escape_string($estadoAnterior);
            // Solo desactivar el registro anterior que se consulto antes de insertar.
            $nuevoId = mysql_insert_id();
            $sqlUpdate = "UPDATE contribuyentes SET ESTADO='$estadoSeguro' WHERE Id=".$idAnterior." AND CODIGO_CONTRIBUYENTE='$codigoSeguro' AND ESTADO='ACTIVO'";
            if (!mysql_query($sqlUpdate)) {
                error_log('Error al desactivar version anterior: '.mysql_errno().' - '.mysql_error());
                $error = 'Se inserto la nueva version, pero no se pudo desactivar la anterior. Solicite revision antes de repetir.';
            } else {
                $carnetCompleto = $txtCi.($txtCi2 !== '' ? '-'.$txtCi2 : '').' '.$sltExpedido;
                $nombreCompleto = $txtNombres.' '.$txtPrimerApellido.' '.$txtSegundoApellido.($txtApellidoEsposo !== '' ? ' de '.$txtApellidoEsposo : '');
                $detalle = 'CAMBIO DE C.I. DE '.$carnetAnterior.' A '.$carnetCompleto.' - '.$nombreCompleto.'.';
                $detalleSeguro = mysql_real_escape_string($detalle);
                $hostSeguro = mysql_real_escape_string($hostname);
                $ipSeguro = mysql_real_escape_string($hostlocal);
                $usuarioSeguro = mysql_real_escape_string($US_SIOI);
                $nombreUsuarioSeguro = mysql_real_escape_string($SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO);
                $fechaSegura = mysql_real_escape_string($FECHA);
                $horaSegura = mysql_real_escape_string($HORA);
                $sqlTransaccion = "INSERT INTO reg_contribuyente_transacciones (PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE) VALUES ('$hostSeguro','$ipSeguro','$usuarioSeguro','$nombreUsuarioSeguro','$fechaSegura','$horaSegura','$registroSeguro','$codigoSeguro','------','CONTRIBUYENTE','MODIFICACION DE DATOS CONTRIBUYENTE BASICO','$detalleSeguro','$detalleSeguro','0')";
                if (!mysql_query($sqlTransaccion)) {
                    error_log('Error al registrar transaccion de correccion: '.mysql_errno().' - '.mysql_error());
                    $error = 'Datos corregidos, pero fallo el registro de transaccion. Solicite revision; no repita el envio.';
                }
            }
        }
    }
    if ($error !== '') {
        echo '<script>alert('.json_encode($error).');</script>';
    } else {
        echo '<script>alert("Se modificaron los datos del contribuyente correctamente."); location.href="frmModificacionContribuyente.php";</script>';
    }
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- VERSION 3: CI, ACENTOS, EXPEDIDO Y DIAGNOSTICO DE GUARDADO -->
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script type="text/javascript">
function comprobar(obj) {
    var ids = ['txtCi','txtCi2','txtNombres','txtPrimerApellido',
               'txtSegundoApellido','txtApellidoEsposo','txtObservaciones'];
    for (var i = 0; i < ids.length; i++) {
        var campo = document.getElementById(ids[i]);
        if (campo) {
            campo.readOnly = !obj.checked;
            campo.disabled = false;
        }
    }
}
function mayusculasConAcentos(campo) {
    campo.value = campo.value.toUpperCase();
}
function iniciarFormulario() {
    var casilla = document.getElementById('chec');
    if (casilla) comprobar(casilla);
}
if (window.addEventListener) {
    window.addEventListener('load', iniciarFormulario, false);
} else {
    window.attachEvent('onload', iniciarFormulario);
}
</script>
<!-- Se omite frmValida.js en este formulario: sus filtros pueden bloquear Ñ y tildes. -->
</head>
<form  method="post" action='frmModificacionContribuyente1.php'>
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR DATOS CONTRIBUYENTE BASICO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Modificar Datos Contribuyente</td>
  </tr>
  <tr>
    <td style="font-weight: bold">DOCUMENTOS REQUERIDOS.</td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><table width="100%" border="0">
      <tr>
        <td width="25%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> DOCUMENTO DE CEDULA DE IDENTIDAD :</td>
        <td width="1%">&nbsp;</td>
        <td width="74%"><input type="checkbox" name="checkbox" id="chec" onChange="comprobar(this);" required/>
        Haga clic para habilitar para modificar Datos del Contribuyente.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="font-style: italic; font-weight: normal;">Documento Indispensable para realizar modificaciones.</td>
      </tr>
      <tr>
        <td><img src="../Img/Blanco.png" width="300" height="8" /></td>
        <td>&nbsp;</td>
        <td style="font-style: italic; font-weight: normal;">Al habilitar la <span style="font-weight: bold">CASILLA</span> se modificar&aacute;n tambi&eacute;n los datos del contribuyente en los <span style="font-weight: bold">COMPROBANTES DE PAGO EMITIDOS.</span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Contribuyente (<span class="ASTERISCO">ES RESPONSABILIDAD DEL OPERADOR EL LLENADO DE DATOS</span>).</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></span></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" bordercolor="#FFFFFF">
      <?php 
	$res=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='".mysql_real_escape_string($txtCodigoContribuyente)."' and ESTADO='ACTIVO' LIMIT 1");  
	  while($row=mysql_fetch_array($res)){ 
	  $CODIGO_CONTRIBUYENTE=$row['CODIGO_CONTRIBUYENTE'];?> <tr>
        <td width="24%" height="32" align="right" bgcolor="#CCCCCC">Nro. de C&eacute;dula de Identidad :</td>
        <td width="76%" style="font-weight: bold"> <input name="txtCi" type="text" id="txtCi" value="<?php echo htmlspecialchars($row['DOC_IDENTIDAD'], ENT_QUOTES, 'UTF-8'); ?>" style="width:120px; height:20px" maxlength="20" required /> 
          - 
          <input name="txtCi2" type="text" id="txtCi2" style="width:75px; height:20px" onchange="mayusculasConAcentos(this);"  value="<?php echo htmlspecialchars($row['DOC_IDENTIDAD_ALFA'], ENT_QUOTES, 'UTF-8');?>" maxlength="5" />
          <input name="txtCodigoContribuyente" type="hidden" id="txtCodigoContribuyente" value="<?php echo $txtCodigoContribuyente;?>" />
          <input name="txtCodigoRegistro" type="hidden" id="txtCodigoRegistro" value="<?php echo $CodigoRegistro;?>" /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><select name="sltExpedido" id="sltExpedido">
          <?php
          $expedidoActual = trim($row['EXPEDIDO']);
          $expedidosMostrados = array();
          $rest = mysql_query("select * from parametros_sistema where UBICACION='EXPEDIDO' and ESTADO='ACTIVO'");
          if ($rest) {
              while ($rowt = mysql_fetch_array($rest)) {
                  $expedido = trim($rowt['DESCRIPCION']);
                  $clave = strtoupper($expedido);
                  if ($expedido === '' || isset($expedidosMostrados[$clave])) continue;
                  $expedidosMostrados[$clave] = true;
                  echo '<option value="'.htmlspecialchars($expedido, ENT_QUOTES, 'UTF-8').'"';
                  if (strcasecmp($expedido, $expedidoActual) === 0) echo ' selected="selected"';
                  echo '>'.htmlspecialchars($expedido, ENT_QUOTES, 'UTF-8').'</option>';
              }
          }
          if ($expedidoActual !== '' && !isset($expedidosMostrados[strtoupper($expedidoActual)])) {
              echo '<option selected="selected" value="'.htmlspecialchars($expedidoActual, ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($expedidoActual, ENT_QUOTES, 'UTF-8').'</option>';
          }
          ?>
          </select>          </td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Tipo de Documento :</td>
        <td style="font-weight: bold"><?php echo $row['TIPO_DOCUMENTO'];?>
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre(s) :</td>
        <td style="font-weight: bold"><input name="txtNombres" type="text" id="txtNombres" onchange="mayusculasConAcentos(this);" value="<?php echo $row['NOMBRE_RSOCIAL'];?>"   size="50"  required/> </td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Primer Apellido :</td>
        <td style="font-weight: bold"><input name="txtPrimerApellido" type="text" id="txtPrimerApellido" value="<?php echo $row['PRIMER_APELLIDO'];?>" size="50" onchange="mayusculasConAcentos(this);"   required/></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Segundo Apellido :</td>
        <td style="font-weight: bold"><input name="txtSegundoApellido" type="text" id="txtSegundoApellido" value="<?php echo $row['SEGUNDO_APELLIDO'];?>"   onchange="mayusculasConAcentos(this);" size="50" /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Apellido Esposo :</td>
        <td style="font-weight: bold"><input name="txtApellidoEsposo" type="text" id="txtApellidoEsposo" value="<?php echo $row['APELLIDO_ESPOSO'];?>"   onchange="mayusculasConAcentos(this);" size="50" /> 
          NO AGREGUE &quot;de&quot;</td>
      </tr>
      <tr>
        <td height="32" align="right" valign="top" bgcolor="#CCCCCC"><table width="100%" border="0">
          <tr>
            <td align="right"><span class="ASTERISCO">*</span> Observaciones :</td>
          </tr>
          <tr>
            <td align="right">(Autorizaci&oacute;n, Hoja de Ruta, Solicitud, etc.)</td>
          </tr>
        </table></td>
        <td valign="top" style="font-weight: bold"><textarea name="txtObservaciones" id="txtObservaciones" onchange="mayusculasConAcentos(this);"  maxlength="1000" cols="45" rows="4" readonly="readonly" required></textarea> </td>
      </tr>
      <tr>
        <td height="32" align="right"><img src="../Img/Blanco.png" width="400" height="8" /></td>
        <td style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px"/></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="left" class="ASTERISCO" style="font-style: italic; font-weight: bold;"><hr /></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">Historial de Modificaciones Datos Contribuyente.</td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr style="font-weight: bold">
        <td height="41" align="center" bgcolor="#CCCCCC">No.</td>
        <td align="center" bgcolor="#CCCCCC">No. DE CEDULA DE IDENTIDAD</td>
        <td align="center" bgcolor="#CCCCCC">No. C.I. ALFABETICO</td>
        <td align="center" bgcolor="#CCCCCC">EXPEDIDO</td>
        <td align="center" bgcolor="#CCCCCC">NOMBRE(S)</td>
        <td align="center" bgcolor="#CCCCCC">PRIMER APELLIDO</td>
        <td align="center" bgcolor="#CCCCCC">SEGUNDO APELLIDO</td>
        <td align="center" bgcolor="#CCCCCC">APELLIDO CASADO</td>
        <td align="center" bgcolor="#CCCCCC">ESTADO</td>
        <td align="center" bgcolor="#CCCCCC">OBSERVACIONES</td>
        </tr><?php
      $codigoHistorial = mysql_real_escape_string($txtCodigoContribuyente);
      $resf = mysql_query("SELECT * FROM contribuyentes WHERE CODIGO_CONTRIBUYENTE='$codigoHistorial' ORDER BY Id DESC");
      if ($resf === false) {
          error_log('Error al consultar historial de contribuyente: ' . mysql_error());
          echo '<tr><td colspan="10">No se pudo cargar el historial. Solicite una revisión al administrador.</td></tr>';
      } else {
          while ($row = mysql_fetch_array($resf)) {
      ?>
      <tr>
        <td height="29" bgcolor="#E3EEEE"><?php $cont ++; echo $cont; ?></td>
          <td bgcolor="#E3EEEE"><?php echo $row['DOC_IDENTIDAD']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['DOC_IDENTIDAD_ALFA']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['EXPEDIDO']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['NOMBRE_RSOCIAL']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['PRIMER_APELLIDO']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['SEGUNDO_APELLIDO']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['APELLIDO_ESPOSO']; ?></td>
        <td bgcolor="#E3EEEE"><?php echo $row['ESTADO']; ?></td>
         <td bgcolor="#E3EEEE"><?php echo $row['OBSERVACIONES']; ?></td>
        </tr><?php
          }
      }
      ?>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmModificacionContribuyente.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 3 - DIAGNOSTICO DE GUARDADO 2026-11-03</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php'; 
function normaliza($cadena){
    $cadena = trim($cadena);
    $minusculas = array('á','é','í','ó','ú','ü','ñ');
    $mayusculas = array('Á','É','Í','Ó','Ú','Ü','Ñ');
    $cadena = str_replace($minusculas, $mayusculas, $cadena);
    return strtoupper($cadena);
}

function limpia_espacios($cadena){
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}
function limpia_puntos($cadena){
	$cadena = str_replace('.', '', $cadena);
	return $cadena;
}
?>