<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form method="post" action="frmValidarNombresCont2.php">
<body><script>
var clicks=0;
</script>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO"><?php $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">MODIFICACION DE DATOS DE CONTRIBUYENTES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Asociación.</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea_Negra.png" width="600" height="2" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>
      <tr>
        <td height="26" align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
      </tr>
      <tr>
        <td width="32%" height="28" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="68%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?></td>
      </tr>
      <?php }?>
    </table></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">Datos de Contribuyente.</td>
  </tr>
  <tr>
    <td align="left"><img src="../Img/Linea_Negra.png" width="500" height="2" /></td>
  </tr>
  <tr>
    <td align="left"><table width="20%" border="0">
     <?php $resulty=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($rowy=mysql_fetch_array($resulty)){ ?>
      <tr>
        <td width="46%" align="right" bgcolor="#CCCCCC">Número Gremial :</td>
        <td width="54%" style="font-weight: bold; font-size: 14px;"><?php echo $NUMERO_GREMIAL;?>
          <input name="NroGremial" type="hidden" id="NroGremial" value="<?php echo $NUMERO_GREMIAL;?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Número de Cédula de Identidad :</td>
        <td style="font-weight: bold"><input name="txtNroCi" type="text" id="txtNroCi" style="width:100px; height:20px" onKeyPress="return soloNumeros(event)" value="<?php echo $rowy['DOC_IDENTIDAD'];?>" size="10" readonly="readonly" placeholder="Nro. de C.I." required/>
          -
            <input name="txtNroCiAl" type="text" id="txtNroCiAl" style="width:40px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soloLetrasNumeros(event)" value="<?php echo $rowy['DOC_IDENTIDAD_ALFA'];?>" size="10" readonly="readonly" placeholder="ALFA" />
          <input name="CODIGO_CONTRIBUYENTE" type="hidden" id="CODIGO_CONTRIBUYENTE" value="<?php echo $CODIGO_CONTRIBUYENTE;?>" />
          <input name="Idcs" type="hidden" id="Ids" value="<?php echo $Ids;?>" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><?php echo $rowy['EXPEDIDO'];  ?><input name="CODIGO_REGISTRO_CONT" type="hidden" id="CODIGO_REGISTRO_CONT" value="<?php echo $rowy['CODIGO_REGISTRO'];?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Nombre(s) y Apellido(s) :</td>
        <td style="font-weight: bold"><?php if($rowy['APELLIDO_ESPOSO']== null){echo $rowy['NOMBRE_RSOCIAL'].' '.$rowy['PRIMER_APELLIDO'].' '.$rowy['SEGUNDO_APELLIDO'];}else{echo $rowy['NOMBRE_RSOCIAL'].' '.$rowy['PRIMER_APELLIDO'].' '.$rowy['SEGUNDO_APELLIDO'].' de '.$rowy['APELLIDO_ESPOSO'];}?></td>
      </tr><?PHP } ?>
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">Datos Asociación. </td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><img src="../Img/Linea_Negra.png" width="500" height="2" /></td>
      </tr><?php $res=mysql_query("select * from reg_contribuyente_habilitado_pago where Id='$Ids' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO' and CODIGO_ASOCIACION='$COD_ASOCIACION'"); while($ros=mysql_fetch_array($res)){?>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Tipo de Puesto :</td>
        <td style="font-weight: bold"><select name="sltVenta" id="sltVenta" style="width:250px; height:20px">
        <option selected="selected"><?php echo  $ros['TIPO_VENTA'];?></option>
          <option>KIOSCO</option>
          <option>PUESTO DE VENTA</option>
          <option>CARRITO</option>
		  </select>
          <input name="REGMODPUESTO" type="hidden" id="REGMODPUESTO" value="1" />
          <input name="CODIGO_REGISTRO" type="hidden" id="CODIGO_REGISTRO" value="<?php echo $ros['CODIGO_REGISTRO'];?>" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Fila :</td>
        <td style="font-weight: bold"><input name="txtFila" type="text" id="txtFila"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetrasNumeros(event)" value="<?php echo $ros['FILA'];?>" placeholder="FILA"/>
          <input name="sltGestion" type="hidden" id="sltGestion" value="<?php echo $sltGestion;?>" />
          <input name="BUSCAR" type="hidden" id="BUSCAR" value="1" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Puesto :</td>
        <td style="font-weight: bold"><input name="txtPuesto" type="text" id="txtPuesto"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetrasNumeros(event)" value="<?php echo $ros['PUESTO'];?>" placeholder="PUESTO"/>
          <input name="txtZona" type="hidden" id="txtZona" value="<?php echo  $ros['CODIGO_ZONA'];?>" /></td>
      </tr><?php } ?>
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">Afecta los cambios a la gestion.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><img src="../Img/Linea_Negra.png" width="500" height="2" /></td>
        </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span>Afectar los cambios a las gestión(es) :</td>
        <td style="font-weight: bold"><?php echo $sltGestion;?></td>
      </tr>
      <tr>
        <td  align="right"><img src="../Img/Blanco.png" width="300" height="2" /></td>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td  align="right">&nbsp;</td>
        <td style="font-weight: bold"><span class="comentario">
          <input type="submit" name="button" id="button" value="Modificar" style="width:150px; height:35px" />
        </span></td>
      </tr>
      <tr>
        <td colspan="2"  align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmValidarNombresCont2.php?BUSCAR=1" title="VOLVER">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 4</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>