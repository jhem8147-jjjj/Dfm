<?php  require '../Conexion_BD/Dbms.php';
//Recogemos la cadena
$busqueda=$_POST['cadena'];
?>

<p style="font-weight: bold">REGISTRO DE ASOCIACION(ES) ENCONTRADO(S)</p>
<table id="example" class="table table-striped table-bordered" style="width:100%;">
  <thead>
    <tr>
      <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DOCUMENTO DE REGISTRO</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO</td>
    </tr>
  </thead>
  <tbody>
    <?php 
	  		   //liquida la gestion seleccionada
	  $res=mysql_query("select * from reg_asociacion where  ORDENANZA_MUNICIPAL LIKE '%$busqueda%' and ESTADO='ACTIVO' limit 3");
		
	  while($row=mysql_fetch_array($res)){ 
	  ?>
    <tr>
      <td bgcolor="#F4F4F4"><?php $CONT++; echo $CONT; ?></td>
      <td bgcolor="#F4F4F4"><?php echo $row['ORDENANZA_MUNICIPAL']; ?></td>
      <td bgcolor="#F4F4F4"><?php echo $row['DESCRIPCION']; ?></td>
      <td bgcolor="#F4F4F4"><?php echo $row['ESTADO']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
  </tfoot>
  <tfoot>
  </tfoot>
</table>
<?php require '../Conexion_BD/Cerrar_Dbms.php';;?>