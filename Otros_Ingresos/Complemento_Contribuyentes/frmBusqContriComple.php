<?php 
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
$busqueda = isset($_POST['cadena']) && is_scalar($_POST['cadena']) ? trim((string)$_POST['cadena']) : '';
$busqueda_SQL = mysql_real_escape_string($busqueda);
$camposContexto = array('COD_REGISTRO', 'CODIGO_ZONA_TRIB', 'COD_ASOCIACION', 'ASOCIACION', 'OMS', 'txtCodigoRegistro', 'txtDocumento', 'txtFecha', 'txtObservaciones', 'sltGestion');
$valoresContexto = array();
foreach ($camposContexto as $campoContexto) {
    if (isset($_POST[$campoContexto]) && is_scalar($_POST[$campoContexto]) && (string)$_POST[$campoContexto] !== '') {
        $valoresContexto[$campoContexto] = (string)$_POST[$campoContexto];
    } elseif (isset($_SESSION[$campoContexto]) && is_scalar($_SESSION[$campoContexto])) {
        $valoresContexto[$campoContexto] = (string)$_SESSION[$campoContexto];
    } else {
        $valoresContexto[$campoContexto] = '';
    }
}
$CONT = 0;
?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
button.link-submit {
	background: none;
	border: 0;
	padding: 0;
	color: #F60;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	cursor: pointer;
}
button.link-submit:hover {
	color: #FC0;
	text-decoration: underline;
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
	  $res=mysql_query("select * from contribuyentes where DOC_IDENTIDAD LIKE '$busqueda_SQL%' and ESTADO='ACTIVO' LIMIT 3");
		
	  while($row=mysql_fetch_array($res)){ 
	  ?>
    <tr>
      <td bgcolor="#E3EEEE"><?php $CONT++; echo $CONT; ?></td>
      <td bgcolor="#E3EEEE"><?php if($row['DOC_IDENTIDAD_ALFA']== null){echo htmlspecialchars($row['DOC_IDENTIDAD'].' '.$row['EXPEDIDO'], ENT_QUOTES, 'UTF-8');}else{echo htmlspecialchars($row['DOC_IDENTIDAD'].' - '.$row['DOC_IDENTIDAD_ALFA'].' '.$row['EXPEDIDO'], ENT_QUOTES, 'UTF-8');} ?></td>
      <td bgcolor="#E3EEEE"><?php if($row['APELLIDO_ESPOSO']== null){echo htmlspecialchars($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'], ENT_QUOTES, 'UTF-8');}else{echo htmlspecialchars($row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'].' de '.$row['APELLIDO_ESPOSO'], ENT_QUOTES, 'UTF-8');}  ?></td>
      <td><table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17%"><img src="../Img/Validar.png" width="35" height="27" /></td>
          <td width="83%">
            <form method="post" accept-charset="UTF-8" action="frmComplementacion2.php">
              <input type="hidden" name="REGISTRAR" value="1" />
              <input type="hidden" name="CODIGO_CONTRIBUYENTE" value="<?php echo htmlspecialchars($row['CODIGO_CONTRIBUYENTE'], ENT_QUOTES, 'UTF-8'); ?>" />
              <?php foreach ($camposContexto as $campoContexto) { ?>
                <input type="hidden" name="<?php echo $campoContexto; ?>" value="<?php echo htmlspecialchars($valoresContexto[$campoContexto], ENT_QUOTES, 'UTF-8'); ?>" />
              <?php } ?>
              <button class="link-submit" type="submit" title="SELECCIONAR CONTRIBUYENTE">Asociar</button>
            </form>
          </td>
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