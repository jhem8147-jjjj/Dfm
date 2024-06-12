<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<table width="90%" border="0" align="center">
  <tr>
    <td align="center" class="TITULO">CONSULTA DE COMPROBANTES DE PAGO PENDIENTE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Cambio de Nombre</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Asociaciones Registrados.</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA DE REGISTRO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DOCUMENTO REGISTRO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ASOCIACION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">GESTION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COMUNICACION INTERNA</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO REGISTRO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO ORDEN DE PAGO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">CANTIDAD DE CONTRIBUYENTES HABILITADOS</td>
          </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select distinct RHP.CODIGO_REGISTRO, RHP.FECHA,ASOC.ORDENANZA_MUNICIPAL,ASOC.DESCRIPCION,RHP.GESTION,RHP.COMUNICACION_INTERNA,RHP.ESTADO_PAGO,RHP.ESTADO_ORDEN_PAGO from reg_asociacion ASOC,reg_contribuyente_habilitado_pago_cambio_nombre RHP where RHP.CODIGO_ASOCIACION=ASOC.CODIGO_ASOCIACION and RHP.ESTADO_COMUNICACION_INTERNA='GENERADO' and  ASOC.ESTADO='ACTIVO' and RHP.ESTADO='ACTIVO'");
		 while($row=mysql_fetch_array($result)){ ?>
        <tr>
          <td><?php $CONT++; echo $CONT; ?></td>
          <td><?php echo $row[1]; ?></td>
          <td><?php echo $row[2]; ?></td>
          <td><?php echo utf8_decode($row[3]); ?></td>
          <td><?php echo $row[4]; ?></td>
          <td align="center" style="font-weight: bold"><?php echo $row[5]; ?></td>
          <td align="center" style="font-weight: bold"><?php if($row[6]=='NO PAGO'){echo 'REGISTRO(S) AUTORIZADO(S)';}else{echo 'REGISTRO(S) NO AUTORIZADO(S)';} ?></td>
          <td align="center" style="font-weight: bold"><?php if($row[7]=='NO VALIDADO'){echo 'PROFORMA NO EMITIDO';}else{echo 'PROFORMA EMITIDO';}; ?></td>
          <td align="center" style="font-weight: bold"><?php $res=mysql_query("select count(*) from reg_asociacion ASOC,reg_contribuyente_habilitado_pago_cambio_nombre RHP where RHP.CODIGO_REGISTRO='$row[0]' and RHP.CODIGO_ASOCIACION=ASOC.CODIGO_ASOCIACION and RHP.ESTADO_COMUNICACION_INTERNA='GENERADO' and  ASOC.ESTADO='ACTIVO' and RHP.ESTADO='ACTIVO'");
		 while($rowt=mysql_fetch_array($res)){ echo $rowt[0];}?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmConsultaNoImpComp.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table><?php include '../CssTablas/frmPieTabla.php';?>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>