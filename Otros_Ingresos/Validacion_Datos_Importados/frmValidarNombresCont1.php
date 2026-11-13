<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
function validacionSeleccionValue($name)
{
	foreach (array($_POST, $_GET) as $source) {
		if (isset($source[$name]) && is_scalar($source[$name])) {
			return (string) $source[$name];
		}
	}
	return '';
}
$COD_ASOCIACION = validacionSeleccionValue('COD_ASOCIACION');
$ASOCIACION = validacionSeleccionValue('ASOCIACION');
if ($COD_ASOCIACION === '') {
	echo "<script>alert('No se recibió la asociación seleccionada.'); location.href='frmValidarNombresCont.php';</script>";
	exit;
}
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
 $SWSEC = 0;
 unset($_SESSION['CODIGO_REGISTRO']);
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$COD_REGISTRO=date('Ymd His');
// VERIFICA DATOS DEL SECRETARIO GENERAL
$GESTION_SEC=(int)date('Y')-1;
$resultY=mysql_query("select RSG.id from reg_secretario_general_asociacion RSG inner join secretario_general SG on SG.CODIGO_SECRETARIO_GENERAL=RSG.CODIGO_SECRETARIO_GENERAL and SG.ESTADO='ACTIVO' where RSG.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RSG.GESTION='$GESTION_SEC' and RSG.ESTADO='ACTIVO' limit 1") or die("NO SE PUDO VERIFICAR EL SECRETARIO GENERAL.");
$SWSEC = mysql_num_rows($resultY) > 0 ? 1 : 0;

if($SWSEC==0){echo "<script>alert('LA ASOCIACION SELECCIONADA NO TIENE DATOS ACTUALIZADOS DEL \\n SECRETARIO GENERAL PARA LA GESTION $GESTION_SEC.')</script>";
echo"<script> location.href='frmValidarNombresCont.php';</script>";
exit;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<body>
<form method="post" action="frmValidarNombreContOPciones.php">
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="100%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO"> <?php $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Validacion de Nombre(s) de Contribuyente(s) y Datos(s) Puesto(s) y Fila(s)</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Asociacion Seleccionado.</td>
      </tr>
      <tr>
        <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
      </tr>
      <tr>
        <td valign="bottom" style="font-weight: bold"><table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
        <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?>
              <input name="ORDENANZA_MUNICIPAL" type="hidden" id="ORDENANZA_MUNICIPAL" value="<?php echo htmlspecialchars($row['ORDENANZA_MUNICIPAL'], ENT_QUOTES, 'UTF-8'); ?>" />
              <input name="COD_ASOCIACION" type="hidden" value="<?php echo htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8'); ?>" />
              <input name="ASOCIACION" type="hidden" value="<?php echo htmlspecialchars($row['DESCRIPCION'], ENT_QUOTES, 'UTF-8'); ?>" /></td>
          </tr>
          <tr>
            <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="68%" style="font-weight: bold"><?php echo htmlspecialchars($row['DESCRIPCION'], ENT_QUOTES, 'UTF-8');?></td>
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?></td>          
          </tr>  <?php }?>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión pendiente :</td>
            <td style="font-weight: bold"><select name="sltGestion" id="sltGestion" required="required">
              <option value="">Seleccionar...</option>
                <?php
                $SW2 = 0;
                $liq=mysql_query("select GESTION,COUNT(*) AS PENDIENTES from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO' group by GESTION order by GESTION") or die("NO SE PUDIERON CONSULTAR LAS GESTIONES PENDIENTES.");
                while($row=mysql_fetch_array($liq)){ $SW2=1;?>
                <option value="<?php echo htmlspecialchars($row['GESTION'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($row['GESTION'], ENT_QUOTES, 'UTF-8').' ('.(int)$row['PENDIENTES'].' pendiente(s)'; ?></option>
                <?PHP } ?>
            </select>
              <input name="BUSCAR" type="hidden" id="BUSCAR" value="1" />
              <?php if ($SW2 == 0) { ?><div class="ASTERISCO">No existen contribuyentes activos con estado de pago "NO PAGO" para esta asociación. Las gestiones pagadas no se muestran como pendientes.</div><?php } ?>
            </td>
          </tr>
          <tr>
            <td height="32" align="right"><img src="../Img/Blanco.png" width="370" height="6" /></td>
            <td align="left" style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="height:49px; width:200px" <?php if ($SW2 == 0) { echo 'disabled="disabled"'; } ?> /></td>
          </tr>
        
        </table></td>
      </tr>
      <tr>
        <td align="center"><a href="frmValidarNombresCont.php">Volver</a></td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 1</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>