<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form method="post" action="frmConfComunInte.php">
<body>
<table width="10%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO"><?php $result=mysql_query("select * from nombre_formularios where UBICACION='CONFIGURAR COMUNICACION INTERNA' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">REGISTRAR NUEVO NIVEL DE COMUNICACION INTERNA</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" style="font-weight: bold"><table width="10%" border="0" cellspacing="3" bordercolor="#FFFFFF">
     
      <tr>
        <td width="32%" height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nivel :</td>
        <td width="68%" style="font-weight: bold"><select name="sltNivel" id="sltNivel" style="height:35px; width:100px">
          <option><?php echo $NIVEL;?></option>
          </select>
          </select></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Grado :</td>
        <td style="font-weight: bold"><input type="text" name="txtGrado" id="txtGrado" style="height:30px; width:400px" onkeyup="return fileValidation();"  onchange="javascript:this.value=this.value.toUpperCase();" placeholder="GRADO (LIC. SR. SRA. )" onkeypress="return soloNumAlfSig(event)" required="required"/></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre Completo :</td>
        <td style="font-weight: bold"><input type="text" name="txtNombres" id="txtNombres" style="height:30px; width:400px"  onchange="javascript:this.value=this.value.toUpperCase();" placeholder="NOMBRE(S) COMPLETO" onkeyup="return fileValidation();" onKeyPress="return soloLetras(event)" required/>
          <input name="REGMOD" type="hidden" id="REGMOD" value="1" /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Cargo :</td>
        <td style="font-weight: bold"><input type="text" name="txtCargo" id="txtCargo" style="height:30px; width:400px"  onchange="javascript:this.value=this.value.toUpperCase();" placeholder="CARGO"  onkeyup="return fileValidation();" onKeyPress="return soloLetras(event)" required="required"/></td>
      </tr>
      <tr>
        <td height="32" align="right"><img src="../Img/Blanco.png" width="370" height="6" /></td>
        <td style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:35px" />          <img src="../Img/Blanco.png" width="500" height="6" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><div id="mostrar"><a href="frmConfComunInte.php">Volver</a></div></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body></form>
</html><?php 

function normaliza ($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtoupper($cadena);
    return utf8_encode($cadena);
}
 require '../Conexion_BD/Cerrar_Dbms.php';?>