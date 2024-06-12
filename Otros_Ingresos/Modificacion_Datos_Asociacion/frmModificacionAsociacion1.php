<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
 
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=utf8_decode($ASOCIACION); 
if($txtMod==1){
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
$query = mysql_query("UPDATE reg_asociacion  SET ESTADO='DATO MODIFICADO POR EL USUARIO: $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO EN FECHA: $FECHA HORA: $HORA' where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_asociacion_puesto.");

$query = mysql_query("UPDATE reg_asociacion_puesto  SET ESTADO='DATO MODIFICADO POR EL USUARIO: $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO EN FECHA: $FECHA HORA: $HORA' where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_asociacion_puesto.");
//REGISTRA ASOCIACION.
$sql1="insert into reg_asociacion(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,CARPETA,DESCRIPCION,ORDENANZA_MUNICIPAL,ARCHIVO,AFILIADOS,ZONA_UBICACION,DIRECCION,OBSERVACIONES)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$txtCodRegistro','$COD_ASOCIACION','$txtCarpeta','$txtDescripcion','$txtOrdenanzaMunicipal','$NOMBRE_ARCHIVO','$TOTAL_AFILIADOS','$txtZona','$txtDireccion','$txtObservacion')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_asociacion.");
//PUESTO
$sql1="insert into reg_asociacion_puesto(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,DESCRIPCION,AFILIADOS)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$txtCodRegistro','$COD_ASOCIACION','PUESTOS DE VENTA','$txtPuestos')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA reg_asociacion_puesto.");			 
//CENTRALERAS
$sql1="insert into reg_asociacion_puesto(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,DESCRIPCION,AFILIADOS)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$txtCodRegistro','$COD_ASOCIACION','CARRITOS','$txtCentralera')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_asociacion_puesto.");			 
//KIOSKO
$sql1="insert into reg_asociacion_puesto(PC_NAME,PC_IP,FECHA,HORA,USUARIO,NOMBRE_OPERADOR,CODIGO_REGISTRO,CODIGO_ASOCIACION,DESCRIPCION,AFILIADOS)values('$hostname','$hostlocal','$FECHA','$HORA','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$txtCodRegistro','$COD_ASOCIACION','KIOSKO','$txtKiosko')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA reg_asociacion_puesto.");			 
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$txtDescripcion','MODIFICACION DE DATOS DE LA ASOCIACION','MODIFICACION DE DATOS DE LA ASOCIACION $txtDescripcion.','MODIFICACION DE DATOS DE LA ASOCIACION $txtDescripcion.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 			  echo "<script>alert('Se módifico los datos de la Asociación.')</script>";echo"<script> location.href='frmModificacionAsociacion.php';</script>";

 }
      }
    } else {
 echo "<script>alert('Se produjo un error al subir el Archivo seleccionado.')</script>";
            }	
	
	}

