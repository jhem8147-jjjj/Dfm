<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
//Recogemos la cadena
$busqueda=$_POST['cadena'];
?>

<p style="font-weight: bold">REGISTRO DE CONTRIBUYENTES ENCONTRADOS</p>
<hr />
<table id="example" class="table table-striped table-bordered" style="width:100%;">
  <thead>
    <tr>
      <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">No. DE DOCUMENTO</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Nombre(s) y Apellido(s)</td>
    </tr>
  </thead>
  <tbody>
    <?php 
	  		   //liquida la gestion seleccionada
	  $res=mysql_query("select * from contribuyentes where  DOC_IDENTIDAD LIKE '$busqueda%' and ESTADO='ACTIVO' limit 3");
		
	  while($row=mysql_fetch_array($res)){ 
	  ?>
    <tr>
      <td><?php $CONT++; echo $CONT; ?></td>
      <td><?php if($row['DOC_IDENTIDAD_ALFA']== null){echo $row['DOC_IDENTIDAD'].' '.$row['EXPEDIDO'];}else{echo $row['DOC_IDENTIDAD'].' - '.$row['DOC_IDENTIDAD_ALFA'].' '.$row['EXPEDIDO'];} ?></td>
      <td><?php if($row['APELLIDO_ESPOSO']== null){echo $row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'];}else{echo $row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'].' de '.$row['APELLIDO_ESPOSO'];} ?></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
  </tfoot>
  <tfoot>
  </tfoot>
</table>
<? require '../Conexion_BD/Cerrar_Dbms.php';?>