<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION; 
echo "<script>alert('Se RECOMIENDA eliminar los registros anteriores subidos con la anterior ZONA TRIBUTARIA \\n de la Asociación $ASOCIACION.')</script>";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmModAsocZonaTrib2.php'>
<body>
<table width="10%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR ASOCIACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Zona Tributaria</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">DATOS  ASOCIACION.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table width="20%" border="0">
      <?php $res=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ ?><tr>
        <td align="right" bgcolor="#CCCCCC">Nro. Carpeta :</td>
        <td><?php echo $rows['CARPETA']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
        <td><?php echo $rows['ORDENANZA_MUNICIPAL']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Nombre de la Asociación :</td>
        <td><?php echo $rows['DESCRIPCION']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona de Asentamiento :</td>
        <td><?php echo $rows['ZONA_UBICACION']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Direccion descriptiva de puestos de Venta :</td>
        <td><?php echo $rows['DIRECCION']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td><?php echo $rows['OBSERVACIONES']; ?></td>
        <td>&nbsp;</td>
      </tr><?php } ?>
      <tr>
        <td colspan="3" align="left" style="font-weight: bold">DATOS PUESTOS DE VENTA.</td>
      </tr>
      <tr>
        <td colspan="3" align="right"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Cantidad de Puestos de Venta :</td>
        <td><?php $res=mysql_query("select * from reg_asociacion_puesto where DESCRIPCION='PUESTOS DE VENTA' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ echo $rows['AFILIADOS'];}?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Cantidad de Carritos :</td>
        <td><?php $res=mysql_query("select * from reg_asociacion_puesto where DESCRIPCION='CARRITOS' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ echo $rows['AFILIADOS'];}?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Cantidad Kioscos :</td>
        <td><?php $res=mysql_query("select * from reg_asociacion_puesto where DESCRIPCION='KIOSKO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ echo $rows['AFILIADOS'];}?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" style="font-weight: bold">DATO ZONA TRIBUTARIA.</td>
      </tr>
      <tr>
        <td colspan="3" align="right"><hr /></td>
        </tr><?php $res=mysql_query("select ZT.DESCRIPCION,ZT.MONTO,ZT.CODIGO_ZONA from reg_asociacion_zona_tributaria RAZT,zona_tributaria ZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and  RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ ?>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria Actual :</td>
        <td><?php  echo $rows[0];$ACTUAL=$rows[0];$CODIGOACTUAL=$rows[2];?>
          <input name="CODIGOACTUAL" type="hidden" id="CODIGOACTUAL" value="<?php echo $CODIGOACTUAL;?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Impuesto Eventual Definido :</td>
        <td><?php  echo $rows[1];?></td>
        <td>&nbsp;</td>
      </tr><?PHP } ?>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Documento de Respaldo :</td>
        <td><input name="txtDocumentoRespaldo" type="text" id="txtDocumentoRespaldo" size="50" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();"  required/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Autorizado Por:</td>
        <td><input name="txtAutorizado" type="text" id="txtAutorizado" size="50" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();"  required/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cargo :</td>
        <td><select name="sltCargo" id="sltCargo">
          <option selected="selected">DIRECTOR DE FERIAS Y MERCADOS</option>
          <option>DIRECTOR DE FERIAS Y MERCADOS a.i.</option>
          <option>ENCARGADO DE AREA CONTABLE</option>
          <option>RESPONSABLE DE AREA CONTABLE</option>
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nueva Zona Tributaria :</td>
        <td><select name="sltZonaTributaria" id="sltZonaTributaria">
       <?php $res=mysql_query("select * from zona_tributaria where ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ if($ACTUAL==$rows['DESCRIPCION']){}else{ ?>
       <option><?php echo $rows['DESCRIPCION'];?></option><?php } } ?>
        </select>
          <input name="txtMod" type="hidden" id="txtMod" value="1" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">El cambio de la Zona Tributaria Afectara a partir de la fecha de modificacón de la Zona Tributaria y no así a los que se hayan generado los COMPROBANTES DE PAGO.</td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario">&nbsp;</td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario"><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"  ></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmModAsocZonaTrib.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>