//busca datos puestos 
$liq=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($liq)){ $CODIGO_REGISTRO=$row['CODIGO_REGISTRO'];$CARPETA= $row['CARPETA']; $OM= $row['ORDENANZA_MUNICIPAL']; $AFILIADOS= $row['AFILIADOS']; $ZONA_UBICACION= $row['ZONA_UBICACION']; $DIRECCION= $row['DIRECCION'];$OBSERVACIONES= $row['OBSERVACIONES'];}
//obtiene nro de puestos de venta
$liq=mysql_query("select * from reg_asociacion_puesto where CODIGO_ASOCIACION='$COD_ASOCIACION' and DESCRIPCION='PUESTOS DE VENTA' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($liq)){ $PUESTOS_VENTA= $row['AFILIADOS'];}
$liq=mysql_query("select * from reg_asociacion_puesto where CODIGO_ASOCIACION='$COD_ASOCIACION' and DESCRIPCION='CARRITOS' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($liq)){ $CARRITOS= $row['AFILIADOS'];}
$liq=mysql_query("select * from reg_asociacion_puesto where CODIGO_ASOCIACION='$COD_ASOCIACION' and DESCRIPCION='KIOSKO' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($liq)){ $KIOSKO= $row['AFILIADOS'];}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css"><script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmModificacionAsociacion1.php' enctype="multipart/form-data">
<body oncopy="return false" onpaste="return false">

<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO"><?php $liq=mysql_query("select * from nombre_formularios where UBICACION='MODIFICAR DATOS ASOCIACION' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($liq)){ echo $row['DESCRIPCION'];}?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Modificar Datos de la  Asociación</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">DATOS  ASOCIACION SELECIONADA.</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td><table width="20%" border="0">
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nro. Carpeta :</td>
        <td class="comentario"><input name="txtCarpeta" type="text" id="txtCarpeta"  onkeypress="return soloNumAlfSig(event);" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $CARPETA;?>" size="50" required="required" placeholder="No. DE CARPETA."/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Ordenanza Municipal :</td>
        <td class="comentario"><input name="txtOrdenanzaMunicipal" type="text" id="txtOrdenanzaMunicipal"  onChange="javascript:this.value=this.value.toUpperCase();"   value="<?php echo $OM;?>" size="50" placeholder="Nro.DE O.M. O RAMS. L.M." required="required"/>
          <input name="txtMod" type="hidden" id="txtMod" value="1" />
          <input name="txtCodRegistro" type="hidden" id="txtCodRegistro" value="<?php echo $CODIGO_REGISTRO;?>" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre de la Asociación :</td>
        <td class="comentario"><input name="txtDescripcion" type="text" id="txtDescripcion" onKeyPress="return soloNumAlfSig(event);" onchange="javascript:this.value=this.value.toUpperCase();"  onkeyup="return fileValidation();" value="<?php echo $ASOCIACION;?>" size="50" placeholder="NOMBRE DE LA ASOCIACION" required/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Zona de Asentamiento :</td>
        <td class="comentario"><input name="txtZona" type="text" id="txtZona" onKeyPress="return soloNumAlfSig(event);" onchange="javascript:this.value=this.value.toUpperCase();"  onkeyup="return fileValidation();" value="<?php echo $ZONA_UBICACION;?>" size="50" maxlength="1000" placeholder="ZONA DE ASENTAMIENTO" required="required"/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Direccion descriptiva de puestos de Venta :</td>
        <td class="comentario"><textarea name="txtDireccion" id="txtDireccion" cols="38" maxlength="1000" rows="2" onChange="javascript:this.value=this.value.toUpperCase();" onkeyup="return fileValidation();" onKeyPress="return soloNumAlfSig(event);" placeholder="DIRECCION DESCRIPTIVA DE PUESTOS DE VENTA." required><?php echo $DIRECCION;?></textarea></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cantidad de Puestos de Venta :</td>
        <td class="comentario"><input name="txtPuestos" type="text" id="txtPuestos" value="<?php echo $PUESTOS_VENTA;?>" size="10" required="required" onKeyPress="return soloNumeros(event);" placeholder="No. DE PUESTO."/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span> Cantidad de Carritos :</td>
        <td class="comentario"><input name="txtCentralera" type="text" id="txtCentralera" value="<?php echo $CARRITOS;?>" size="10" required="required" onKeyPress="return soloNumeros(event);" placeholder="No. DE CARRITOS."/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cantidad Kioscos :</td>
        <td class="comentario"><input name="txtKiosko" type="text" id="txtKiosko" value="<?php echo $KIOSKO;?>" size="10" required="required" onKeyPress="return soloNumeros(event);" placeholder="No. DE KIOSKOS." /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td><span class="comentario">
          <textarea name="txtObservacion" id="txtObservacion" cols="38" rows="2" maxlength="255" onkeypress="return soloNumAlfSig(event);" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="OBSERVACIONES." ><?php echo $OBSERVACIONES;?></textarea>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><table width="100%" border="0">
          <tr>
            <td width="99%" align="right"><span class="ASTERISCO">*</span> Archivo Digitalizado Ordenanza Municipal :</td>
            <td width="1%"><div id="imagePreview"></div></td>
          </tr>
        </table>
          :</td>
        <td><input type="file" name="txtArchivo" id="txtArchivo" onchange="return fileValidation();" required ></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">Seleccione Archivo Pdf.</td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario"><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px" disabled="disabled"/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmModificacionAsociacion.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>