<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/Ajax/jquery.min.js' type="text/javascript"></script>
<script src='Js/frmBuscarTiempoRealAsoc.js' type="text/javascript"></script>
<script src='Js/frmHabilitaBotonAsociacion.js' type="text/javascript"></script>

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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">DATOS DE LA ASOCIACION.</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td><table width="20%" border="0" cellspacing="1">
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nro. Carpeta :</td>
        <td class="comentario"><input name="txtCarpeta" type="text" id="txtCarpeta" onChange="javascript:this.value=this.value.toUpperCase();" size="50" required="required" placeholder="No. DE CARPETA."/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Documento de Registro :</td>
        <td class="comentario"><input name="txtOrdenanzaMunicipal" type="text" id="txtOrdenanzaMunicipal" onChange="javascript:this.value=this.value.toUpperCase();" placeholder="Nro.DE O.M. O RAMS."  onkeyup="buscar_ajax(this.value);" size="50" required="required"/>
          <input name="txtSw" type="hidden" id="txtSw" value="1" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre de la Asociación :</td>
        <td class="comentario"><input name="txtDescripcion" type="text" id="txtDescripcion"   onchange="javascript:this.value=this.value.toUpperCase();" onkeyup="return fileValidation()" placeholder="NOMBRE DE LA ASOCIACION" size="50" required/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td class="comentario"><div id="mostrar"> </div></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Zona de Asentamiento :</td>
        <td class="comentario"><input name="txtZona" type="text" id="txtZona" onchange="javascript:this.value=this.value.toUpperCase();" onkeyup="return fileValidation()" size="50" maxlength="1000" placeholder="ZONA DE ASENTAMIENTO" required="required"/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Direccion descriptiva de puestos de Venta :</td>
        <td class="comentario"><textarea name="txtDireccion" id="txtDireccion" cols="38" rows="2" maxlength="2000" onChange="javascript:this.value=this.value.toUpperCase();" onkeyup="return fileValidation()" placeholder="DIRECCION DESCRIPTIVA DE PUESTOS DE VENTA." required></textarea></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cantidad de Puestos de Venta :</td>
        <td class="comentario"><input name="txtPuestos" type="text" id="txtPuestos" value="0" size="10" required="required" onKeyPress="return soloNumeros(event)" placeholder="No. DE PUESTO."/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span> Cantidad de Carritos :</td>
        <td class="comentario"><input name="txtCentralera" type="text" id="txtCentralera" value="0" size="10" required="required" onKeyPress="return soloNumeros(event)" placeholder="No. DE CARRITOS."/></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cantidad Kioscos :</td>
        <td class="comentario"><input name="txtKiosko" type="text" id="txtKiosko" value="0" size="10" required="required" onKeyPress="return soloNumeros(event)" placeholder="No. DE KIOSCOS." /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td><textarea name="txtObservacion" id="txtObservacion" maxlength="255" cols="38" rows="2" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="OBSERVACIONES." ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td class="comentario">Esta glosa se imprimira en la Comunicacion Interna si los valores son Ceros en  total Cantidad de (Puestos de Venta, Carritos,Kioskos)</td>
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
        <td><input type="file" name="txtArchivo" id="txtArchivo" onchange="return fileValidation()" required ></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="250" height="6" /></td>
        <td class="comentario">Seleccione Archivo Pdf.</td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left">Dato de la Zona Tributaria.</td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Zona Tributaria :</td>
        <td class="comentario"><select name="sltZonaTributaria" id="sltZonaTributaria">
          <?php $result=mysql_query("select * from zona_tributaria where ESTADO='ACTIVO' order by DESCRIPCION"); while($row=mysql_fetch_array($result)){ ?>   <option><?php echo $row['DESCRIPCION'];?></option><?php } ?>
        </select></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario"><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px" disabled="disabled" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario"><img src="../Img/Blanco.png" width="600" height="2" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmRegAsociacion.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>