<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
mysql_set_charset("utf8", $conexion_usuarios) or die("NO SE PUDO CONFIGURAR LA CONEXION UTF-8: " . mysql_error($conexion_usuarios));
if($txtSw==1){
$COD_ASOC=date('Ymd His');
//copia archivo pdf o.m.
 if ((($_FILES["txtArchivo"]["type"] == "application/pdf") ||
    ($_FILES["txtArchivo"]["type"] == "application/pdf") ||
    ($_FILES["txtArchivo"]["type"] == "application/pdf")) &&
    ($_FILES["txtArchivo"]["size"] < 400000000)) {


      if ($_FILES["txtArchivo"]["error"] > 0) {
		  echo "<script>alert('Error de Archivo.')</script>";
        //echo $_FILES["txtArchivo"]["error"] . "<br />";
      } else {

          if (file_exists("txtArchivo/" . $_FILES["archivo"]["name"])) {
            echo $_FILES["txtArchivo"]["name"] . " ya existe. ";
          } else {

            move_uploaded_file($_FILES["txtArchivo"]["tmp_name"],
          "ORDENANZA_MUNICIPAL/" . $_FILES["txtArchivo"]["name"]);
            
			 $NOMBRE_ARCHIVO = "ORDENANZA_MUNICIPAL/" . $_FILES['txtArchivo']['name'];
			 $TOTAL_AFILIADOS=$txtPuestos + $txtCentralera + $txtKiosko;
$txtCarpeta=trim($txtCarpeta);
$txtDescripcion=trim($txtDescripcion);
$txtOrdenanzaMunicipal=trim($txtOrdenanzaMunicipal);
$txtZona=trim($txtZona);
$txtDireccion=trim($txtDireccion);
$txtCarpeta=normaliza($txtCarpeta);  
$txtDescripcion=normaliza($txtDescripcion);  
$txtZona=normaliza($txtZona);
$txtDireccion=normaliza($txtDireccion);
$txtObservacion=normaliza($txtObservacion);
$txtCarpeta=mysql_real_escape_string($txtCarpeta, $conexion_usuarios);
$txtDescripcion=mysql_real_escape_string($txtDescripcion, $conexion_usuarios);
$txtOrdenanzaMunicipal=mysql_real_escape_string($txtOrdenanzaMunicipal, $conexion_usuarios);
$txtZona=mysql_real_escape_string($txtZona, $conexion_usuarios);
$txtDireccion=mysql_real_escape_string($txtDireccion, $conexion_usuarios);
$txtObservacion=mysql_real_escape_string($txtObservacion, $conexion_usuarios);
$NOMBRE_ARCHIVO=mysql_real_escape_string($NOMBRE_ARCHIVO, $conexion_usuarios);
$sltZonaTributaria=mysql_real_escape_string($sltZonaTributaria, $conexion_usuarios);
$US_SIOI=mysql_real_escape_string($US_SIOI, $conexion_usuarios);
$SIAUNOMBRES=mysql_real_escape_string($SIAUNOMBRES, $conexion_usuarios);
$USPRIMERAPELLIDO=mysql_real_escape_string($USPRIMERAPELLIDO, $conexion_usuarios);
$SIAUSEGUNDOAPELLIDO=mysql_real_escape_string($SIAUSEGUNDOAPELLIDO, $conexion_usuarios);
$hostname=mysql_real_escape_string($hostname, $conexion_usuarios);
$hostlocal=mysql_real_escape_string($hostlocal, $conexion_usuarios);
$res=mysql_query("select * from nros_correlativos");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO_ASOCIACION']+1;
}
$query = mysql_query("UPDATE nros_correlativos  SET NRO_ASOCIACION='$CODIGO_NRO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos asociacion.");

$sql1="insert into reg_asociacion(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,CARPETA,DESCRIPCION,ORDENANZA_MUNICIPAL,ARCHIVO,AFILIADOS,ZONA_UBICACION,DIRECCION)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$CODIGO_NRO','$COD_ASOC','$txtCarpeta','$txtDescripcion','$txtOrdenanzaMunicipal','$NOMBRE_ARCHIVO','$TOTAL_AFILIADOS','$txtZona','$txtDireccion')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_asociacion.");
//PUESTO
$sql1="insert into reg_asociacion_puesto(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,DESCRIPCION,AFILIADOS)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$CODIGO_NRO','$COD_ASOC','PUESTOS DE VENTA','$txtPuestos')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA reg_asociacion_puesto.");			 
//CENTRALERAS
$sql1="insert into reg_asociacion_puesto(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,DESCRIPCION,AFILIADOS)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$CODIGO_NRO','$COD_ASOC','CARRITOS','$txtCentralera')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_asociacion_puesto.");			 
//KIOSKO
$sql1="insert into reg_asociacion_puesto(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,DESCRIPCION,AFILIADOS)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$CODIGO_NRO','$COD_ASOC','KIOSCO','$txtKiosko')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA reg_asociacion_puesto.");
//BUSCA ZONA TRIBUTARIA
$result=mysql_query("select * from zona_tributaria where DESCRIPCION='$sltZonaTributaria' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ $ZONATRIB=$row['CODIGO_ZONA'];}
$sql1="insert into reg_asociacion_zona_tributaria(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,CODIGO_ZONA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_ASOC','$COD_ASOC','$ZONATRIB')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD REGISTRO CONTRIBUYENTE.");
			 
