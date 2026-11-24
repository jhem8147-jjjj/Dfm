<?php
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
// Obtenemos y traducimos el nombre del mes
$mes=date("F");
if ($mes=="January") $mes="Enero";
if ($mes=="February") $mes="Febrero";
if ($mes=="March") $mes="Marzo";
if ($mes=="April") $mes="Abril";
if ($mes=="May") $mes="Mayo";
if ($mes=="June") $mes="Junio";
if ($mes=="July") $mes="Julio";
if ($mes=="August") $mes="Agosto";
if ($mes=="September") $mes="Setiembre";
if ($mes=="October") $mes="Octubre";
if ($mes=="November") $mes="Noviembre";
if ($mes=="December") $mes="Diciembre";
// Obtenemos el número del día
$dia2=date("d");
// Obtenemos el año
$ano=date("Y");
$HOY_ES=$dias[date('w')]." $dia2  $mes del $ano";
$FECHA=date('d-m-Y H:i:s');
$FECHAS=date('d-m-Y');
$GESTION=date('Y');
include('../../../../../../Connections/conexion_fiscalizacion.php');
$result=mysql_query("select MAX(FITM) from genera_nro_fitm_inm ");
		if($fila=mysql_fetch_array($result)){
		$NRO_INFORME=$fila[0]+1;
		$NRO_INFORMES=$fila[0];
		$CODIGO_INFORME= "$NRO_INFORME-$GESTION";}
		$query = mysql_query("UPDATE genera_nro_fitm_inm SET USUARIO='$US_SIAT', FITM='$NRO_INFORME', FECHA='$FECHA' WHERE FITM='$NRO_INFORMES'")or die ("NO SE PUDO ACTUALIZAR"); 
		
$GUARDAR="FITM-INM-$NRO_INFORME-$GESTION.html";
$_SESSION['GUARDADO']=$GUARDAR;
$sql1="insert into
crea_form_fitm_inmuebles (USUARIO,AUTOR,HOSTNAME,HOSTLOCAL,FECHA_CREACION,FITM,HOJA_RUTA,REG_TRIBUTARIO,NRO_PROCESO,PROCESO,DESCRIPCION,ESTADO)values('$US_SIAT','$NOMBRES_SIAT $AP_PATERNO_SIAT $AP_MATERNO_SIAT','$hostname_sis','$hostlocal_sis','$FECHA','FITM-INM-$CODIGO_INFORME','$HOJA_RUTA','$REG_TRIBUTARIO','$ORDEN','$PROCESO','FORMULARIO CREADO POR : $NOMBRES_SIAT $AP_PATERNO_SIAT $AP_MATERNO_SIAT','CREADO FORMULARIO')";
$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR LOS DATOS EN LA ENTIDAD CREA FITM INMUEBLES");
$sql1="insert into fitm_inmuebles (FITM,REG_TRIBUTARIO,CONTRIBUYENTE,DIRECCION_LEGAL,DIRECCION_INMUEBLE,NOTIFICACION,FECHA_NOTIFICACION,ENLACE,ESTADO)values('FITM-INM-$CODIGO_INFORME','$REG_TRIBUTARIO','$CONTRIBUYENTE','$CALLE_CONT $NRO_CONT - $ZONA_CONT','$CALLE_INM $NRO_INM - $ZONA_INM','$NOTIFICACION','$FECHA_NOTIFICACION','$GESTION/$GUARDAR','ORMULARIO CREADO POR : $NOMBRES_SIAT $AP_PATERNO_SIAT $AP_MATERNO_SIAT')";
$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR LOS DATOS EN LA ENTIDAD CREA FITM INMUEBLES");
include('../../../../../../Connections/cerrar_conexion.php');

?>
<?php
$strhtm = "
<html lang=es>
<head>
<meta charset=utf-8/>
<title>$US_SIAT-$GUARDAR</title>
<style type=\"text/css\">
<!--
body {
	margin-left: 1cm;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo3 {font-size: 12px; font-weight: bold; font-style: italic; }
body {
	background-image: url(../../../../../../../Img/Notebook.jpg);
}
.Estilo8 {font-size: 10px; font-style: italic; }
-->
</style><meta http-equiv=Content-Type content=text/html; charset=utf-8 charset=utf-8>
<style type=\"text/css\">
<!--
.Estilo1 {font-size: 10px}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><style type=\"text/css\">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo2 {
	font-size: 7px;
	font-weight: bold;
}
-->
</style>
<style type=\"text/css\">
<!--
.Estilo2 {font-size: 9px}
-->
</style>
<style type=\"text/css\">
<!--
.Estilo2 {
	font-size: 15px;
	font-weight: bold;
}
-->
</style>
<style type=\"text/css\">
<!--
.Estilo3 {font-size: 10px}
-->
</style>
<style type=\"text/css\">
<!--
.Estilo3 {
	font-size: 15px;
	font-weight: bold;
}
-->
</style>
</head>

<body onload=\"javascript:print();\" >
<table width=100% border=0>
  <tr>
    <td><div align=\"center\">
      <table width=100% border=\"0\">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align=\"center\" class=\&quot;Estilo2\&quot; Estilo3>INFORMACION TRIBUTARIA MUNICIPAL</div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width=\"86%\">&nbsp;</td>
          <td width=\"14%\">&nbsp;</td>
        </tr>
        <tr>
          <td><div align=\"center\">$CONTRIBUYENTE</div></td>
          <td><div align=\"center\"><span class=\&quot;Estilo2\&quot; Estilo3>$US_SIAT</span></div></td>
        </tr>
                <tr>
          <td><div align=\"center\">ORDEN DE FISCALIZACION Nº $ORDEN </div></td>
          <td><img src=\"../FORMULARIO-ITM-2012.PNG\" width=\"160\" height=\"20\"></td>
        </tr>
        <tr>
          <td><div align=\"center\">$PROCESO</div></td>
          <td><div align=\"CENTER\" class=\&quot;Estilo2\&quot; Estilo3>ITM-$CODIGO_INFORME</div></td>
        </tr>
        <tr>
          <td><div align=\"center\">$ETAPA/$NRO_ETAPA </div></td>
          <td><div align=\"CENTER\" class=\&quot;Estilo2\&quot; Estilo3>$HOJA_RUTA</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td><div align=\"center\"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Domicilio Legal: $CALLE_CONT, Nº. $NRO_CONT - $ZONA_CONT. </td>
  </tr>
  <tr>
    <td>Inmueble Fiscalizado: $CALLE_INM, $NRO_INM - $ZONA_INM.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>A fecha $HOY_ES. </td>
  </tr>
  <tr>
    <td><div align=\"justify\"></div></td>
  </tr>
  <tr>
    <td><em>$editor_office2003</em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>";

$archivo = fopen("$GESTION/$GUARDAR", "w");
fwrite($archivo, $strhtm);
fclose($archivo);
?>
<html>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<body onLoad="MM_goToURL('self','CargarImprimir.php');return document.MM_returnValue">
<a href="file:///C|/AppServ/www/DRyPT/Sif/Conex_Dbms/Index.php">ffff</a>
</body>
</html><?php include('../../../../../../Connections/cerrar_conexion.php');?>

