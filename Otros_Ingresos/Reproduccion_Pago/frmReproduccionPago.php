<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='Js/frmValida.js' type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script> function comprobar(obj)
{   
    if (obj.checked){
      document.getElementById('txtCedulaIdentidad').readOnly = false;
	}else{
      document.getElementById('txtCedulaIdentidad').readOnly = true;
	}
        
}</script>
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
</head>
<form method="post" action="frmReproduccionPago.php">
<body>
<table width="90%" border="0" align="center">
  <tr>
    <td align="center" class="TITULO">COMPROBANTE DE PAGO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Reproducir Pago</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Criterios de Busqueda.
      <hr /></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><table width="80%" border="1" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> DOCUMENTO CEDULA DE IDENTIDAD :</td>
        <td><input type="checkbox" name="checkbox" id="chec" onchange="comprobar(this);" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td>Presentado por la (el) Intersada (o).</td>
      </tr>
      <tr>
        <td width="41%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Numero de Cedula de Identidad :</td>
        <td width="59%"><input type="text" name="txtCedulaIdentidad" id="txtCedulaIdentidad" style="width:250px; height:30px" onKeyPress="return soloNumeros(event)" placeholder="Nro. de CEDULA DE IDENTIDAD"  readonly required/>
          <input name="txtSW" type="hidden" id="txtSW" value="1" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td>Ejemplo: 123456</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="350" height="6" /></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr><?php if($txtSW==1){?>
  <tr>
    <td style="font-weight: bold">Resultados de la Busqueda.
    <hr /></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DOCUMENTO IDENTIDAD</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">RAZON SOCIAL</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ASOCIACION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">No. DE COMPROBANTE</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ACTIVIDAD</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">GESTION</td>
          <td align="center" style="font-weight: bold">&nbsp;</td>
          </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select distinct CEDULA_IDENTIDAD,ASOCIACION,ACTIVIDAD,DESCRIPCION_1,GLOSA_DESCRIPCION_1,CODIGO_REGISTRO,CODIGO_ASOCIACION,CODIGO_CONTRIBUYENTE,CONTRIBUYENTE,Id,NRO_COMPROBANTE from reg_contribuyente_asociacion_pago where CEDULA_IDENTIDAD like '$txtCedulaIdentidad%' and ESTADO='ACTIVO' order by ASOCIACION"); while($row=mysql_fetch_array($result)){ ?>
        <tr>
          <td><?php $CONT++; echo $CONT; ?></td>
          <td><?php echo $row['0']; ?></td>
          <td><?php echo $row['8']; ?></td>
          <td><?php echo $row['1']; ?></td>
          <td><?php echo $row['10']; ?></td>
          <td><?php echo $row['2']; ?></td>
          <td><?php echo $row['3']; ?></td>
          <td><?php echo $row['4']; ?></td>
          <td><?php if(strlen($row['8'])>7){?><a href="tcpdf/Reproduccion/74b856ce2dabed244104be634b017a3e.php?IMPRIMIR=<?php echo $row[9]; ?>" target="_New">Reproducir Pago</a><?php }else{ echo "ACTUALIZAR DATOS CONTRIBUYENTE EN D.F.M.";} ?></td>
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
    <td><hr /></td>
  </tr><?php } ?>
  <tr>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table><?php include '../CssTablas/frmPieTabla.php'?>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>