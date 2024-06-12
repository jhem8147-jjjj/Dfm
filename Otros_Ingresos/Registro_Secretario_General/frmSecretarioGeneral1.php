<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php'); 
 require_once('../Control_Sesiones_Forms/Loading.php'); 
 require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
//REGISTRA AL SECRETARIO GENERAL
if($REG==1){
$query = mysql_query("UPDATE reg_secretario_general_asociacion  SET ESTADO='NO ACTIVO',OBSERVACIONES='SECRETARIO GENERAL MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA; $FECHA HORA: $HORA.' where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_secretario_general_asociacion.");	
$CODIGO_REGISTRO=date('Ymd His').rand(1,1000);
$txtNombres=normaliza($txtNombres);
$txtNombres=trim($txtNombres);
$txtPapellido=normaliza($txtPapellido);
$txtPapellido=trim($txtPapellido);
$txtSapellido=normaliza($txtSapellido);
$txtSapellido=trim($txtSapellido);
$CODIGO_SECRETARIO=$txtNroCi.rand(1,99);
$re=mysql_query("select * from secretario_general where CODIGO_SECRETARIO_GENERAL='$CODIGO_SECRETARIO' and ESTADO='ACTIVO'"); while($rowc=mysql_fetch_array($re)){$SWC=1;}
if($SWC==0){
	//REVISA TEXTOS
if(strlen($txtTelefono)==0){ $txtTelefono='---';}
if(strlen($txtCelular)==0){ $txtCelular='---';}
if(strlen($txtEmail)==0){ $txtEmail='---';}
$sql1="insert into secretario_general(CODIGO_REGISTRO,CODIGO_SECRETARIO_GENERAL,DOC_IDENTIDAD,DOC_IDENTIDAD_ALFA,EXPEDIDO,TIPO_DOCUMENTO,NOMBRE_RSOCIAL,PRIMER_APELLIDO,SEGUNDO_APELLIDO,TELEFONO,CELULAR,EMAIL)values('$CODIGO_REGISTRO','$CODIGO_SECRETARIO','$txtNroCi','$txtNroCiAl','$sltExpedido','$sltDocumento','$txtNombres','$txtPapellido','$txtSapellido','$txtTelefono','$txtCelular','$txtEmail')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD secretario_general.");
}
$sql1="insert into reg_secretario_general_asociacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_SECRETARIO_GENERAL,CODIGO_ASOCIACION,GESTION)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$CODIGO_SECRETARIO','$COD_ASOCIACION','$sltGestionSeleccionado')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_secretario_general_asociacion.");

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$COD_ASOCIACION','$ASOCIACION','REGISTRO DE SECRETARIO GENERAL','REGISTRO DE SECRETARIO GENERAL NUEVO - $ASOCIACION.','REGISTRO DE SECRETARIO GENERAL NUEVO - $ASOCIACION - $txtNroCi $txtNroCiAl $sltExpedido $txtNombres $txtPapellido $txtSapellido, PARA LA GESTION $sltGestionSeleccionado.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 


