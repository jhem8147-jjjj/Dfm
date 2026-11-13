<?php  require'../Control_Sesiones_Forms/frmControlSesionUsuario.php';?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>.:: GAMEA - GREMIALES ::.</title><link rel='StyleSheet' href="../../Css/Index.css" type="text/css">
<style type="text/css">
body {
	background-color: #CCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../Img/fondo3.jpg);
}
a:link {
	color: #591F94;
	text-decoration: none;
}
a:visited {
	color: #591F94;
	text-decoration: none;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
}
a:hover {
	text-decoration: underline;
	color: #591F94;
}
a:active {
	text-decoration: none;
}
</style>
</head><body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
      <td colspan="5" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
      <td colspan="5"><hr color="#591F94"></td>
    </tr>
    <tr>
          <td>&nbsp;</td>
          <td style="font-weight: bold; font-size: 12px;">GOBIERNO AUTONOMO MUNCICIPAL DE EL ALTO</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td style="font-weight: bold; font-size: 12px;">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td valign="middle">&nbsp;</td>
    <td valign="middle"><span style="color: #000; font-weight: bold; font-size: 11px;"><?php echo '.:: '.$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y')." | ".$US_SIOI." | SERVIDOR PRODUCCION ::."; ?></span></td>
    <td align="right" style="color: #FFF; font-weight: bold; font-size: 11px;"><p>&nbsp;</p><p>&nbsp;</p>
   
      <p>&nbsp;</p></td>
    <td align="right" valign="top" style="color: #FFF; font-weight: bold; font-size: 11px;"><table width="80%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td  align="center"><a href="../Documentos_Descargas/frmDescargas.php" target="frmCuerpo"><img src="../Img/descargas.png" width="45" height="40"></a></td>
        <td  align="center"><a href="../Cambio_Contrasenia_Usuarios/frmCambiarContrasenia.php" target="frmCuerpo"><img src="../Img/password.png" alt="CAMBIAR CONTRASEÑA" width="40" height="40"></a></td>
        <td  align="center"><a href="frmCerrarSesionUsuario.php" target="_parent"><img src="../Img/Exit-Page.png" width="40" height="40"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="../Documentos_Descargas/frmDescargas.php" target="frmCuerpo">Descargas</a></td>
        <td align="center"> <a href="../Cambio_Contrasenia_Usuarios/frmCambiarContrasenia.php" target="frmCuerpo">Contraseña</a></td>
        <td align="center"><a href="frmCerrarSesionUsuario.php" target="_parent">Salir</a></td>
      </tr>
  </table></td>
  </tr>
</table>
</body></html><?php require 'frmComplementos/Key.php';?>