<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
 require '../Conexion_BD/Dbms.php';
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
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">CONSULTA CONTRIBUYENTE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Consulta</td>
  </tr>
  <tr>
    <td>Datos de Contribuyente.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <?php 
	  $res=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ESTADO='ACTIVO'");
	  while($row=mysql_fetch_array($res)){ 
	  $CODIGO_CONTRIBUYENTE=$row['CODIGO_CONTRIBUYENTE'];?> <tr>
        <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Nro. de Cédula de Identidad :</td>
        <td width="68%" style="font-weight: bold"><?php if(strlen($row['DOC_IDENTIDAD_ALFA'])>1){echo $row['DOC_IDENTIDAD'].' - '.$row['DOC_IDENTIDAD_ALFA'];}else{echo $row['DOC_IDENTIDAD'].' '.$row['DOC_IDENTIDAD_ALFA'];}?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><?php echo $row['EXPEDIDO'];?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Tipo de Documento :</td>
        <td style="font-weight: bold"><?php echo $row['TIPO_DOCUMENTO'];?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Nombre(s) y Apellido(s) :</td>
        <td style="font-weight: bold"><?php echo $row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'];?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold"><?php echo $row['OBSERVACIONES'];?></td>
      </tr><?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr><?php $res=mysql_query("select * from reg_contribuyente_habilitado_pago RCHP where RCHP.CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and RCHP.ESTADO='ACTIVO'");
	  while($row=mysql_fetch_array($res)){$SW=1;} if($SW==1){?>
  <tr>
    <td align="left" style="font-weight: bold">DETALLE DE REGISTRO HABILITADOS(Comprobantes de Pago no Emitidos).</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><hr /></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr style="font-weight: bold">
          <td height="31" align="center" >No.</td>
          <td align="center" >ASOCIACION</td>
          <td align="center" >ACTIVIDAD</td>
          <td align="center" >FILA</td>
          <td align="center" >PUESTO</td>
          <td align="center" >ESTADO PAGO</td>
        </tr>
      </thead>
      <tbody>
        <?php $res=mysql_query("select * from reg_contribuyente_habilitado_pago RCHP where RCHP.CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and RCHP.ESTADO='ACTIVO'");
	  while($row=mysql_fetch_array($res)){ 
	 ?>
        <tr>
          <td height="32"><?php $conts++; echo $conts; ?></td>
          <td><?php $rest=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$row[CODIGO_ASOCIACION]' and ESTADO='ACTIVO'");
	  while($rows=mysql_fetch_array($rest)){ echo $rows['DESCRIPCION']; }?></td>
          <td><?php echo $row['TIPO_VENTA']; ?></td>
          <td><?php echo $row['FILA']; ?></td>
          <td><?php echo $row['PUESTO']; ?></td>
          <td style="color: #F30"><?php echo $row['ESTADO_PAGO']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr><?php } ?>
  <tr>
    <td align="left" style="font-weight: bold">&nbsp;</td>
  </tr><?php $res=mysql_query("select * from reg_contribuyente_asociacion_pago where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE'");
	  while($row=mysql_fetch_array($res)){ $SWP=1;} if($SWP==1){
	 ?>
  <tr>
    <td align="left" style="font-weight: bold">DETALLE  DE COMPROBANTES DE PAGO EMITIDOS.</td>
  </tr>
  <tr>
    <td align="left"><hr /></td>
  </tr>
  <tr>
    <td align="left"><table id="example2" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr style="font-weight: bold">
          <td height="31" align="center" >No.</td>
          <td align="center" >Nombre(s) y Apellido(s)</td>
          <td align="center" >ASOCIACION</td>
          <td align="center" >No. DE COMPROBANTE DE PAGO</td>
          <td align="center" >FECHA DE EMISION</td>
          <td align="center" >ACTIVIDAD</td>
          <td align="center" >GESTION</td>
          <td align="center" >PAGO</td>
          </tr>
      </thead> <tbody>
        <?php $res=mysql_query("select * from reg_contribuyente_asociacion_pago where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE'");
	  while($row=mysql_fetch_array($res)){ 
	 ?>
      
     
        <tr>
          <td height="32"><?php $cont++; echo $cont; ?></td>
          <td><?php echo $row['CONTRIBUYENTE']; ?></td>
          <td><?php echo $row['ASOCIACION']; ?></td>
          <td><?php echo $row['NRO_COMPROBANTE']; ?></td>
          <td><?php echo $row['FECHA_IMPRESION']; ?></td>
          <td><?php echo $row['ACTIVIDAD']; ?></td>
          <td><?php echo $row['GLOSA_DESCRIPCION_1']; ?></td>
          <td><?php echo $row['ESTADO_PAGO']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr><?php } ?>
  <tr>
    <td align="center"><a href="frmConsultaContri.php">Volver</a></td>
  </tr>
  <tr>
    <td><img src="../Img/Blanco.png" width="800" height="6" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table><?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php require '../Control_Sesiones_Forms/Key.php';?><?php  require '../Conexion_BD/Cerrar_Dbms.php';if($conts==0 and $cont==0){
	echo"<script> alert('No se cargaron datos de Contribuyente Seleccionado.');</script>";

	}?>