<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
$busqueda = isset($_POST['cadena']) && is_scalar($_POST['cadena']) ? trim((string)$_POST['cadena']) : '';
$busqueda_SQL = mysql_real_escape_string($busqueda);
$CONT = 0;
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
	  $res=mysql_query("select * from contribuyentes where DOC_IDENTIDAD LIKE '$busqueda_SQL%' and ESTADO='ACTIVO' limit 3");
		
	  while($row=mysql_fetch_array($res)){ 
	  ?>
    <tr>
      <td><?php $CONT++; echo $CONT; ?></td>
      <td><?php if($row['DOC_IDENTIDAD_ALFA']== null){echo htmlspecialchars($row['DOC_IDENTIDAD'].' '.$row['EXPEDIDO'], ENT_QUOTES, 'UTF-8');}else{echo htmlspecialchars($row['DOC_IDENTIDAD'].' - '.$row['DOC_IDENTIDAD_ALFA'].' '.$row['EXPEDIDO'], ENT_QUOTES, 'UTF-8');} ?></td>
      <td><?php if($row['APELLIDO_ESPOSO']== null){echo htmlspecialchars($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'], ENT_QUOTES, 'UTF-8');}else{echo htmlspecialchars($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'].' de '.$row['APELLIDO_ESPOSO'], ENT_QUOTES, 'UTF-8');} ?></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
  </tfoot>
  <tfoot>
  </tfoot>
</table>
<? require '../Conexion_BD/Cerrar_Dbms.php';?>