<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION; 
$_SESSION['ORDENANZA_MUNICIPAL']=$ORDENANZA_MUNICIPAL;
$_SESSION['sltGestion']=$sltGestion;
 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<form  method="post" action='frmComprobantePago3.php'>
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO"><?php 
    $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); 
    while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Validacion de Nombre(s) de Contribuyente(s) y Datos(s) Puesto(s) y Fila(s)</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Asociación.</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo $ORDENANZA_MUNICIPAL;?></td>
      </tr>
      <tr>
        <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="68%" style="font-weight: bold"><?php echo $ASOCIACION;?>
          <input name="txtSw" type="hidden" id="txtSw" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Gestión Seleccionada :</td>
        <td ><span style="font-weight: bold"><?php echo $sltGestion;?></span></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="1" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><span style="font-weight: bold">Resultados de Busqueda.
    </span>      <hr /></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="43" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA Y HORA</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">GESTION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO PAGO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO DE REGISTROS</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COMUNICACION INTERNA</td>
          <td align="center" style="font-weight: bold">&nbsp;</td>
        </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select distinct CODIGO_REGISTRO,GESTION,FECHA,HORA,USUARIO,NOMBRE_USUARIO,ESTADO,ESTADO_REGISTRO,COMUNICACION_INTERNA 
        from reg_contribuyente_habilitado_pago 
        where ESTADO='ACTIVO' AND  CODIGO_ASOCIACION='$COD_ASOCIACION' 
        and GESTION='$sltGestion' order by ESTADO_REGISTRO"); while($row=mysql_fetch_array($result)){$SWT=0; ?>
        <tr>
          <td bgcolor="#F4F4F4"><?php $CONT++; echo $CONT; ?></td>
          <td bgcolor="#F4F4F4"><?php echo $row[2].' Hrs. '.$row[3]; ?></td>
          <td bgcolor="#F4F4F4"><?php echo $row[4].' Hrs. '.$row[5]; ?></td>
          <td bgcolor="#F4F4F4"><?php echo $row[1]; ?></td>
          <td bgcolor="#F4F4F4"><?php if($row[6]=='ACTIVO'){echo 'NO PAGADO';}else{echo $row[6];} ?></td>
          <td bgcolor="#F4F4F4"><?php  $results=mysql_query("select count(CODIGO_REGISTRO) from reg_contribuyente_habilitado_pago where CODIGO_REGISTRO='$row[0]' AND ESTADO='ACTIVO' AND  CODIGO_ASOCIACION='$COD_ASOCIACION' and GESTION='$sltGestion' and ESTADO_REGISTRO='$row[7]'"); while($rowts=mysql_fetch_array($results)){ echo '( '.$rowts[0].' ) ';} echo $row[7]; ?></td>
          <td bgcolor="#F4F4F4"><?php echo $row[8]; ?></td>
          <td align="center" style="font-weight: bold"><a href=" frmValidarNombresCont2.php?sltGestion=<?php echo $row[1]; ?>&CODIGO_REGISTRO=<?php echo $row[0]; ?>" ><?php if($row[7]=='NO VALIDADO'){?>VALIDAR REGISTROS<?php }else{echo 'MOSTRAR LISTADO';}?></a></td>
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
  </tr>
  <tr>
    <td align="center"><a href="frmValidarNombresCont.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($CONT==0){
	echo"<script> alert('No Existe Gestiones Habilitados.');</script>";
//	echo"<script> location.href='frmDuplicadoComprobante.php';</script>";
	}?>