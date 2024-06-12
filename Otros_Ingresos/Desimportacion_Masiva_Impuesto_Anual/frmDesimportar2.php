<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$_SESSION['CODIGOREGISTRO']=$CODIGOREGISTRO;

$cont=0;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>

<body onpaste="return false">
<table width="99%" border="0" align="center">
  <tr>
    <td align="center" class="TITULO">DESHABILITAR MASIVAMENTE REGISTROS CARGADOS</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">DESHABILITAR REGISTROS CARGADOS </td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td width="47%" height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td width="53%" style="font-weight: bold"><?php echo utf8_decode($OMS);?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><?php echo $ZONA_TRIB;?></td>
      </tr>
      <tr>
        <td height="27" align="right" bgcolor="#CCCCCC">Gestión de Liquidación :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold"><?php echo $sltGestion;?></span></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="2" /></td>
        <td >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" style="font-weight: bold">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold; font-size: 13px;"><u>RESULTADO DE CONTRIBUYENTES HABILITADOS PARA EL PAGO <?php echo $sltGestion;?></u></td>
  </tr>
  <tr>
    <td><img src="../Img/Blanco.png" width="400" height="2" /></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
      <tr style="font-weight: bold">
        <td height="70" align="center" bgcolor="#CCCCCC">No.</td>
        <td align="center" bgcolor="#CCCCCC">COMUNICACION INTERNA</td>
        <td align="center" bgcolor="#CCCCCC">No. DE DOCUMENTO</td>
        <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
        <td align="center" bgcolor="#CCCCCC">GESTION</td>
        <td align="center" bgcolor="#CCCCCC">DESCRIPCION</td>
        <td align="center" bgcolor="#CCCCCC">FILA</td>
        <td align="center" bgcolor="#CCCCCC">PUESTO</td>
        <td align="center" bgcolor="#CCCCCC">ESTADO ORDEN DE PAGO</td>
        <td align="center" bgcolor="#CCCCCC">ESTADO PAGO</td>
        </tr>
      </thead>
        <tbody>
      <?php 
	  
		   //liquida la gestion seleccionada
	  $res=mysql_query("select CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCHP.PUESTO,RCHP.FILA,RCHP.COMUNICACION_INTERNA,RCHP.GESTION,RCHP.TIPO_VENTA,RCHP.ESTADO_ORDEN_PAGO,RCHP.ESTADO_PAGO from reg_contribuyente_habilitado_pago RCHP, contribuyentes CONTRI where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCHP.GESTION='$sltGestion' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO' and RCHP.ESTADO_ORDEN_PAGO='NO VALIDADO' and CONTRI.ESTADO='ACTIVO' ");
	  while($row=mysql_fetch_array($res)){ 			  
			  
	  $SW2=1;?>
      <tr>
        <td><?php $cont++; echo $cont; ?></td>
        <td><?php echo $row[9]; ?></td>
        <td><?php if($row[1]== null){echo $row[0].' '.$row[1].' '.$row[2];}else{echo $row[0].' - '.$row[1].' '.$row[2];}  ?></td>
        <td><?php if($row['6'] == null){ echo $row['3'].' '.$row['4'].' '.$row['5'];}else{echo $row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'];} ?> </td>
        <td><?php echo $row[10]; ?></td>
        <td><?php echo $row[11]; ?></td>
        <td><?php echo $row[8]; ?></td>
        <td><?php echo $row[7]; ?></td>
        <td><?php echo $row[12]; ?></td>
        <td><?php echo $row[13]; ?></td>
        </tr>
      <?php } ?>
      
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr><form  method="post" action='frmDesimportar3.php'>
  <tr>
    <td align="left"><table width="100%" border="2" bordercolor="#FFFFFF">
      <tr>
        <td width="38%" align="right"><img src="../Img/Blanco.png" width="400" height="2" /></td>
        <td width="62%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO" style="font-weight: bold">*</span><span style="font-weight: bold"> Mótivo / Observaciones :</span></td>
        <td><input name="txtObservaciones" type="text" id="txtObservaciones" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumAlfSig(event)" value="" size="80" maxlength="250" style="width:450px; height:35px" required="required" />          </textarea></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><span style="font-weight: bold">
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo $COD_ASOCIACION;?>" />
          <input name="CODIGOREGISTRO" type="hidden" id="CODIGOREGISTRO" value="<?php echo $CODIGOREGISTRO;?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo utf8_decode($ASOCIACION);?>" />
        </span>
          <input name="txtGestion" type="hidden" id="txtGestion" value="<?php echo $sltGestion;?>" />
          <input type="submit" name="button2" id="button2" value="Anular Registros" style="width:250px; height:35px"/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="2" /></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr></form>
  <tr>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center"><a href="frmDesimportar1.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($cont==0 && $txtBuscar==1){echo "<script>alert('No se encontraron registros para la Asociacion Seleccionada.')</script>";echo"<script> location.href='frmDesimportar1.php';</script>";}
?>