<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['DOCUMENTOASOC'])){include_once("Index.php");}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}

$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['sltGestion']=$sltGestion;?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmArchivoXls.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmImpMasExcelDepFerias.php' enctype="multipart/form-data">
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">IMPORTACION MASIVA FERIAS Y MERCADOS</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">Seleccionar Archivo</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">Seleccione Archivo Excel. </td>
  </tr>
  <tr>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="2" bordercolor="#FFFFFF">
      <tr>
        <td width="33%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="67%" style="font-weight: bold"><?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?><?php echo utf8_decode($row['DESCRIPCION']);}?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo $COD_ASOCIACION;?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo $ASOCIACION;?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td height="35" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>
        </span></td>
      </tr>
      <tr>
        <td height="35" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión Seleccionado :</td>
        <td style="font-weight: bold"><?php echo $sltGestion;?><span class="comentario"> Se importara datos para esta gestión.</span></td>
      </tr>
      <tr>
        <td height="35" align="right" bgcolor="#CCCCCC"><table width="100%" border="0">
          <tr>
            <td width="99%" align="right"><span class="ASTERISCO">*</span> Seleccione Archivo :</td>
            <td width="1%"><div id="imagePreview"></div></td>
          </tr>
        </table></td>
        <td><input name="excel" type="file" id="excel" size="70" accept="application/msexcel" onchange="return fileValidation()" required /></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="350" height="2" /></td>
        <td class="comentario">Seleccione Archivo Excel</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px" disabled="disabled" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left" style="font-weight: bold">Reporte de Datos Cargados (No Pagados).</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td height="31" align="center" bgcolor="#F4F4F4" style="font-weight: bold">No.</td>
        <td align="center" bgcolor="#F4F4F4" style="font-weight: bold">FECHA Y HORA</td>
        <td align="center" bgcolor="#F4F4F4" style="font-weight: bold">USUARIO</td>
        <td align="center" bgcolor="#F4F4F4" style="font-weight: bold">GESTION</td>
        <td align="center" bgcolor="#F4F4F4"><span style="font-weight: bold">COMUNICACION INTERNA</span></td>
        </tr><?php $result=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,HORA,USUARIO,NOMBRE_USUARIO,GESTION,COMUNICACION_INTERNA,ENLACE from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'"); while($row=mysql_fetch_array($result)){ ?><?php ?>
      <tr>
        <td bgcolor="#CCCCCC"><?php $CONT++; echo $CONT; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row[1].' Hrs.: '.$row[2]; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row[3].'-'.$row[4]; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row[5]; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row[6]; ?></td>
        </tr><?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><a href="frmImpMasAsocFerias.php">Volver</a></td>
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
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body></form>
</html><?php if($CONT>0){echo "<script>alert('Se encontraron registros para la Asociacion Seleccionada.')</script>";}  require '../Conexion_BD/Cerrar_Dbms.php';?>