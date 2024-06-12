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
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO"> <?php $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Seleccionar Asociacion</td>
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
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DOCUMENTO DE REGISTRO</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ASOCIACION</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ZONA DE ASENTAMIENTO</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ZONA TRIBUTARIA</td>
              <td align="center" style="font-weight: bold">&nbsp;</td>
            </tr>
          </thead>
          <tbody>
            <?php $result=mysql_query("select ASOC.ORDENANZA_MUNICIPAL,ASOC.DESCRIPCION,ASOC.ARCHIVO,ASOC.AFILIADOS,ZT.DESCRIPCION,ASOC.CODIGO_ASOCIACION,ASOC.ZONA_UBICACION from reg_asociacion ASOC, zona_tributaria ZT, reg_asociacion_zona_tributaria ASOCZT where ASOC.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO' and ASOCZT.ESTADO='ACTIVO' and ASOCZT.CODIGO_ASOCIACION=ASOC.CODIGO_ASOCIACION  and ASOCZT.CODIGO_ZONA=ZT.CODIGO_ZONA order by ASOC.DESCRIPCION"); while($row=mysql_fetch_array($result)){ ?>
            <tr>
              <td><?php $CONT++; echo $CONT; ?></td>
              <td><?php echo $row[0]; ?></td>
              <td><?php echo $row[1]; ?></td>
              <td><?php echo $row[6]; ?></td>
              <td align="center" style="font-weight: bold"><?php echo $row[4]; ?></td>
              <td align="center" style="font-weight: bold"><a href="frmValidarNombresCont1.php?COD_ASOCIACION=<?php echo $row['5'];?>&ASOCIACION=<?php echo $row['1'];?>">Seleccionar</a></td>
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
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 0</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>