<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
echo"<script> alert('Verifique que la Fecha del Boucher de Deposito Bancario sea la misma que de la boleta de Liquidacion y/o Emision de Proforma.');</script>";
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['COM_INTERNA']=$COM_INTERNA;
$_SESSION['sltGestion']=$sltGestion;
$_SESSION['CODIGOREGISTRO']=$CODIGOREGISTRO;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/frmPagoAsociacion.js' type="text/javascript"></script>
<script> function comprobar(obj)
{   
    if (obj.checked){
      document.getElementById('txtComunicacion').readOnly = false;
       document.getElementById('txtAutorizado').readOnly = false;
	   document.getElementById('txtCargo').readOnly = false;
	   document.getElementById('txtNroCuenta').readOnly = false;
	   document.getElementById('txtFecha').readOnly = false;
	   document.getElementById('txtDeposito').readOnly = false;
	   document.getElementById('txtMonto').readOnly = false;

	}else{
      document.getElementById('txtComunicacion').readOnly = true;
       document.getElementById('txtAutorizado').readOnly = true;
	   document.getElementById('txtCargo').readOnly = true;
	   document.getElementById('txtNroCuenta').readOnly = true;
	   document.getElementById('txtFecha').readOnly = true;
	   document.getElementById('txtDeposito').readOnly = true;
	   document.getElementById('txtMonto').readOnly = true;
	}
        
}</script>
</head>
<?php
$_SESSION['auxContadorGrabar'] = 0;
?>
<form  method="post" action='frmOpciones.php'>
<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">COMPROBANTE DE PAGO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Emisión de Comprobante de Pago Asociación Anual</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Asociación.</td>
  </tr>
  <tr>
    <td><table width="10%" border="0">
      <tr>
        <td height="20" colspan="2" align="right"><img src="../Img/Linea.png" width="843" height="4" /></td>
        </tr>
      <tr>
        <td height="20" align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
        <td style="font-weight: bold"><?php echo $ORDENANZA_MUNICIPAL;?></td>
      </tr>
      <tr>
        <td height="21" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?>
          <input name="txtSw" type="hidden" id="txtSw" value="1" /></td>
      </tr>
      <tr>
        <td width="36%" height="21" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td width="64%" style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Comunicación Interna :</td>
                <td align="left" style="font-weight: bold"><?php echo $COM_INTERNA;?></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">Datos de Autorización de Impresión de Comprobante de Pago.</td>
        </tr>
      <tr>
        <td colspan="2" align="right"><img src="../Img/Linea.png" width="843" height="4" /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión de Pago :</td>
        <td style="font-weight: bold"><?php echo $sltGestion;?></option></td>
      </tr>
      <tr>
        <td rowspan="2" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> La fecha de Liquidacón y/o Emision de Proforma coincide con la fecha de Deposito Bancario :</td>
        <td class="comentario"><input type="checkbox" name="checkbox" id="chec" onchange="comprobar(this);" required="required"/></td>
      </tr>
      <tr>
        <td class="comentario">Es importante que sean las mismas fechas.</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Comunicación Interna DFM :</td>
        <td class="comentario"><input name="txtComunicacion" type="text" id="txtComunicacion" onchange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soloNumAlfSig(event)" onkeyup="return fileValidation()" size="50" maxlength="255" readonly placeholder="INGRESE LA COMUNICACION INTERNA." required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Autorizado por :</td>
        <td class="comentario"><input name="txtAutorizado" type="text" id="txtAutorizado" onchange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soloLetras(event)" onkeyup="return fileValidation()" size="50" maxlength="255" readonly placeholder="NOMBRE DE LA AUTORIDAD INSTRUIDA."  required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cargo  :</td>
        <td class="comentario"><input name="txtCargo" type="text" id="txtCargo" onchange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soloLetras(event)" onkeyup="return fileValidation()" size="50" maxlength="255" readonly placeholder="CARGO DE LA AUTORIDAD INSTRUIDA." required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Descripción Puestos de Venta :</td>
        <td class="comentario"><table width="10%" border="0" cellspacing="1" cellpadding="1" bordercolor="#FFFFFF">
          <tr>
            <td width="35%" align="right"><img src="../Img/Blanco.png" width="200" height="6" /></td>
            <td width="65%" align="left"><img src="../Img/Blanco.png" width="100" height="6" /></td>
          </tr>
          <?php  $res=mysql_query("select count(*),RCHP.TIPO_VENTA from reg_contribuyente_habilitado_pago RCHP, contribuyentes CONTRI where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCHP.GESTION='$sltGestion' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO' and RCHP.ESTADO_REGISTRO='REGISTRO VALIDADO.' and RCHP.ESTADO_ORDEN_PAGO='VALORES DE LIQUIDACION VALIDADOS' and CONTRI.ESTADO='ACTIVO' group by RCHP.TIPO_VENTA ");
		   while($row=mysql_fetch_array($res)){ $SWV=1;$SW2=1;?>
          <tr>
            <td align="right" bgcolor="#E3F0F2" style="font-weight: bold"><?php echo $row[1]; ?> :</td>
            <td align="left"><?php echo $row[0]; ?></td>
          </tr><?php } ?>
          <tr>
            <td align="right" style="font-weight: bold"><img src="../Img/Blanco.png" width="100" height="2" /></td>
            <td align="left">&nbsp;</td>
          </tr>
          
        </table></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">Datos de Deposito Bancario.</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nro. de Cuenta :</td>
        <td><span class="comentario">
          <input name="txtNroCuenta" type="text" id="txtNroCuenta" onkeyup="return fileValidation()" onkeypress="return soloNumeros(event)" value="10000004711912" size="50" placeholder="No. DEPOSITO BANCARIO" readonly required="required"/>
        </span></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha de Pago :</td>
        <td><input type="date" name="txtFecha" id="txtFecha" max="<?php echo date('Y-m-d');?>" readonly required/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> No. de Depósito Bancario :</td>
        <td class="comentario"><input name="txtDeposito" type="text" id="txtDeposito" onkeyup="return fileValidation()" onKeyPress="return soloNumeros(event)" placeholder="No. DEPOSITO BANCARIO" size="50" readonly required/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Monto Depositado Bs.-:</td>
        <td class="comentario"><input name="txtMonto" type="text" id="txtMonto" onchange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return soloNumerosPunto(event)" onkeyup="return fileValidation()" placeholder="MONTO DEPOSITO BANCARIO" size="20" readonly  required="required"/> 
          Decimales ( . ) Punto</td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="2" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><span class="comentario">
      <input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px" />
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="frmComprobantePago.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>

</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($SW2==0){
	echo"<script> alert('No Existe Gestiones Habilitados.');</script>";
	echo"<script> location.href='frmComprobantePago.php';</script>";
	}
if($VERIFICAR==1){if($SWV==0){ echo"<script> alert('No Existe Cotribuyentes Habilitados y/o Validados Correctamente.');</script>";
	echo"<script> location.href='frmComprobantePago.php';</script>";}}
	?>