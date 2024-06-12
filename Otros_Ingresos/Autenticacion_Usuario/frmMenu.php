<?php require'../Control_Sesiones_Forms/frmControlSesionUsuario.php';require '../Conexion_BD/Dbms_Usuario.php'; ?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>.:: GAMEA - GREMIALES ::.</title><meta name="viewport" content="width=device-width, initial-scale=1.0" />    <link href='skins/page.css' rel="stylesheet" />    <link href="skins/light/accordion-menu.css" rel="stylesheet" />    <script src="accordion-menu.js"></script><style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCC;
}
</style></head><body><table width="100%" border="0" cellpadding="0" cellspacing="0">  <tr>    <td align="center" bgcolor="#FFCC00" background="../Img/fondo-amarillo-lineas-zoom-comico_1017-15136.jpg"><img src="../Img/gamea.png" style='max-height:123;'></td>  
</tr>  <tr>    <td align="center" bgcolor="#FFCC00" style="color: #fff; font-weight: bold; font-size: 11px;" background="../Img/fondo-amarillo-lineas-zoom-comico_1017-15136.jpg"><?php echo $SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO;?></td>  
  </tr>
<tr>
  <td align="center" bgcolor="#FFCC00" style="color: #fff; font-weight: bold; font-size: 11px;" background="../Img/fondo-amarillo-lineas-zoom-comico_1017-15136.jpg">&nbsp;</td>
</tr>
</table>
<div id="accordion"> 
<ul>
 <?php $roles=mysql_query("select distinct(MS.GRUPO) from asignacion_roles AS AR INNER JOIN  menu_oi AS MS ON( AR.CODIGO_ROL=MS.CODIGO_ROL AND AR.ESTADO='VIGENTE' AND AR.USUARIO='$US_SIOI' and AR.APLICACION='SIOI') order by MS.SIGLA");while($rows=mysql_fetch_array($roles)){?>
<li>
	<div><?php echo $rows[0];?>
	</div>
<ul> 
	<?php  $rol=mysql_query("select MS.DESCRIPCION, MS.ENLACE, MS.POSICION from asignacion_roles AS AR INNER JOIN  menu_oi AS MS ON(MS.GRUPO='$rows[0]' and AR.CODIGO_ROL=MS.CODIGO_ROL AND AR.ESTADO='VIGENTE' AND AR.USUARIO='$US_SIOI' and MS.ESTADO='ACTIVO' ) order by MS.DESCRIPCION");while($row=mysql_fetch_array($rol)){ ?><li><a href="<?php echo $row['1'];?>" target="<?php echo $row['2'];?>"><?php echo $row['0'];?></a></li><?php } ?></ul>
</li><?php } ?>
</ul>
</div>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>