echo"<script> alert('Se Registró los datos del Secretario General.');</script>";	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO"><?php $result=mysql_query("select * from nombre_formularios where UBICACION='REGISTRO SECRETARIO GENERAL' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">REGISTRAR NUEVO SECRETARIO GENERAL</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" style="font-weight: bold"><table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
      <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
      </tr>
      <tr>
        <td width="27%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="73%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?></td>
      </tr>
      <?php }?>
      <tr>
        <td height="32" align="right"><img src="../Img/Linea.png" width="250" height="4" /></td>
        <td style="font-weight: bold"><hr /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" style="font-weight: bold"><table width="100%" border="0">
      <tr>
        <td colspan="2" align="right"><table width="30%" border="0">
          <tr>
            <td width="9%"><a href="frmValidarNombresCont1.php?sltGestion=<?php echo $row[13]; ?>&amp;NUMERO_GREMIAL=<?php echo $row[12];?>&amp;BUSCAR=1&amp;CODIGO_CONTRIBUYENTE=<? echo $row[7];?>&amp;VALIDADO=1" title="DATOS CORRECTOS"><img src="../Img/512x512.png" width="40" height="40" /></a><a href="frmValidarNombresCont1.php?sltGestion=<?php echo $row[13]; ?>&amp;NUMERO_GREMIAL=<?php echo $row[12];?>&amp;BUSCAR=1&amp;CODIGO_CONTRIBUYENTE=<? echo $row[7];?>&amp;VALIDADO=1" title="DATOS CORRECTOS"></a></td>
            <td width="91%"><a href="frmSecretarioGeneral2.php">Registrar Nuevo Secretario General</a></td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td style="font-size: 12px">Historial de Secretarios(as) Generales registrado.</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><hr /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
      <thead>
        <tr style="font-weight: bold">
          <td height="70" align="center">No.</td>
          <td align="center">FECHA Y HORA </td>
          <td align="center">USUARIO</td>
          <td align="center">GESTION</td>
          <td align="center">No. DE DOCUMENTO</td>
          <td align="center">NOMBRE(S) Y APELLIDO(S)</td>
          <td align="center">TELEFONO</td>
          <td align="center">CELULAR</td>
          <td align="center">CORREO ELECTRONICO</td>
          <td align="center">ESTADO</td>
          </tr>
      </thead>
      <tbody>
        <?php 
	 
	  $res=mysql_query("select SG.DOC_IDENTIDAD,SG.DOC_IDENTIDAD_ALFA,SG.EXPEDIDO,SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,RSGA.GESTION,RSGA.ESTADO,SG.TELEFONO,SG.CELULAR,SG.EMAIL,RSGA.FECHA,RSGA.HORA,RSGA.USUARIO,RSGA.NOMBRE_USUARIO  from reg_secretario_general_asociacion RSGA, secretario_general SG where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL  order by RSGA.Id DESC");
		  	  while($row=mysql_fetch_array($res)){ 
	 	  $SW2=1;?>
        <tr>
          <td><?php $cont++; echo $cont; ?></td>
          <td><?php echo $row[11].' Hrs.: '.$row[12]; ?></td>
          <td><?php echo $row[13].' - '.$row[14]; ?></td>
          <td><?php echo $row[6]; ?></td>
          <td><?php if($row[1]== null){ echo  $row[0].' '.$row[2];}else{echo $row[0].' - '.$row[1].' '.$row[2];} ?></td>
          <td><?php echo $row[3].' '.$row[4].' '.$row[5]; ?></td>
          <td align="center"><table width="100%" border="0">
            <tr>
              <td width="36%"><img src="../Img/TELEFONO.png" width="23" height="23" /></td>
              <td valign="middle" ><?php echo $row[8]; ?></td>
            </tr>
          </table></td>
          <td align="center"><table width="100%" border="0">
            <tr>
              <td width="60%"><img src="../Img/celular.png" width="28" height="25" /></td>
              <td valign="middle"><?php echo $row[9]; ?></td>
            </tr>
          </table></td>
          <td align="center"><table width="100%" border="0">
            <tr>
              <td width="24%"><img src="../Img/CORREO.png" width="25" height="20" /></td>
              <td valign="middle"><?php echo $row[10]; ?></td>
            </tr>
          </table></td>
          <td align="center"><table width="100%" border="0">
            <tr>
              <?php if($row[7]=='ACTIVO'){?>
              <td width="12%"><img src="../Img/512x512.png" width="20" height="20" /></td>
              <?php } else{ ?>
              <td width="12%"><img src="../Img/excluir.png" width="20" height="20" /></td>
              <?php } ?>
              <td width="76%"><?php echo $row[7]; ?></td>
              </tr>
          </table></td>
          </tr>
        <?php } ?>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><div id="mostrar"><a href="frmSecretarioGeneral.php">Volver</a></div></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table><?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html>
<?php function normaliza ($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtoupper($cadena);
    return utf8_encode($cadena);
}
require '../Control_Sesiones_Forms/Key.php'; require '../Conexion_BD/Cerrar_Dbms.php';?>