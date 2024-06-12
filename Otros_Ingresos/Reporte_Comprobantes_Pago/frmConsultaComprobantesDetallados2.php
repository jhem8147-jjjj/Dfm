<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');require '../Conexion_BD/Dbms.php';
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
    <td align="center"><span class="TITULO" style="font-weight: bold">REPORTE COMPROBANTE DE PAGO DETALLADO</span></td>
  </tr>
  <tr>
    <td align="center"><span class="SUBTITULO">Comprobante(s) de Pago(s) Desde el Nro. <?php echo $RANGO1;?> Hasta el  Nro. <?php echo $RANGO2;?></span></td>
  </tr>
  <tr>
    <td><table border="1" class="table table-striped table-bordered" id="example" style="width:100%;">
      <thead>
        <tr bgcolor="#CCCCCC">
          <td height="27" align="center" style="font-weight: bold">No.</td>
          <td align="center" style="font-weight: bold">FECHA Y HORA</td>
          <td align="center" style="font-weight: bold">No. DE COMPROBANTE</td>
          <td align="center" style="font-weight: bold">ASOCIACION</td>
          <td align="center" style="font-weight: bold">CONTRIBUYENTE</td>
          <td align="center" style="font-weight: bold">ACTIVIDAD</td>
          <td align="center" style="font-weight: bold">CODIGO CUENTA 1</td>
          <td align="center" style="font-weight: bold">DESCRIPCION 1</td>
          <td align="center" style="font-weight: bold">TOTAL CUENTA 1</td>
          <td align="center" style="font-weight: bold">CODIGO CUENTA 2</td>
          <td align="center" style="font-weight: bold">DESCRIPCION 2</td>
          <td align="center" style="font-weight: bold">TOTAL CUENTA 2</td>
          <td align="center" style="font-weight: bold">CODIGO CUENTA 3</td>
          <td align="center" style="font-weight: bold">DESCRIPCION 3</td>
          <td align="center" style="font-weight: bold">TOTAL CUENTA 3</td>
          <td align="center" style="font-weight: bold">TOTAL Bs.-</td>
          <td align="center" style="font-weight: bold">ESTADO PAGO</td>
        </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select * from reg_contribuyente_asociacion_pago where NRO_COMPROBANTE BETWEEN $RANGO1 AND $RANGO2"); while($row=mysql_fetch_array($result)){ ?>
        <tr>
          <td><?php $CONT++; echo $CONT; ?></td>
          <td><?php echo $row['FECHA'].' Hrs. '.$row['HORA']; ?></td>
          <td><?php echo $row['NRO_COMPROBANTE']; ?></td>
          <td align="left"><?php echo $row['ASOCIACION']; ?></td>
          <td align="left"><?php echo $row['CONTRIBUYENTE']; ?></td>
          <td align="left"><?php echo $row['ACTIVIDAD']; ?></td>
          <td align="left" ><?php echo $row['CODIGO_CUENTA1']; ?></td>
          <td align="left" ><?php echo $row['DESCRIPCION_1'].' - '.$row['GLOSA_DESCRIPCION_1']; ?></td>
          <td align="left" ><?php echo $row['TOTAL1']; ?></td>
          <td align="left" ><?php echo $row['CODIGO_CUENTA2']; ?></td>
          <td align="left" ><?php echo $row['DESCRIPCION_2'].' - '.$row['GLOSA_DESCRIPCION_2_1']; ?></td>
          <td align="left" ><?php echo $row['TOTAL2']; ?></td>
          <td align="left" ><?php echo $row['CODIGO_CUENTA3']; ?></td>
          <td align="left" ><?php echo $row['DESCRIPCION_3'];?></td>
          <td align="left" ><?php echo $row['TOTAL3']; ?></td>
          <td align="left" ><?php echo $row['TOTAL']; ?></td>
          <td align="left"><?php echo $row['ESTADO_PAGO']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr>
</table>