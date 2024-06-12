<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
header('Pragma: public'); 
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past    
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1 
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1 
header('Pragma: no-cache'); 
header('Expires: 0'); 
header('Content-Transfer-Encoding: none'); 
header('Content-Type: application/vnd.ms-excel'); // This should work for IE & Opera 
header('Content-type: application/x-msexcel'); // This should work for the rest 
header('Content-Disposition: attachment; filename="Listado.xls"');
//echo 'xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"';
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><?php echo $ASOCIACION;?></strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"  bgcolor="#DDDDDD"><strong>No.</strong></td>
        <td align="center"  bgcolor="#DDDDDD"><strong>COMPROBANTE</strong></td>
        <td align="center"  bgcolor="#DDDDDD"><strong>FECHA</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>No DE DOCUMENTO</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>NOMBRE(S) Y APELLIDO(S)</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>ACTIVIDAD</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>CODIGO 1</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>DESCRIPCION</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>IMPORTE (Bs.-)</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>CODIGO 2</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>DESCRIPCION</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>IMPORTE (Bs.-)</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>CODIGO 3</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>DESCRIPCION</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>IMPORTE (Bs.-)</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>IMPORTE TOTAL (BS.-)</strong></td>
        <td align="center" bgcolor="#DDDDDD"><strong>OBSERVACIONES</strong></td>
      </tr>
      <?php $cont=0;$res=mysql_query("select * from reg_contribuyente_asociacion_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and  CODIGO_REGISTRO='$COD_REGISTRO' and ESTADO='ACTIVO'");
while($rows=mysql_fetch_array ($res)){ 
?>
      <tr>
        <td><?php $cont++;echo $cont;?></td>
        <td><?php echo $rows['NRO_COMPROBANTE'];?></td>
        <td><?php echo $rows['FECHA_IMPRESION'];?></td>
        <td><?php echo $rows['CEDULA_IDENTIDAD'];?></td>
        <td><?php echo $rows['CONTRIBUYENTE'];?></td>
        <td><?php echo $rows['ACTIVIDAD'];?></td>
        <td><?php echo $rows['CODIGO_CUENTA1'];?></td>
        <td><?php echo $rows['DESCRIPCION_1'].', '.$rows['GLOSA_DESCRIPCION_1'];?></td>
        <td><strong><?php echo $rows['TOTAL1'];$TOTAL1=$TOTAL1+$rows['TOTAL1'];?></strong></td>
        <td><?php if($rows['CODIGO_CUENTA2']==''){echo '-------';}else{echo $rows['CODIGO_CUENTA2'];}?></td>
        <td><?php if($rows['CODIGO_CUENTA2']==''){echo '-------';}else{echo $rows['DESCRIPCION_2'].' '.$rows['DESCRIPCION_2_1'];}?></td>
        <td><strong><?php echo $rows['TOTAL2'];$TOTAL2=$TOTAL2+$rows['TOTAL2'];?></strong></td>
        <td><?php echo $rows['CODIGO_CUENTA3'];?></td>
        <td><?php echo $rows['DESCRIPCION_3'];?></td>
        <td><strong><?php echo $rows['TOTAL3'];$TOTAL3=$TOTAL3+$rows['TOTAL3'];?></strong></td>
        <td><strong><?php echo $rows['TOTAL'];$TOTAL=$TOTAL+$rows['TOTAL'];?></strong></td>
        <td><?php echo $rows['ESTADO_PAGO']; $COD_ZONA=$rows['CODIGO_ZONA']?></td>
      </tr>
      <?php }  ?>
      <tr>
        <td colspan="8" align="right" bgcolor="#DDDDDD"><strong>TOTAL Bs.-</strong></td>
        <td align="center" bgcolor="#DDDDDD"><?php echo $TOTAL1;?></td>
        <td align="center" bgcolor="#DDDDDD">&nbsp;</td>
        <td align="center" bgcolor="#DDDDDD">&nbsp;</td>
        <td align="center" bgcolor="#DDDDDD"><?php echo $TOTAL2;?></td>
        <td align="center" bgcolor="#DDDDDD">&nbsp;</td>
        <td align="center" bgcolor="#DDDDDD">&nbsp;</td>
        <td align="center" bgcolor="#DDDDDD"><?php echo $TOTAL3;?></td>
        <td align="center" bgcolor="#DDDDDD"><?php echo $TOTAL;?></td>
        <td align="center" bgcolor="#DDDDDD">&nbsp;</td>
      </tr>
      <?php 
	  //REGISTRA EN TRANSACCIONES
$CODIGO_TRANSACCION=date('Ymd His').rand(1,10);
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,CODIGO_ZONA,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_TRANSACCION','$COD_ASOCIACION','$ASOCIACION','$COD_ZONA','LISTADO DE PAGO','GENERACION DE LISTADO DE PAGO DE ($cont) CONTRIBUYENTES','GENERACION DE LISTADO DE PAGO DE ($cont) CONTRIBUYENTES','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");

	   require '../Conexion_BD/Cerrar_Dbms.php'; ?>
    </table></td>
  </tr>
</table>
