<?php  
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COM_INT']=$COM_INT;
$_SESSION['CODIGOREGISTRO']=$CODIGOREGISTRO; 
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>

<body>
<table width="10%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">LIQUIDACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">CAMBIO DE NOMBRE Y COMPLEMENTACION</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento :</td>
        <td style="font-weight: bold"><?php echo $DOCUMENTOREG;?></td>
      </tr>
      <tr>
        <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="72%" style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <?php  $sql = "select ZT.DESCRIPCION,ZT.CODIGO_ZONA, monto,  RAZT.CODIGO_ZONA as CODIGO_ZONA__
                          from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT 
                          where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' 
                          and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA 
                          and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'"; 
                          $liqui=mysql_query($sql);while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1]; $CODIGO_ZONA__=$rowt[3]; } 
                          //echo $sql;

                // obtiene costos de cambio de nombre
                $sql_ = "select * from cambio_nombre where ESTADO='ACTIVO' and CODIGO_ZONA_ like '$CODIGO_ZONA__' ";
                $rest=mysql_query($sql_);
                while($rowt=mysql_fetch_array($rest)){
                  $COSTOCAMBIONOMBRE=$rowt['MONTO'];
                  $COSTOCAMBIONOMBREFORMULARIO=$rowt['FORMULARIO'];
                  }
                // obtiene costos de complemento
                $rest=mysql_query("select * from complemento where ESTADO='ACTIVO' and CODIGO_ZONA_ like '$CODIGO_ZONA__'");while($rowt=mysql_fetch_array($rest)){
                  $COSTOCOMPLEMENTO=$rowt['MONTO'];
                  $COSTOCOMPLEMENTOFORMULARIO=$rowt['FORMULARIO'];
                }

          ?>
        </span></td>
      </tr>
      
      <tr>
        <td height="25" align="right" bgcolor="#CCCCCC">Comunicación Interna :</td>
        <td style="font-weight: bold; font-size: 14px;" ><?php echo $COM_INT;?></td>
      </tr>
      <tr>
        <td align="right"><span style="font-weight: bold"><img src="../Img/Linea.png" width="250" height="4" /></span></td>
        <td >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
    <?php if($CN==1){?>
  <tr>
    <td align="left" style="font-weight: bold">DATOS EXPRESADO EN BOLIVIANOS - CAMBIO DE NOMBRE .</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"></td>
  </tr>
  <form method="post" action="frmLiquidacion3.php">
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> NUMERO DE CUENTA A DEPOSITAR :</td>
        <td><input name="txtDepositoCn" type="text" id="txtDepositoCn" onkeypress="return soloNumeros(event)" onkeyup="return fileValidation();" value="10000004711912" placeholder="Nro. DE CUENTA"  />
          <input name="txtBancoCn" type="text" id="txtBancoCn" value="BANCO UNION S.A." /></td>
      </tr>
      <tr>
        <td width="8%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Monto a Pagar Individual :<?php echo $COSTOCAMBIONOMBRE;?></td>
        <td width="92%"><input name="txtMontoCn" type="text" id="txtMontoCn" value="<?php echo $COSTOCAMBIONOMBRE;?>"  required />
          <input name="CN" type="hidden" id="CN" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Multas Individual :</td>
        <td><input name="txtMultaCn" type="text" id="txtMultaCn" value="0" onkeypress="return soloNumeros(event)" placeholder="MULTA BS.-" onkeyup="return fileValidation();"  required/>
          <span class="ASTERISCO">Ingrese la Multa si corresponde.</span></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Formulario :</td>
        <td><input name="txtFormularioCN" type="text" id="txtFormularioCN" value="<?php echo $COSTOCAMBIONOMBREFORMULARIO;?>" readonly="readonly" onkeypress="return soloNumeros(event)" placeholder="FORMULARIO BS.-" onkeyup="return fileValidation();" required/></td>
      </tr>
      <tr>
        <td align="right" valign="top"><img src="../Img/Linea.png" width="250" height="4" /></td>
        <td><input type="submit" name="button" id="button" value="Registrar Datos" style="width:250px; height:35px" /></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td class="ASTERISCO">VERIFIQUE LOS VALORES DE LIQUIDACION</td>
      </tr>
    </table></td>
  </tr>
  </form>
  <?php } if($CC==1){?>
  <form method="post"  action="frmLiquidacion3.php">
  <tr>
    <td align="left" style="font-weight: bold">DATOS EXPRESADO EN BOLIVIANOS - COMPLEMENTACION .</td>
  </tr>
  <tr>
    <td align="center"><span style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></span></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span>NUMERO DE CUENTA A DEPOSITAR :</td>
        <td><input name="txtDepositoCC" type="text" id="txtDepositoCC" onkeypress="return soloNumeros(event)" onkeyup="return fileValidation1();" value="10000004711912" placeholder="No. DE CUENTA BS.-"/>
          <input name="txtBancoCc" type="text" id="txtBancoCc" value="BANCO UNION S.A." /></td>
      </tr>
      <tr>
        <td width="8%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Monto a Pagar Individual :</td>
        <td width="92%"><input name="txtMontoCC" type="text" id="txtMontoCC" value="<?php echo $COSTOCOMPLEMENTO;?>"  onkeypress="return soloNumeros(event)" placeholder="MONTO BS.-" onkeyup="return fileValidation1();" required />
          <input name="CC" type="hidden" id="CC" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Multas Individual :</td>
        <td><input name="txtMultaCC" type="text" id="textfield5" value="0" onkeypress="return soloNumeros(event)" placeholder="MULTA BS.-" onkeyup="return fileValidation1();" required/>
          <span class="ASTERISCO">Ingrese la Multa si corresponde.</span></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Formulario :</td>
        <td><input name="txtFormularioCC" type="text" id="textfield6" value="<?php echo $COSTOCOMPLEMENTOFORMULARIO;?>" readonly="readonly" onkeypress="return soloNumeros(event)" placeholder="FORMULARIO BS.-" onkeyup="return fileValidation1();" required /></td>
      </tr>
      <tr>
        <td align="right" valign="top"><img src="../Img/Linea.png" width="250" height="4" /></td>
        <td><input type="submit" name="button2" id="button2" value="Registrar Datos"  style="width:250px; height:35px"/></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td><span class="ASTERISCO">VERIFIQUE LOS VALORES DE LIQUIDACION</span></td>
      </tr>
    </table></td>
  </tr>
  </form>
  <?php } ?>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><span class="ASTERISCO">* Ingrese Valores numericos.</span></td>
  </tr>
  <tr>
    <td align="center"><a href="frmLiquidacion1.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>