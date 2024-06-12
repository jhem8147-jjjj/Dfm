<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
if($txtSw==1){
$CODIGO='ZT-'.date('Ymd His');
$sql="insert into fechas_vencimiento(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,FECHA_INICIO,FECHA_FIN,GESTION_COBRO,UFV_FINAL,OBSERVACIONES)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$CODIGO','$txtFechaInicio','$txtFechaFin','$sltGestion','$txtUfv','$txtObservaciones')";$result=mysql_query($sql)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD REGISTRO FECHA DE VENCIMIENTO COBRO DE IMPUESTO.");
//$sql1="insert into fechas_vencimiento(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_ZONA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$ZONATRIB')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD REGISTRO reg_zona_tributaria.");
	echo "<script>alert('Se Registro Correctamente.')</script>";
	}
//actualiza datos de inicio 
if($txtSwm==1){
$query = mysql_query("UPDATE fechas_vencimiento  SET ESTADO='DATOS MODIFICADOS $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO EN FECHA $FECHA Hrs. $HORA' where CODIGO_REGISTRO='$CODREGM' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL fechas_vencimiento.");
$CODIGO='ZT-'.date('Ymd His');
$sql="insert into fechas_vencimiento(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,FECHA_INICIO,FECHA_FIN,GESTION_COBRO,UFV_FINAL,OBSERVACIONES)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$CODIGO','$txtFechaInicio','$txtFechaFin','$sltGestion','$txtUfv','$txtObservaciones')";$result=mysql_query($sql)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD REGISTRO FECHA DE VENCIMIENTO COBRO DE IMPUESTO.");
//$sql1="insert into fechas_vencimiento(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_ZONA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$ZONATRIB')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD REGISTRO reg_zona_tributaria.");
	echo "<script>alert('Se Modifico los datos.')</script>";
	}	
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
<form  method="post" action='frmRegFechaInicioVencimiento.php'>
<body>
<table width="90%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">REGISTRAR , MODIFICAR GESTION DE COBRO DE IMPUESTO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">Fecha Inicio y Fecha de Culminacion de Cobro de Impuesto</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../Img/Linea.png" width="900" height="4" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Datos Fecha de Inicio y Conclusión de cobro de Impuesto Eventual..</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="48%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestion de Cobro de Impuesto  :</td>
        <td width="52%"><select name="sltGestion" id="sltGestion" required>
          <?php $result=mysql_query("select PS.DESCRIPCION from parametros_sistema PS where PS.UBICACION='GESTION DE COBRO' and PS.ESTADO='ACTIVO' order by PS.DESCRIPCION"); while($row=mysql_fetch_array($result)){$SW1=0;
			$res=mysql_query("select GESTION_COBRO from fechas_vencimiento where GESTION_COBRO='$row[0]' and ESTADO='ACTIVO'"); while($ro=mysql_fetch_array($res)){$SW1=1;} if($SW1==0){
			  ?>
          <option><?php echo $row['0']; ?></option>
          <?php 
			 }} ?>
        </select></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="2" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha de Inicio de Cobro de Impuesto  :</td>
        <td ><input name="txtFechaInicio" type="date" id="txtFechaInicio" value='<?php echo ('d-m-Y');?>'  required/>         
<input name="txtSw" type="hidden" id="txtSw" value="1" /></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="2" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha de Culminacion de Cobro de Impuesto  :</td>
        <td><input name="txtFechaFin" type="date" id="txtFechaFin" value='<?php echo ('d-m-Y');?>' required="required"/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="2" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Ufv de la fecha de Culminacion de Cobro de Impueso :</td>
        <td ><input name="txtUfv" type="text" id="txtUfv" value="5.0000" onkeypress="return soloNumPunto(event)" placeholder="Valor de Ufv" required /> 
          <span class="ASTERISCO">Utilice Punto(.) para decimales</span></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span>Observaciones :</td>
        <td ><textarea name="txtObservaciones" id="txtObservaciones" cols="45" rows="3" required>NINGUNO.</textarea></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">Historial de Fecha de Inicio y Culminacion de Cobro de Impuesto.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
          <thead>
      <tr>
        <td height="27" align="center" style="font-weight: bold">No.</td>
        <td align="center" style="font-weight: bold">Fecha Registro</td>
        <td align="center" style="font-weight: bold">Usuario</td>
        <td align="center" style="font-weight: bold">Gestion de Cobro</td>
        <td align="center" style="font-weight: bold">Fecha de Inicio</td>
        <td align="center" style="font-weight: bold">Fecha de Conclusion</td>
        <td align="center" style="font-weight: bold">Ufv Vencimiento</td>
        <td align="center" style="font-weight: bold">Observaciones</td>
        <td align="center" style="font-weight: bold">&nbsp;</td>
        </tr> </thead>
          <tbody>
      <?php $result=mysql_query("select * from fechas_vencimiento where ESTADO='ACTIVO' order by GESTION_COBRO DESC"); while($row=mysql_fetch_array($result)){ ?>
      <tr>
        <td><?php $CONT++; echo $CONT; ?></td>
        <td ><?php echo $row['FECHA'].' Hrs. '.$row['HORA']; ?></td>
        <td ><?php echo $row['USUARIO'].' - '.$row['NOMBRE_OPERADOR']; ?></td>
        <td ><?php echo $row['GESTION_COBRO']; ?></td>
        <td ><?php $fecha_ini = explode('-' , $row['FECHA_INICIO']); echo $fecha_ini[2].'/'.$fecha_ini[1].'/'.$fecha_ini[0]; ?></td>
        <td ><?php $fecha_fin = explode('-' , $row['FECHA_FIN']); echo $fecha_fin[2].'/'.$fecha_fin[1].'/'.$fecha_fin[0];?></td>
        <td><?php echo $row['UFV_FINAL']; ?></td>
        <td><?php echo $row['OBSERVACIONES']; ?></td>
        <td><table width="10%" border="0">
          <tr>
            <td><a href="frmModificarFechaVencimiento.php?sltGestiones=<?php echo $row['GESTION_COBRO']; ?>&FechaInicio=<?php echo $row['FECHA_INICIO'];?>&FechaFin=<?php echo $row['FECHA_FIN'];?>&ValorUfv=<?php echo $row['UFV_FINAL']; ?>&CODREGM=<?php echo $row['CODIGO_REGISTRO']; ?>" title="MODIFICAR DATOS"><img src="../Img/modificar.png" width="20" height="20" /></a></td>
            </tr>
        </table></td>
        </tr>
      <?php } ?> </tbody>
          <tfoot>
          </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php';?>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>