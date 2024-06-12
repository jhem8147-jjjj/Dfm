<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
if(empty($_SESSION['COD_REGISTRO'])){
echo"<script> location.href='frmCambioNombre.php';</script>";	
	}else{$_SESSION['COD_REGISTRO']=$COD_REGISTRO;}
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_REGISTRO']=$COD_REGISTRO;
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['txtDocumento']=$txtDocumento;
$_SESSION['txtFecha']=$txtFecha;
$_SESSION['txtObservaciones']=$txtObservaciones;
$_SESSION['sltGestion']=$sltGestion;

if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['OMS'])){include_once("Index.php");}
if(empty($_SESSION['COD_REGISTRO'])){include_once("Index.php");}
if(empty($_SESSION['txtDocumento'])){include_once("Index.php");}
if(empty($_SESSION['txtFecha'])){include_once("Index.php");}
if(empty($_SESSION['txtObservaciones'])){include_once("Index.php");}
if(empty($_SESSION['sltGestion'])){include_once("Index.php");}

unset($_SESSION['CODIGO_CONTRIBUYENTE'],$_SESSION['NUMERO_GREMIAL'],$_SESSION['TIPO_CAMBIO']);
//BUSCA LAS GESTIONES PAGADOS HABILITADOS.
$GESTION_BUSQUEDA=date('Y')-2;
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
</head>
<form method="post" action="frmCambioNombre3.php">
<body>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO">CAMBIO DE NOMBRE</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">PAGO DE CONTRIBUYENTES REALIZADOS</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Datos de Solicitud.</td>
      </tr>
      <tr>
        <td style="font-weight: bold"><table width="100%" border="0" bordercolor="#FFFFFF">
                 <tr>
                   <td height="32" colspan="2" align="right"><img src="../Img/Linea.png" width="1000" height="2" /></td>
                 </tr>
                 <tr>
                   <td height="32" align="right" bgcolor="#CCCCCC">Gestión Seleccionada :</td>
                   <td style="font-weight: bold"><?php echo $sltGestion; ?></td>
                 </tr>
                 <tr>
                   <td height="32" align="right" bgcolor="#CCCCCC">Documento :</td>
                   <td style="font-weight: bold"><?php echo $txtDocumento; ?></td>
                 </tr>
                 <tr>
                   <td height="32" align="right" bgcolor="#CCCCCC">Fecha Documento :</td>
                   <td style="font-weight: bold"><?php echo $txtFecha; ?></td>
                 </tr>
                 <tr>
                   <td height="32" align="right" bgcolor="#CCCCCC">Observaciones Documento :</td>
                   <td style="font-weight: bold"><?php echo $txtObservaciones; ?></td>
                 </tr>
                 <tr>
                   <td height="32" colspan="2" align="left">Asociacion Seleccionado.</td>
              </tr>
                 <tr>
          <td  colspan="2" align="right"><hr /></td>
          </tr>
       <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
          </tr>
          <tr>
            <td width="33%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="67%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>          
            </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC"> GestIón  de Pago Realizado :</td>
            <td style="font-weight: bold"><?php echo $GESTION_BUSQUEDA;?>              
          </tr>
          <?php }?>
        </table></td>
      </tr>
      <tr>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Contribuyentes Afiliados.</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
          <thead>
            <tr style="font-weight: bold">
              <td height="70" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC">No. DE DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
              <td align="center" bgcolor="#CCCCCC">CONCEPTO</td>
              <td align="center" bgcolor="#CCCCCC">GESTION DE COBRO</td>
              <td align="center" bgcolor="#CCCCCC">ACTIVIDAD</td>
              <td align="center">&nbsp;</td>
              </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  * from reg_contribuyente_asociacion_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and DESCRIPCION_1='PATENTE EVENTUAL EN DOMINIO PUBLICO' and GLOSA_DESCRIPCION_1 like'%$GESTION_BUSQUEDA%' order by CONTRIBUYENTE");
		  	  while($row=mysql_fetch_array($res)){ 
	 	  $SW2=1;?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
              <td><?php echo $row['CEDULA_IDENTIDAD']; ?></td>
              <td><?php echo $row['CONTRIBUYENTE']; ?></td>
              <td><?php echo $row['DESCRIPCION_1']; ?></td>
              <td><?php echo $row['GLOSA_DESCRIPCION_1']; ?></td>
              <td><?php echo $row['ACTIVIDAD']; ?></td>
              <td><table width="100%" border="0">
                <tr>
                  <td width="14%"><img src="../Img/512x512.png" width="32" height="32" /></td>
                  <td width="86%"><?php  $MENSAJE=''; $SW=0;$rest=mysql_query("select  * from reg_contribuyente_habilitado_pago_cambio_nombre where CODIGO_ASOCIACION='$COD_ASOCIACION' and REGISTRO_GREMIAL='$row[REGISTRO_GREMIAL]' and CODIGO_CONTRIBUYENTE_SALIENTE='$row[CODIGO_CONTRIBUYENTE]' and (ESTADO='ACTIVO' or ESTADO='PAGADO')");
		  	  while($rows=mysql_fetch_array($rest)){$SW=1; $MENSAJE='CAMBIO DE NOMBRE REALIZADO PARA LA GESTION '.($GESTION_BUSQUEDA+1);} if($SW==0){?><a href="frmCambioNombre2.php?GESTION_BUSQUEDA=<?php echo $GESTION_BUSQUEDA;?>&NUMERO_GREMIAL=<?php echo $row['REGISTRO_GREMIAL'];?>&CODIGO_CONTRIBUYENTE=<? echo $row['CODIGO_CONTRIBUYENTE'];?>&CODIGO_REGISTRO=<? echo $row['CODIGO_REGISTRO'];?>" title="MODIFICAR DATOS DE CONTRIBUYENTE">Cambiar Afiliado</a></td>
                  <?php } else{ echo $MENSAJE;} ?></tr>
              </table></td>
              </tr>
            <?php } ?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td align="center"><input name="CAMBIO_AFILIADOS" type="hidden" id="CAMBIO_AFILIADOS" value="<?php echo $CAMBIO_AFILIADOS;?>" />
          <input type="submit" name="button" id="button" value="Siguiente" style="width:200px; height:35px"  /></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 3</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body></form>
</html><?php //unset($_SESSION['GESTION_BUSQUEDA'],$_SESSION['CODIGO_CONTRIBUYENTE'],$_SESSION['NUMERO_GREMIAL'],$_SESSION['MONTOS'],$_SESSION['TIPO_PUESTOS'],$_SESSION['PUESTOS'],$_SESSION['CODIGO_ZONAS'],$_SESSION['FILAS']);require  '../Seguridad/Key.php';?><?php  require '../Conexion_BD/Cerrar_Dbms.php';
 if($cont==0){echo"<script> alert('No Existe Pago(s) de Impuesto(s) por la Gestión: $GESTION_BUSQUEDA.');</script>";
	echo"<script> location.href='frmCambioNombre.php';</script>";}?>