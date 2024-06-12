<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['OMS']=$OMS;
$COD_REGISTRO=date('Ymd His');
// $_SESSION['COD_REGISTRO']=$COD_REGISTRO;
$SWSEC=0;
// VERIFICA DATOS DEL SECRETARIO GENERAL
$GESTION_SEC=date('Y')-1;
$resultY=mysql_query("select * from reg_secretario_general_asociacion RSG where RSG.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSG.GESTION='$GESTION_SEC' and RSG.ESTADO='ACTIVO'"); while($rowY=mysql_fetch_array($resultY)){ $SWSEC=1; }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
<table width="100%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">CAMBIO DE NOMBRE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">DEUDAS ASOCIACION</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><hr /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
          </tr>
          <tr>
            <td width="29%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="71%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>          
            </tr>
          <?php }?>
          <tr>
        <td  align="left" style="font-weight: bold"><img src="../Img/Blanco.png" width="280" height="1" /></td>
        <td  align="left" style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DEUDAS PENDIENTES - IMPUESTO ANUAL.</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><hr /></td>
        </tr>
      <tr>
        <td colspan="2" align="right"><table width="100%" border="0">
          <tr>
            <td height="33" align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">No.</td>
            <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Fecha de Cargado</td>
            <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Gestión</td>
            <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Estado</td>
            <td align="center" style="font-weight: bold; font-size: 12px;">&nbsp;</td>
          </tr>
          <?php $res=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,HORA,GESTION,ESTADO_PAGO from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){ ?>
          <tr>
            <td height="23" bgcolor="#EBDBD6"><?php $CONT++; echo $CONT; ?></td>
            <td bgcolor="#EBDBD6"><?php echo $row[1].' Hrs.: '.$row[2]; ?></td>
            <td bgcolor="#EBDBD6"><?php echo $row[3]; ?></td>
            <td bgcolor="#EBDBD6"><?php echo $row[4].' - IMPUESTO ANUAL CON DEUDA.'; ?></td>
            <td>&nbsp;</td>
          </tr><?php } if($CONT==0){ ?>
          <tr>
            <td colspan="5" bgcolor="#EBDBD6" style="font-weight: bold">SIN REGISTRO</td>
            </tr>
          <?php } ?>
        </table></td>
        </tr>
    </table>
   </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><span style="font-weight: bold">DEUDAS PENDIENTES - COMPLEMENTOS.</span></td>
  </tr>
  <tr>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td height="33" align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">No.</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Fecha de Cargado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Usuario</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Gestión</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Estado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Comunicación Interna</td>
        <td align="center" style="font-weight: bold; font-size: 12px;">&nbsp;</td>
      </tr>
      <?php $res=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,GESTION,ESTADO_PAGO,USUARIO,NOMBRE_USUARIO,COMUNICACION_INTERNA,ENLACE from reg_contribuyente_habilitado_pago_complementacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){ ?>
      <tr>
        <td height="23" bgcolor="#EBDBD6"><?php $CONTS++; echo $CONTS; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[1]; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[4].' - '.$row[5]; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[2]; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[3].' - POR COMPLEMENTO DE CONTRIBUYENTES'; ?></td>
        <td bgcolor="#EBDBD6"><a href="../Complemento_Contribuyentes/Pdf_Complementos/<?php echo $row[7]; ?>.pdf" target="_new"><?php echo $row[6]; ?></a></td>
        <td><a href="../Complemento_Contribuyentes/Pdf_Complementos/frmGenerarNominaSinComInt.php?CODIGO_REGISTRO=<?php echo $row[0];?>" target="_new">Ver Nómina</a></td>
      </tr><?php } if($CONTS==0){ ?>
      <tr>
        <td height="23" colspan="7" bgcolor="#EBDBD6" style="font-weight: bold; font-size: 12px;">SIN REGISTRO</td>
        </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><span style="font-weight: bold">DEUDAS PENDIENTES - CAMBIO DE NOMBRE.</span></td>
  </tr>
  <tr>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td height="33" align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">No.</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Fecha de Cargado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Usuario</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Gestión</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Estado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Comunicación Interna</td>
        <td align="center" style="font-weight: bold; font-size: 12px;">&nbsp;</td>
        </tr>
      <?php $res=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,GESTION,ESTADO_PAGO,USUARIO,NOMBRE_USUARIO,COMUNICACION_INTERNA,ENLACE from reg_contribuyente_habilitado_pago_cambio_nombre where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){ ?>
      <tr>
        <td height="23" bgcolor="#EBDBD6"><?php $CONTTS++; echo $CONTTS; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[1]; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[4].' - '.$row[5]; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[2]; ?></td>
        <td bgcolor="#EBDBD6"><?php echo $row[3].' - POR CAMBIO DE NOMBRE DE CONTRIBUYENTES'; ?></td>
        <td bgcolor="#EBDBD6"><a href="Pdf_Cambio_Nombre/<?php echo $row[7]; ?>.pdf" target="_new"><?php echo $row[6]; ?></a></td>
        <td><a href="Pdf_Cambio_Nombre/frmGenerarNominaSinComInt.php?CODIGO_REGISTRO=<?php echo $row[0];?>" target="_new">Ver Nómina</a></td>
        </tr><?php }  if($CONTTS==0){ ?>
      <tr>
        <td height="23" colspan="7" bgcolor="#EBDBD6"><span style="font-weight: bold; font-size: 12px;">SIN REGISTRO</span></td>
        </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="frmCambioNombre.php">Volver</a><?php if($CONT==0){?> | <a href="frmCambioNombreDocumento.php">Continuar</a><?php } ?></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';
if($SWSEC==0){echo "<script>alert('LA ASOCIACION SELECCIONADA NO TIENE DATOS ACTUALIZADOS DEL \\n SECRETARIO GENERAL PARA LA GESTION: $GESTION_SEC.')</script>";
echo"<script> location.href='frmCambioNombre.php';</script>";
}
if($CONT>0){echo "<script>alert('La ASOCIACION seleccionada tiene deudas pendientes.')</script>";}
 if($CONT==0 and $CONTS==0 and $CONTTS==0){echo"<script> location.href='frmCambioNombreDocumento.php';</script>";}

?>