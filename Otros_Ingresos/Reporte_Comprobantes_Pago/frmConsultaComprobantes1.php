<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
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
<table width="98%" border="0" align="center">
  <tr>
    <td align="center" class="TITULO">REPORTE COMPROBANTE DE PAGO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO"> Comprobante de Pago Desde el Nro. <?php echo $txtCinicial;?> Hasta el  Nro. <?php echo $txtCfinal;?></td>
  </tr>
  <tr>
    <td style="font-weight: bold">Resultados Encontrados.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="27" align="center" style="font-weight: bold">No.</td>
          <td align="center" style="font-weight: bold">FECHA DE IMPRESION</td>
          <td align="center" style="font-weight: bold">USUARIO</td>
          <td align="center" style="font-weight: bold">No. DE COMPROBANTE</td>
          <td align="center" style="font-weight: bold">ASOCIACION</td>
          <td align="center" style="font-weight: bold">CONTRIBUYENTE</td>
          <td align="center" style="font-weight: bold">ACTIVIDAD</td>
          <td align="center" style="font-weight: bold">DESCRIPCION</td>
          <td align="center" style="font-weight: bold">TOTAL Bs.-</td>
          <td align="center" style="font-weight: bold">ESTADO PAGO</td>
          </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select * from reg_contribuyente_asociacion_pago where NRO_COMPROBANTE BETWEEN $txtCinicial AND $txtCfinal"); while($row=mysql_fetch_array($result)){ ?>
        <tr>
          <td><?php $CONT++; echo $CONT; ?></td>
          <td><?php echo $row['FECHA'].' Hrs. '.$row['HORA']; ?></td>
          <td><?php echo $row['USUARIO'].' - '.$row['NOMBRE_USUARIO']; ?></td>
          <td><?php echo $row['NRO_COMPROBANTE']; ?></td>
          <td align="left"><?php echo $row['ASOCIACION']; ?></td>
          <td align="left"><?php echo $row['CONTRIBUYENTE']; ?></td>
          <td align="left"><?php echo $row['ACTIVIDAD']; ?></td>
          <td align="left" ><?php echo $row['DESCRIPCION_1'].' - '.$row['GLOSA_DESCRIPCION_1']; ?></td>
          <td align="left" ><?php echo $row['TOTAL']; ?></td>
          <td align="left"><?php echo $row['ESTADO_PAGO']; ?></td>
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
    <td align="center"><a href="frmConsultaComprobantes.php">Nueva Consulta</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table><?php include '../CssTablas/frmPieTabla.php';?>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>