<?php require'../Control_Sesiones_Forms/frmControlSesionUsuario.php';require '../Conexion_BD/Dbms_Usuario.php'; ?><!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>.:: GAMEA - GREMIALES ::.</title><meta name="viewport" content="width=device-width, initial-scale=1.0" />    <link href='skins/page.css' rel="stylesheet" />    <link href="skins/light/accordion-menu.css" rel="stylesheet" />    <script src="accordion-menu.js"></script><style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCC;
}
</style></head><body><table width="100%" border="0" cellpadding="0" cellspacing="0">  <tr>    <td align="center" bgcolor="#FFCC00" background="../Img/fondo-amarillo-lineas-zoom-comico_1017-15136.jpg">
	<img src="../Img/gamea.png" style='max-height:123;'></td>  
</tr>  <tr>    <td align="center" bgcolor="#FFCC00" style="color: #fff; font-weight: bold; font-size: 11px;" background="../Img/fondo-amarillo-lineas-zoom-comico_1017-15136.jpg"><?php echo $SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO;?></td>  
  </tr>
<tr>
  <td align="center" bgcolor="#FFCC00" style="color: #fff; font-weight: bold; font-size: 11px;" background="../Img/fondo-amarillo-lineas-zoom-comico_1017-15136.jpg">&nbsp;</td>
</tr>
</table>
<div id="accordion"> 
<ul>
 <?php $roles=mysql_query("select distinct(case when MS.ENLACE like '%Desimportacion_Masiva_Impuesto_Anual%' or (MS.DESCRIPCION like '%Inhabilitar%' and MS.DESCRIPCION like '%Contribuyente%') then 'Contribuyente' else MS.GRUPO end) as GRUPO from asignacion_roles AS AR INNER JOIN menu_oi AS MS ON(AR.CODIGO_ROL=MS.CODIGO_ROL AND AR.ESTADO='VIGENTE' AND AR.USUARIO='$US_SIOI' and AR.APLICACION='SIOI') where MS.ESTADO='ACTIVO' order by GRUPO");while($rows=mysql_fetch_array($roles)){?>
<li>
	<div><?php echo htmlspecialchars(strtoupper($rows['GRUPO']), ENT_QUOTES, 'UTF-8');?>
	</div>
<ul> 
	<?php  $grupo=mysql_real_escape_string($rows['GRUPO']); $rol=mysql_query("select MS.DESCRIPCION, MS.ENLACE, MS.POSICION from asignacion_roles AS AR INNER JOIN menu_oi AS MS ON(AR.CODIGO_ROL=MS.CODIGO_ROL AND AR.ESTADO='VIGENTE' AND AR.USUARIO='$US_SIOI' and MS.ESTADO='ACTIVO') where (case when MS.ENLACE like '%Desimportacion_Masiva_Impuesto_Anual%' or (MS.DESCRIPCION like '%Inhabilitar%' and MS.DESCRIPCION like '%Contribuyente%') then 'Contribuyente' else MS.GRUPO end)='$grupo' order by case when '$grupo'='Contribuyente' and MS.DESCRIPCION like '%Importar%' then 1 when '$grupo'='Contribuyente' and MS.DESCRIPCION like '%Validaci%' then 2 when MS.ENLACE like '%Desimportacion_Masiva_Impuesto_Anual%' or (MS.DESCRIPCION like '%Inhabilitar%' and MS.DESCRIPCION like '%Contribuyente%') then 3 else 4 end, MS.DESCRIPCION");while($row=mysql_fetch_array($rol)){ ?><li><a href="<?php echo $row['1'];?>" target="<?php echo $row['2'];?>"><?php echo $row['0'];?></a></li><?php } ?></ul>
</li><?php } ?>
</ul>
</div>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>