$COD_REGISTRO=date('Ymd His');

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,CODIGO_ZONA,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOC','$txtDescripcion','$ZONATRIB','REGISTRO DE ASOCIACION','REGISTRO DE ASOCIACION $txtDescripcion ZONA TRIBUTARIA $sltZonaTributaria.','REGISTRO DE ASOCIACION $txtDescripcion ZONA TRIBUTARIA $sltZonaTributaria.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
echo "<script>alert('Archivo Registrado.')</script>";
}
      }
    } else {
 echo "<script>alert('Se produjo un error al subir el Archivo seleccionado.')</script>";
            } 
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
<style type="text/css">
body {
	margin-left: 4px;
	margin-top: 2px;
	margin-right: 2px;
	margin-bottom: 2px;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
}
</style>
</head>
<form  method="post" action='frmRegAsociacion.php' enctype="multipart/form-data">
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">REGISTRAR ASOCIACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Registrar Nueva Asociación</td>
  </tr>
  <tr>
    <td align="right"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="41%" align="left" style="font-weight: bold">Datos Asociación(es) Registrada(s). </td>
        <td width="55%" align="right"><a href="frmAgregarAsociacion.php">AGREGAR NUEVA ASOCIACION</a></td>
        <td width="4%" ><a href="frmAgregarAsociacion.php"><img src="../Img/Adicionar.png" width="47" height="53" /></a></td>
      </tr>
      <tr>
        <td colspan="3" align="left"><img src="../Img/Linea_Negra.png" width="1080" height="2" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
      <tr>
        <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DOCUMENTO DE REGISTRO</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ASOCIACION</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ZONA DE ASENTAMIENTO</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION PUESTOS</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">AFILIADOS PERMITIDOS</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ZONA TRIBUTARIA</td>
        <td align="center" style="font-weight: bold">&nbsp;</td>
        </tr></thead>
        <tbody>
      <?php $result=mysql_query("select ASOC.ORDENANZA_MUNICIPAL,ASOC.DESCRIPCION,ASOC.ARCHIVO,ASOC.AFILIADOS,ZT.DESCRIPCION,ASOC.CODIGO_ASOCIACION,ASOC.ZONA_UBICACION from reg_asociacion ASOC, zona_tributaria ZT, reg_asociacion_zona_tributaria ASOCZT where ASOC.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO' and ASOCZT.ESTADO='ACTIVO' and ASOCZT.CODIGO_ASOCIACION=ASOC.CODIGO_ASOCIACION  and ASOCZT.CODIGO_ZONA=ZT.CODIGO_ZONA order by ASOC.DESCRIPCION"); while($row=mysql_fetch_array($result)){ ?>
      <tr>
        <td><?php $CONT++; echo $CONT; ?></td>
        <td><?php echo htmlspecialchars(str_replace("Â°", "°", $row[0]), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[6]; ?></td>
        <td><table width="100%" border="1" cellpadding="1" cellspacing="1">
         <?php $res=mysql_query("select * from reg_asociacion_puesto where CODIGO_ASOCIACION='$row[5]' and ESTADO='ACTIVO' order by DESCRIPCION"); while($rows=mysql_fetch_array($res)){ ?>  <tr>
            <td align="right" bgcolor="#E3F0F2"><?php echo $rows['DESCRIPCION']; ?></td>
            <td ><u><?php echo $rows['AFILIADOS']; ?></u></td>
          </tr><?php } ?>
        </table></td>
        <td align="center" style="font-weight: bold"><?php if($row[3]==0){echo 'No Definido';}else{echo $row[3];} ?></td>
        <td align="center" style="font-weight: bold"><?php echo $row[4]; ?></td>
        <td>
          <table width="100%" border="0">
            <tr>
              <td width="23%"><a href="<?php echo $row[2]; ?>" target="_blank"><img src="../Img/pdf.png" width="40" height="30" /></a></td>
              <td width="77%"></td>
            </tr>
          </table></td>
        </tr><?php } ?></tbody>
        <tfoot>
       
        <tfoot>
      
    </table></td>
  </tr>
  <tr>
    <td class="ASTERISCO"><hr /></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'; ?>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';

function normaliza ($cadena){
    return mb_strtoupper($cadena, 'UTF-8');
}?> 