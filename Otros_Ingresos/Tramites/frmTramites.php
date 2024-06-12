<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">  TRAMITES</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">Tramites</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="font-weight: bold">DATO DE USUARIO Y TRAMITE.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="900" height="19" /></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table width="100%" border="1" bordercolor="#FFFFFF"> 
      <tr>
        <td width="36%" height="32" align="right" bgcolor="#CCCCCC">Usuario :</td>
        <td width="64%" style="font-weight: bold"><?php echo $US_SIOI;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Seleccionar Trámite :</td>
        <td align="left">
        
        
          <form name="form" id="form">
            <select name="jmpTramite" id="jmpTramite" onchange="MM_jumpMenu('self',this,0)" style="width:250px; height:25px"><option>
                Seleccionar...</option>
              <?php $res=mysql_query("select DISTINCT TRANSACCION_1 from reg_contribuyente_transacciones where USUARIO='$US_SIOI' and ESTADO='ACTIVO'"); while($ro=mysql_fetch_array($res)){ $WS=1;?>
              
              <option value="frmTramites.php?TRAMITE_BUSQUEDA=<?php echo $ro['0'];?>&REG=1"><?php echo $ro['0'];?></option>
              <?php } ?>
            </select>
          </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><span style="font-weight: bold">RESULTADOS DE TRAMITES ENCONTRADOS.
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="900" height="19" /></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">TRAMITE</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA Y HORA</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">TRANSACCION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ASOCIACION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
          </tr>
      </thead>
      <tbody>
        <?php 
	  	if($REG==1){
	  $res=mysql_query("select distinct TRANSACCION_1,FECHA,HORA,USUARIO,NOMBRE_USUARIO,DESCRIPCION_TRAMITE,ASOCIACION,CODIGO_REGISTRO,ENLACE,ASOCIACION,CODIGO_ASOCIACION from reg_contribuyente_transacciones where USUARIO='$US_SIOI' and TRANSACCION_1 like '%$TRAMITE_BUSQUEDA%' order by Id desc");
		}else{
$res=mysql_query("select distinct TRANSACCION_1,FECHA,HORA,USUARIO,NOMBRE_USUARIO,DESCRIPCION_TRAMITE,ASOCIACION,CODIGO_REGISTRO,ENLACE,ASOCIACION,CODIGO_ASOCIACION from reg_contribuyente_transacciones where USUARIO='$US_SIOI' order by Id desc");			
			
			}
		
	  while($row=mysql_fetch_array($res)){ 
	  ?>
        <tr>
          <td><?php $CONT++; echo $CONT; ?></td>
          <td><?php echo $row['7'];?></td>
          <td><?php echo $row['1']; ?> Hrs. <?php echo $row['2']; ?></td>
          <td><?php echo $row['3'].' - '.$row['4']; ?></td>
          <td><?php echo $row['0']; ?></td>
          <td><?php echo $row['6']; ?></td>
          <td><?php echo $row['5']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>
<?php  include '../CssTablas/frmPieTabla.php';?>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>