<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['COM_INTERNA']=$COM_INTERNA;
$_SESSION['sltGestion']=$sltGestion;
$_SESSION['CODIGOREGISTRO']=$CODIGOREGISTRO;
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
<form method="post" action="frmComprobantePago1.php">
<body>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO">COMPROBANTE DE PAGO</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Listado de Contribuyentes Habilitados Pago Anual</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Asociacion Seleccionado.</td>
      </tr>
      <tr>
        <td style="font-weight: bold"><img src="../Img/Linea.png" width="1070" height="2" /></td>
      </tr>
      <tr>
        <td style="font-weight: bold"><table width="100%" border="0" bordercolor="#FFFFFF">
        <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
          </tr>
          <tr>
            <td width="33%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="67%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>                      
          </tr> <?php }?>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Gestión :</td>
            <td style="font-weight: bold"><?php echo $sltGestion;?>                      
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Comunicación Interna :</td>
            <td style="font-weight: bold"><?php echo $COM_INTERNA;?></tr>
         
        </table></td>
      </tr>
      <tr>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Registro de Contribuyentes Habilitados.</td>
      </tr>
      <tr>
        <td><span style="font-weight: bold"><img src="../Img/Linea.png" width="1070" height="2" /></span></td>
      </tr>
      <tr>
        <td><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
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
              <td height="38" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC"> DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
              <td align="center" bgcolor="#CCCCCC">TIPO PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">FILA</td>
              <td align="center" bgcolor="#CCCCCC">PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">I.M.P.E.</td>
              <td align="center" bgcolor="#CCCCCC">M.V. - Ufv</td>
              <td align="center" bgcolor="#CCCCCC">M.I.D.F.</td>
              <td align="center" bgcolor="#CCCCCC">INTERES</td>
              <td align="center" bgcolor="#CCCCCC">OTRAS MULTAS</td>
              <td align="center" bgcolor="#CCCCCC">FORMULARIO</td>
              <td align="center" bgcolor="#CCCCCC">TOTAL</td>
              </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCP.TIPO_VENTA,RCP.FILA,RCP.PUESTO,RCP.MONTO,RCP.MANT_VALOR,RCP.MIDF,RCP.INTERES,RCP.OTRAS_MULTAS,RCP.FORMULARIO from reg_contribuyente_habilitado_pago RCP, contribuyentes CONTRI where RCP.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCP.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCP.ESTADO='ACTIVO'  and CONTRI.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ 
			  $TOTAL=0;
	 	  $SW2=1;?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
              <td><?php if($row[1]== null){ echo  $row[0].' '.$row[1].' '.$row[2];}else{echo $row[0].' - '.$row[1].' '.$row[2];} ?></td>
              <td><?php if($row[6]== null){echo $row[3].' '.$row[4].' '.$row[5];}else{echo $row[3].' '.$row[4].' '.$row[5].' de '.$row[6];} ?></td>
              <td><?php echo $row[7]; ?></td>
              <td><?php if($row[8]== null){ echo '-';}else{echo $row[8];} ?></td>
              <td><?php if($row[9]== null){ echo '-';}else{echo $row[9];} ?></td>
              <td style="color: #039; font-weight: bold;"><?php echo $row[10]; ?></td>
              <td style="color: #090; font-weight: bold;"><?php echo $row[11]; ?></td>
              <td><?php echo $row[12]; ?></td>
              <td><?php echo $row[13]; ?></td>
              <td><?php echo $row[14]; ?></td>
              <td style="font-weight: bold; color: #609;"><?php echo $row[15]; ?></td>
              <td style="font-weight: bold"><?php $TOTAL=$row[10]+$row[11]+$row[12]+$row[13]+$row[14]+$row[15];echo $TOTAL;$TOTALES=$TOTALES+$TOTAL; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td width="95%" align="right" style="color: #000; font-weight: bold; font-size: 14px;">Total Bs.-</td>
            <td width="5%" style="font-weight: bold; font-size: 14px;"><?php echo $TOTALES;?></td>
          </tr>
          <tr>
            <td align="right" style="color: #000; font-weight: bold; font-size: 14px;">&nbsp;</td>
            <td style="font-weight: bold; font-size: 14px;"><img src="../Img/Blanco.png" width="60" height="2" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="ASTERISCO">DONDE:</td>
      </tr>
      <tr>
        <td><ul>
          <li><span style="font-weight: bold">I.M.P.E.</span> = Impuesto Municipal Patente Eventual.</li>
        </ul></td>
      </tr>
      <tr>
        <td><ul>
          <li><span style="font-weight: bold">M.V</span>. = Mantenimiento de Valor a la Ufv.</li>
        </ul></td>
      </tr>
      <tr>
        <td><ul>
          <li><span style="font-weight: bold">M.I.D.F.</span> = Multa de Incumplimiento a Deberes Formales.</li>
        </ul></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
         <td align="center"><?php if($VALIDAR==0){?><table width="10%" border="0">
           
           <tr>
             <td align="right"><img src="../Img/Validar.png" width="29" height="31" /></td>
             <td><a href="frmComprobantePagoDatosCont.php?VALIDAR=1" title="HAGA CLIC, SI ESTAN CORRECTOS LOS DATOS DE CONTRIBUYENTES Y VALORES DE LIQUIDACION">Se verifico y están CORRECTOS los datos de los CONTRIBUYENTES y VALORES DE LIQUIDACION</a></td>
           </tr>
          
           <tr>
             <td align="right">&nbsp;</td>
             <td><img src="../Img/Blanco.png" width="520" height="2" /></td>
           </tr>
         </table> <?php } ?><?php if($VALIDAR==1){?>
              <input type="submit" name="button" id="button" value="Continuar" style="width:220px; height:35px" />
              <?php } ?></td>
      </tr>
      <tr>
        <td align="center"><hr /></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><a href="frmComprobantePago.php">Volver Átras</a></td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 2</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($cont==0){echo"<script> alert('No Existen Contribuyentes Habilitados para Cmabio de Nombre');</script>";
	echo"<script> location.href='frmCambioNombre1.php';</script>";}
?>