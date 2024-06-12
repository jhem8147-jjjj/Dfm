<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}else{$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}else{$_SESSION['ASOCIACION']=$ASOCIACION;}
if(empty($_SESSION['OMS'])){include_once("Index.php");}else{$_SESSION['OMS']=$OMS;}
if(empty($_SESSION['CODIGOREGISTRO'])){include_once("Index.php");}else{$_SESSION['CODIGOREGISTRO']=$CODIGOREGISTRO;}
if(empty($_SESSION['sltGestion'])){include_once("Index.php");}else{$_SESSION['sltGestion']=$sltGestion;}
if(empty($_SESSION['COD_REGISTRO'])){include_once("Index.php");}else{$_SESSION['COD_REGISTRO']=$COD_REGISTRO;}
$cont=0;
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

<body>
<table width="99%" border="0" align="center">
  <tr>
    <td align="center" class="TITULO">PROFORMA DE DEUDA</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Emisión de Proforma de Deuda</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td><form method="post" action="frmProformaAsociacion.php"><table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td width="7%" height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td width="93%" style="font-weight: bold"><?php echo $OMS;?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?>
        </span></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Gestión de Liquidación :</td>
        <td style="font-weight: bold; font-size: 14px;"><?php echo $sltGestion;?></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="500" height="2" /></td>
        <td >&nbsp;</td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td align="center" style="font-weight: bold">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold; font-size: 13px;"><u>CONTRIBUYENTES HABILITADOS PARA EL PAGO <?php echo $sltGestion;?></u></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
      <tr style="font-weight: bold">
        <td height="38" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td colspan="4" align="center" bgcolor="#CCCCCC">MULTAS</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr style="font-weight: bold">
        <td height="70" align="center" bgcolor="#CCCCCC">No.</td>
        <td align="center" bgcolor="#CCCCCC">No. DE DOCUMENTO</td>
        <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
        <td align="center" bgcolor="#CCCCCC">TIPO DE ACTIVIDAD</td>
        <td align="center" bgcolor="#CCCCCC">PUESTO</td>
        <td align="center" bgcolor="#CCCCCC">FILA</td>
        <td align="center" bgcolor="#CCCCCC"><p>IMPEA</p>
          <p>BS.</p></td>
        <td align="center" bgcolor="#CCCCCC"><p>MV - UFV</p>
          <p>BS.</p></td>
        <td align="center" bgcolor="#CCCCCC"><p>MIDF</p>
          <p>BS.</p></td>
        <td align="center" bgcolor="#CCCCCC"><p>INTERES</p>
          <p>BS.</p></td>
        <td align="center" bgcolor="#CCCCCC"><p>OTRAS MULTAS</p>
          <p>BS.</p></td>
        <td align="center" bgcolor="#CCCCCC"><p>FORM.</p>
          <p>BS.</p></td>
        <td align="center" bgcolor="#CCCCCC"><p>TOTAL</p>
          <p>BS.</p></td>
        </tr></thead>
        <tbody>
      <?php 
	  
		   //liquida la gestion seleccionada
	  $res=mysql_query("select CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCHP.GESTION,RCHP.TIPO_VENTA,RCHP.FILA,RCHP.PUESTO,RCHP.MONTO,RCHP.MANT_VALOR,RCHP.MIDF,RCHP.INTERES,RCHP.OTRAS_MULTAS,RCHP.FORMULARIO,RCHP.COMUNICACION_INTERNA from reg_contribuyente_habilitado_pago RCHP, contribuyentes CONTRI where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and CONTRI.CODIGO_CONTRIBUYENTE=RCHP.CODIGO_CONTRIBUYENTE and CONTRI.ESTADO='ACTIVO' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO'");
	  while($row=mysql_fetch_array($res)){ 			  
			  
	  $SW2=1;?>
      <tr>
        <td><?php $cont++; echo $cont; ?></td>
        <td><?php if($row[1]== null){ echo  $row[0].' '.$row[2];}else{echo $row[0].' - '.$row[1].' '.$row[2];} ?></td>
        <td><?php if($row[6]== null){echo $row[3].' '.$row[4].' '.$row[5].' '.$row[6];}else{echo $row[3].' '.$row[4].' '.$row[5].' de '.$row[6];} ?></td>
        <td><?php echo $row[8]; ?></td>
        <td><?php echo $row[9]; ?></td>
        <td><?php echo $row[10]; ?></td>
        <td align="center"><?php echo $row[11]; ?></td>
        <td align="center"><?php echo $row[12]; ?></td>
        <td align="center"><?php echo $row[13]; ?></td>
        <td align="center"><?php echo $row[14]; ?></td>
        <td align="center"><?php echo $row[15]; ?></td>
        <td align="center"><?php echo $row[16]; ?></td>
        <td align="center"><?php echo $row[11]+$row[12]+$row[13]+$row[14]+$row[15]+$row[16]; $TOTAL=$TOTAL+$row[11]+$row[12]+$row[13]+$row[14]+$row[15]+$row[16]; ?></td>
        </tr>
      <?php } ?>
      
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="98%" align="right" bgcolor="#E3F0F2" style="font-weight: bold; font-size: 13px;">TOTAL Bs.-</td>
        <td width="2%" align="center"><a href="frmProforma1.php"><span style="font-size: 14px; font-weight: bold;"><?php echo $TOTAL;?></span></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="../Img/Blanco.png" width="100" height="6" /></td>
      </tr>
      <tr>
        <td align="right"><table width="50%" border="0">
          <tr>
            <td><table width="100%" border="0">
              <tr>
                <td align="right"><img src="../Img/Validar.png" width="36" height="33" /></td>
                <td align="left"><a href="frmProformaAsociacion.php?VALIDAR=1">Se verifico cada registro, Habilitar Autorización de Emisión de Proforma de Pago.</a></td>
              </tr>
            </table></td>
            <td></td>
           <?php if($VALIDAR==1){?> <td><form  method="post" action='frmProformaOpciones.php'>
            
               <p>
                 <input type="submit" name="button2" id="button2" value="Generar Boleta" style="width:250px; height:35px"  />
               </p>
           
           </form></td><?php } ?>
          </tr>
          <tr>
            <td><img src="../Img/Blanco.png" width="500" height="2" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><table width="100%" border="0">
      <tr>
        <td align="right" class="SUBTITULO"><span class="tab-content"><span class="TITULO">DONDE:</span></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right">IMPAE :</td>
        <td>Impuesto Municipal Patente Anual Eventual.</td>
      </tr>
      <tr>
        <td align="right">MV-UFV:</td>
        <td>Mantenimiento de Valor - Unidad Fomento de Vivienda.</td>
      </tr>
      <tr>
        <td align="right">MIDF:</td>
        <td>Multa de Incumplimiento a Deberes Formales.</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="10%" border="1" cellspacing="2" cellpadding="2" bordercolor="#FFFFFF">
     
     <tr>
       <td width="35%" align="right"><img src="../Img/Blanco.png" width="200" height="6" /></td>
       <td width="65%" align="left">&nbsp;</td>
       <td width="65%" align="left"><img src="../Img/Blanco.png" width="100" height="6" /></td>
     </tr><?php  $res=mysql_query("select count(*),RCHP.TIPO_VENTA from reg_contribuyente_habilitado_pago RCHP, contribuyentes CONTRI where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCHP.GESTION='$sltGestion' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO' and CONTRI.ESTADO='ACTIVO' group by RCHP.TIPO_VENTA ");
		   while($row=mysql_fetch_array($res)){ ?>
     <tr>
        <td align="right" bgcolor="#E3F0F2" style="font-weight: bold"><?php echo $row[1]; ?> :</td>
        <td align="left">&nbsp;</td>
        <td align="left"><?php echo $row[0]; ?></td>
      </tr><?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="right"></td>
  </tr>
  <tr>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center"><a href="frmProformaDatosAsocLiq.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';
/*if($cont==0){echo "<script>alert('No se encontraron registros Validados para la Asociacion Seleccionada.')</script>";echo"<script> location.href='frmProforma.php';</script>";}*/
?>