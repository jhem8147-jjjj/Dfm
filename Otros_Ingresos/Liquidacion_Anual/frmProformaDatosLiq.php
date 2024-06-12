<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$cont=0;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src="Js/frmValida.js" type="text/javascript"></script>
</head>
<form method="post" action="frmProformaDatosAsocLiq.php">
<body oncopy="return false" onpaste="return false">
<table width="10%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">PROFORMA DE DEUDA</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Emisión de Proforma de Deuda</td>
  </tr>
  <tr>
    <td align="center" class="TITULO">CARGADO DE MULTAS PARA LA ACTIVIDAD <?php echo $txtTipoActividad;?></td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="800" height="2" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="72%" style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo $COD_ASOCIACION;?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo utf8_decode($ASOCIACION);?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
        <td width="72%" rowspan="4" style="font-weight: bold"><table width="100%" border="0">
          <tr>
            <td align="center" bgcolor="#E3EEEE">ZONA TRIBUTARIA</td>
            <td align="center" bgcolor="#E3EEEE">Bs.-</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#CCCCCC">ZONA &quot;A&quot;</td>
            <td>23</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#CCCCCC">ZONA &quot;B&quot;</td>
            <td>15</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#CCCCCC">ZONA &quot;C&quot;</td>
            <td>7</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#CCCCCC">KIOSCO</td>
            <td>60</td>
          </tr>
          <tr>
            <td align="left"><img src="../Img/Blanco.png" width="100" height="2" /></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?>
        </span></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Gestión de Liquidación :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <select name="sltGestion" id="sltGestion" style="height:30px">
            
            <option selected="selected"><?php echo $sltGestion;?></option>
            
            </select>
          <input name="CODIGOREGISTRO" type="hidden" id="CODIGOREGISTRO" value="<?php echo $CODIGOREGISTRO;?>" />
        </span></td>
        </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="8" /></td>
        <td >&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">Datos de Liquidación (ES RESPONSABILIDAD DEL OPERADOR EL CARGADO Y LA VERIFICACION DE MULTAS).</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="800" height="2" /></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="100%" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td colspan="2" align="right" bgcolor="#CCCCCC">Tipo de Actividad :</td>
            <td width="32%"><select name="sltTipoActividad" id="sltTipoActividad">
              <option><?php echo $txtTipoActividad;?></option>
            </select></td>
            <td width="14%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span>  Monto Determinado (Bs.-) :</td>
            <td><input name="txtImpe" type="text" id="txtImpe" onkeyup="return fileValidation();" 
            onkeypress="return soloNumerosPunto(event)" value="<?php echo $ImpAnual;?>" 
            readonly="readonly" placeholder="0.00" required="required" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="7%" rowspan="5" align="right" bgcolor="#CCCCCC">MULTAS</td>
            <td width="47%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Mantenimiento de Valor con Relación a la Ufv's, (Bs.-) :</td>
            <td><table width="100%" border="0">
              <tr>
                <td width="17%">
                  <input name="txtMv" type="text" id="txtMv" onkeypress="return soloNumeros(event)" size="10" placeholder="MV UFV" onkeyup="return fileValidation();" required="required"/></td>
                <td width="8%" align="right" class="ASTERISCO">&lt;=</td>
                <td width="8%"><img src="../Img/bcb.gif" width="25" height="26" /></td>
                <td width="70%"><a href="https://www.bcb.gob.bo/calculadora-ufv/" title="PAGINA BANCO CENTRAL DE BOLIVIA" target="_blank">Calculadora Ufv BCB</a></td>
                </tr>
        </table></td>
            <td rowspan="4" bgcolor="#FEE2C5" class="comentario">  <?php $ANIOVEN=date('Y')-1;if($sltGestion<$ANIOVEN){echo 'CORRESPONDE CARGAR MULTAS DE ACUERDO A NORMATIVAS A LA GESTION VENCIDA: '.$sltGestion;}else{echo 'NO CORRESPONDE CARGAR MULTAS A LA GESTION:'.$sltGestion;}?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"> <span class="ASTERISCO">*</span>  Multa de Incumplimiento a Deberes Formales (Bs.-) :</td>
            <td><input name="txtMidf" type="text" id="txtMidf" onkeyup="return fileValidation();" onkeypress="return soloNumeros(event)" size="10" placeholder="Midf"  required="required"/>
              <input name="hdfRegistro" type="hidden" id="hdfRegistro" value="1" /></td>
            </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Interes (Bs.-) :</td>
            <td><input name="txtInteres" type="text" id="txtInteres" onkeypress="return soloNumeros(event)" size="10" placeholder="Interes" onkeyup="return fileValidation();" required="required"/></td>
            </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Otras Multas (Bs.-) :</td>
            <td><input name="txtOtrasMultas" type="text" id="txtOtrasMultas" onkeyup="return fileValidation();" onkeypress="return soloNumeros(event)" size="10" placeholder="Otras Multas"  required="required"/></td>
            </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Formulario/Comprobante de Pago (Bs.-) :</td>
            <td><input name="txtFormulario" type="text" id="txtFormulario" onkeyup="return fileValidation();" onkeypress="return soloNumeros(event)"  value="<?php echo $Formulario;?>" size="10" readonly="readonly"  placeholder="Bs.-" required="required"/></td>
            <td></td>
            </tr>
          <tr>
            <td colspan="2" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Observación (es) :</td>
            <td><textarea name="txtObservacion" id="txtObservacion" cols="30" rows="4" onkeyup="return fileValidation();" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return Letras(event)"  required="required">NINGUNO.</textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right"><img src="../Img/Blanco.png" width="300" height="2" /></td>
            <td><input type="submit" name="button" id="button" value="Registrar" style="width:250px; height:35px" /></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmProformaDatosAsocLiq.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';
function dias_transcurridos($fecha_i,$fecha_f)
{
$dias = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
/*if($cont==0 && $txtBuscar==1){echo "<script>alert('No se encontraron registros Validados para la Asociacion Seleccionada.')</script>";echo"<script> location.href='frmProforma.php';</script>";}*/
?>