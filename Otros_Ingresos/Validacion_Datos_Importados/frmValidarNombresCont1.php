<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
 unset($_SESSION['CODIGO_REGISTRO']);
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$COD_REGISTRO=date('Ymd His');
// VERIFICA DATOS DEL SECRETARIO GENERAL
$GESTION_SEC=date('Y')-1;
$resultY=mysql_query("select * from reg_secretario_general_asociacion RSG where RSG.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSG.GESTION='$GESTION_SEC' and RSG.ESTADO='ACTIVO'"); while($rowY=mysql_fetch_array($resultY)){ $SWSEC=1; }

if($SWSEC==0){echo "<script>alert('LA ASOCIACION SELECCIONADA NO TIENE DATOS ACTUALIZADOS DEL \\n SECRETARIO GENERAL PARA LA GESTION $GESTION_SEC.')</script>";
echo"<script> location.href='frmValidarNombresCont.php';</script>";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<form method="post" action="frmValidarNombreContOPciones.php">
<body>
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
        <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?>
              <input name="ORDENANZA_MUNICIPAL" type="hidden" id="ORDENANZA_MUNICIPAL" value="<?php echo $row['ORDENANZA_MUNICIPAL'];?>" /></td>
          </tr>
          <tr>
            <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="68%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?></td>          
          </tr>  <?php }?>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión :</td>
            <td style="font-weight: bold"><select name="sltGestion" id="sltGestion">
              <?php if($sltGestion==null){ echo 'Seleccionar...';}else{echo $sltGestion;}?></option>
                <?php $liq=mysql_query("select DISTINCT GESTION from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO_PAGO='NO PAGO' order by GESTION");while($row=mysql_fetch_array($liq)){ $SW2=1; if($sltGestion==$row['0']){}else{?>
                <option><?php echo $row['0'];?></option>
                <?PHP }} ?>
            </select>
              <input name="BUSCAR" type="hidden" id="BUSCAR" value="1" />
            </tr>
          <tr>
            <td height="32" align="right"><img src="../Img/Blanco.png" width="370" height="6" /></td>
            <td align="left" style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="height:49px; width:200px"   />            </tr>
        
        </table></td>
      </tr><?php if($BUSCAR==1){?>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr><?php } ?>
      <tr>
        <td align="center"><a href="frmValidarNombresCont.php">Volver</a></td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 1</td>
      </tr>
    </table></td>
  </tr>
</table>
</body></form>
</html><?php 
if($SW2==0){
	echo"<script> alert('No Existe Contribuyentes Habilitados para la gestion seleccionada.');</script>";
	echo"<script> location.href='frmValidarNombresCont.php';</script>";
	} require '../Conexion_BD/Cerrar_Dbms.php';?>