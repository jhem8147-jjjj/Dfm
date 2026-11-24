<?php   require_once('../../../Control_Sesiones_Forms/frmControlSesionUsuario.php');
 require '../../../Conexion_BD/Dbms.php';
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CODIGO_TRANSACCION=date('Ymd His');
require_once('tcpdf_include.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
$pdf->SetMargins(5,2,2);
//$pdf->SetHeaderMargin(10);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('Imprimir Comprobante Original');
//$pdf->SetSubject('TCPDF Tutorial 1');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '',9);
$res=mysql_query("select * from nro_reproduccion_pago");while($ro=mysql_fetch_array($res)){
$NROS_REPRODUCCION=$ro['NRO_REPRODUCCION']+1;
}
$query = mysql_query("UPDATE nro_reproduccion_pago  SET NRO_REPRODUCCION='$NROS_REPRODUCCION'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nro_reproduccion_pago.");
//COMIENZA A GENERAR CONTRIBUYENTES
 $res=mysql_query("select * from reg_contribuyente_asociacion_pago where ID='$IMPRIMIR' and ESTADO='ACTIVO'");
while($rows=mysql_fetch_array ($res)){ 
$COD_ASOCIACION=$rows['CODIGO_ASOCIACION'];
$NOMBRE_ASOCIACION=$rows['ASOCIACION'];
$COD_ZONA=$rows['CODIGO_ZONA'];
$NROS_COMP=$NROS_REPRODUCCION.' COMPROBANTE No.'.$rows['NRO_COMPROBANTE'].', '.$rows['CEDULA_IDENTIDAD'].' '.$rows['CONTRIBUYENTE'].' ACTIVIDAD '.$rows['ACTIVIDAD'];
$NOMBREQR='No. REPRODUCCION '.$NROS_REPRODUCCION.', '.$rows['NRO_COMPROBANTE'].' - '.$rows['CEDULA_IDENTIDAD'].', '.$rows['CONTRIBUYENTE'].', ACTIVIDAD '.$rows['ACTIVIDAD'].', '.$rows['GLOSA_DESCRIPCION_1'].', '.' Bs.- '.$rows['TOTAL'].' - '.$CODIGO_TRANSACCION;
if($rows['TOTAL2']==0){
$MULTAS='';
$TAMANIO1='"font-size: 11px"';
$TAMANIO2='"font-size: 11.5px"';
}else{$TAMANIO1='"font-size: 11px"';
$TAMANIO2='"font-size: 11px"';$MULTAS=$rows['TOTAL2'];}
$pdf->AddPage();
$dia=substr($rows['FECHA_IMPRESION'],0,2);
$mes=substr($rows['FECHA_IMPRESION'],3,2);
$anio=substr($rows['FECHA_IMPRESION'],6,4);
$FECHA_LARGA='El Alto,'.date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
// set some text to print
$tbl = <<<EOD
<br><br><br><br><br><br><br><H4> <br>  </H4><br>
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="11%" rowspan="6"><img src="../../Img/Vuelo.png" width="116" height="131" /></td>
        <td width="14%">&nbsp;</td>
        <td width="54%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="3" align="center" style="font-size: 18px; font-weight: bold; color: #F30;">000$rows[NRO_COMPROBANTE]</td>
        <td align="center">SERIE A</td>
        <td>GOBIERNO AUTONOMO</td>
      </tr>
      <tr>
        <td rowspan="3" align="center" style="font-size: 16px">COMPROBANTE</td>
        <td>MUNICIPAL DE EL ALTO</td>
      </tr>
      <tr>
        <td>TESORO MUNICIPAL</td>
      </tr>
      <tr>
        <td>Fecha</td>
        <td>COMPROBANTE DE CAJA</td>
      </tr>
      <tr>
        <td><table width="100%" height="27" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center">$dia</td>
            <td align="center">$mes</td>
            <td align="center">$anio</td>
            </tr>
        </table></td>
        <td align="center">REPRODUCCION DE PAGO ORIGINAL</td>
        <td>VENTANILLA Nº</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
        <tr align="center">
          <td height="29" colspan="2">Padrón Placa Catastro Varios</td>
          <td colspan="5">Nombre del Contribuyente o Razón Social</td>
          
          </tr>
        <tr>
          <td  colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="20%">N.I.T.:</td>
              <td width="80%">&nbsp;</td>
              </tr>
            <tr>
              <td>C.I.:</td>
              <td>$rows[CEDULA_IDENTIDAD]</td>
              </tr>
            </table></td>
          <td colspan="5" align="center"><table width="100%" border="0" cellspacing="3" cellpadding="2">
            <tr>
              <td align="center">$rows[CONTRIBUYENTE]</td>
              </tr>
            <tr>
              <td align="center" style="font-size: 9px">$rows[ASOCIACION]</td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td colspan="2" rowspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
              <td>P.M.C.: </td>
              </tr>
            </table></td>
          <td colspan="2" align="center">Avenida o Calle</td>
          <td align="center">Nº</td>
          <td colspan="2" align="center">Zona</td>
          </tr>
        <tr>
          <td  colspan="2" align="center" style="font-size: 9px">$rows[DIRECCION]</td>
          <td align="center" >-----</td>
          <td colspan="2" align="center" style="font-size: 9px">$rows[ZONA_UBICACION]</td>
          </tr>
        <tr>
          <td height="30" colspan="7"><table width="100%" border="0" cellspacing="3" cellpadding="3">
            <tr>
              <td>Actividad: $rows[ACTIVIDAD]</td>
              </tr>
            </table></td>
          </tr>
        <tr >
          <td align="center" >CÓDIGO</td>
          <td height="27" colspan="5" align="center">DESCRIPCIÓN</td>
          <td align="center">IMPORTE</td>
          </tr>
        <tr>
          <td align="left" style=$TAMANIO1><blockquote>
            <p>$rows[CODIGO_CUENTA1]</p>
			<p>&nbsp;</p>
            <p>&nbsp;</p>
			<p>$rows[CODIGO_CUENTA2]</p>
			<p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>$rows[CODIGO_CUENTA3]</p>
          </blockquote></td>
          <td colspan="5" align="left" style=$TAMANIO2><blockquote>
            <p>$rows[DESCRIPCION_1]</p>
            <p>$rows[GLOSA_DESCRIPCION_1]</p>
             <p>$rows[GLOSA_DESCRIPCION_2]</p>
            <p>$rows[DESCRIPCION_2]</p>
            <p>$rows[DESCRIPCION_2_1]</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>$rows[DESCRIPCION_3]</p>
          </blockquote></td>
          <td align="left" style=$TAMANIO1><blockquote>
            <p>$rows[TOTAL1]</p>
            <p>&nbsp;</p>
             <p>&nbsp;</p>
			 <p>$MULTAS</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>$rows[TOTAL3]</p>
          </blockquote></td>
        </tr>
        <tr>
          <td height="38" colspan="5"><table width="100%" border="0" cellspacing="3" cellpadding="2">
            <tr>
              <td>Son: $rows[LITERAL]</td>
              <td align="right">Bolivianos</td>
              </tr>
            </table></td>
          <td align="right"><table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
              <td align="right">Importe a pagar</td>
              </tr>
            </table></td>
          <td align="center" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
              <td align="center">$rows[TOTAL]</td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td>Transcriptor</td>
          <td colspan="6">Observaciones:</td>
          </tr>
        <tr>
          <td height="39" align="center" style="font-size: 9px">$rows[TRANSCRIPTOR]</td>
          <td colspan="6"><p>$rows[OBSERVACIONES]</p></td>
          </tr>
        <tr align="center">
          <td colspan="2">Cajero</td>
          <td >Verificador</td>
          <td colspan="4" align="left">Pago realizado en:</td>
          </tr>
        <tr align="center">
          <td colspan="2"><p>$rows[CAJERO]</p>
            <p>&nbsp;</p></td>
          <td >$rows[VERIFICADOR]</td>
          <td colspan="4" align="left"><p>$rows[PAGO_REALIZADO]</p></td>
          </tr>
        
      </table></td>
  </tr>
</table>
<style="text-align: justify">ESTE DOCUMENTO SE EMITE EN BASE A LO PREVISTO POR EL ART. 7 DEL DECRETO SUPREMO 27310 DEL REGLAMENTO AL CODIGO TRIBUTARIO BOLIVIANO.<br><br>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="right">$FECHA_LARGA</td>
  </tr>
  <tr>
    <td width="25%" align="right" >NRO. DE REPRODUCCION :</td>
    <td width="60%">000000$NROS_REPRODUCCION</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">OPERADOR :</td>
    <td>$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
EOD;

//$pdf->SetAlpha(0.3);
//$pdf->Image('CANCELADO.PNG',90, 115, 75, 40, '', '', '', true, 100);
//$pdf->SetAlpha(1);
$pdf->writeHTML($tbl, true, false, false, false, '');
 }
$pdf->write2DBarcode($NOMBREQR, 'QRCODE,Q', 140, 35, 20, 20, $style, 'N');
$pdf->Text(20, 145, ' ');
//Close and output PDF document
//REGISTRA EN LA TABLA DE REPRODUCCION DE PAGOS
$sql1="insert into reg_reproduccion_pagos_generados(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,NRO_REPRODUCCION,DESCRIPCION)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_TRANSACCION','$COD_ASOCIACION','$NOMBRE_ASOCIACION','$NROS_REPRODUCCION','GENERACION DE REPRODUCCION DE PAGO No. $NROS_COMP')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_reproduccion_pagos_generados.");
//REGISTRA LAS TRANSACCIONES.

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,CODIGO_ZONA,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_TRANSACCION','$COD_ASOCIACION','$NOMBRE_ASOCIACION','$COD_ZONA','REPRODUCCION DE PAGO','GENERACION DE REPRODUCCION DE PAGO No. $NROS_COMP ','GENERACION DE REPRODUCCION DE PAGO No. $NROS_COMP','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
require '../../../Conexion_BD/Cerrar_Dbms.php';
$NOMBRE=md5('Reproduccion de Pago').$CODIGO_TRANSACCION.rand(1,10);
$pdf->Output($NOMBRE.'.pdf','I');
exit;
//$pdf->Output('Comprobante_Pago_Original.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
