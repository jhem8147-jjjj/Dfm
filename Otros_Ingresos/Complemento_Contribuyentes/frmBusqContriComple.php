<?php 
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
//Recogemos la cadena
$busqueda=$_POST['cadena'];
?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
</style>

<table id="example" class="table table-striped table-bordered" style="width:100%;">
  <thead>
    <tr>
      <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">No. DE DOCUMENTO</td>
      <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Nombre(s) y Apellido(s)</td>
      <td align="center" style="font-weight: bold">&nbsp;</td>
    </tr>
  </thead>
  <tbody>
    <?php 
	  		   //liquida la gestion seleccionada
	  $res=mysql_query("select * from contribuyentes where  DOC_IDENTIDAD LIKE '$busqueda%' and ESTADO='ACTIVO' LIMIT 3");
		
	  while($row=mysql_fetch_array($res)){ 
	  ?>
    <tr>
      <td bgcolor="#E3EEEE"><?php $CONT++; echo $CONT; ?></td>
      <td bgcolor="#E3EEEE"><?php if($row['DOC_IDENTIDAD_ALFA']== null){echo $row['DOC_IDENTIDAD'].' '.$row['EXPEDIDO'];}else{echo $row['DOC_IDENTIDAD'].' - '.$row['DOC_IDENTIDAD_ALFA'].' '.$row['EXPEDIDO'];} ?></td>
      <td bgcolor="#E3EEEE"><?php if($row['APELLIDO_ESPOSO']== null){echo utf8_decode($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO']);}else{echo utf8_decode($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'].' de '.$row['APELLIDO_ESPOSO']);}  ?></td>
      <td><table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17%"><img src="../Img/Validar.png" width="35" height="27" /></td>
          <td width="83%"><a href="frmComplementacion2.php?CODIGO_CONTRIBUYENTE=<?php echo $row['CODIGO_CONTRIBUYENTE'];?>&REGISTRAR=1" title="SELECCIONAR CONTRIBUYENTE">Asociar</a></td>
        </tr>
      </table></td>
    </tr> <?php } ?>
    <tr><?php if($CONT==0){?>
      <td align="right"><img src="../Img/Exit-Page.png" width="20" height="20" /></td>
      <td bgcolor="#FFF3D9">NUMERO DE IDENTIFICACION NO REGISTRADO</td>
      <td bgcolor="#FFF3D9">NOMBRE(S)Y APELLIDO(S) NO REGISTRADO(S)</td>
      <td><table width="100%" border="0">
        <tr>
          <td width="8%"><img src="../Img/Agregar.png" width="25" height="25" /></td>
          <td width="92%"><a href="frmRegistrarContribuyenteComplemento.php">Registrar Contribuyente</a></td>
        </tr>
      </table></td>
    </tr><?php } ?>
   
  </tbody>
  <tfoot>
  </tfoot>
  <tfoot>
  </tfoot>
</table>
<?php require '../Conexion_BD/Cerrar_Dbms.php';?>