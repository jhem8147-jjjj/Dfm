<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php');
 require '../Conexion_BD/Dbms.php';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<body>
    <table width="10%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="TITULO">&nbsp;</td>
        <td align="center" class="TITULO">&nbsp;</td>
        <td align="center" class="TITULO">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="TITULO">&nbsp;</td>
        <td align="center" class="TITULO">&nbsp;</td>
        <td align="center" class="TITULO">DESCARGAS DE DOCUMENTOS</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">Repositorio de Descargas.</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../Img/Linea_Negra.png" width="800" height="2" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
          <thead>
            <tr style="font-weight: bold">
              <td height="70" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC">FECHA Y HORA</td>
              <td align="center" bgcolor="#CCCCCC">DESCRIPCION</td>
              <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  * from descargas_documentos where  ESTADO='ACTIVO' ");
		  	  while($row=mysql_fetch_array($res)){ 
	 	  $SW2=1;
          $archivoDescarga = basename(str_replace('\\', '/', $row['ARCHIVO']));
	 	  $imagenDescarga = str_replace('/Word.png', '/WORD.png', $row['IMAGEN']);
	 	  ?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
	 	      <td><?php echo htmlspecialchars($row['FECHA_REGISTRO'].' Hrs. '.$row['HORA'], ENT_QUOTES, 'UTF-8'); ?></td>
	 	      <td><?php echo htmlspecialchars($row['DESCRIPCION'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="15%"><img src="<?php echo htmlspecialchars($imagenDescarga, ENT_QUOTES, 'UTF-8'); ?>" width="30" height="30" /></td>
	 	          <td width="85%"><a href="frmDescargar.php?archivo=<?php echo rawurlencode($archivoDescarga); ?>">Descargar</a></td>
                </tr>
              </table></td>
            </tr>
            <?php } ?>
          </tbody>
        </table></td>
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
        <td><span class="ASTERISCO">VER. 0</span></td>
      </tr>
    </table><?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php require '../Control_Sesiones_Forms/Key.php';?><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>