<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$GESTION=date('Y');
//crea carpeta
$serv = $_SERVER['DOCUMENT_ROOT'] . "/DFM/Otros_Ingresos/Liquidacion_Anual/Reportes/";
$ruta = $serv . $GESTION;
if(!file_exists($ruta))
{
mkdir ($ruta);
}

$res=mysql_query("select * from nros_correlativos ");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO_REPORTE']+1;
}$TOTAL=0;
$query = mysql_query("UPDATE nros_correlativos  SET NRO_REPORTE='$CODIGO_NRO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
$res=mysql_query("select MONTO,MANT_VALOR,MIDF,INTERES,OTRAS_MULTAS,FORMULARIO from reg_contribuyente_habilitado_pago RCHP where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and  RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.GESTION='$sltGestion' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO' and RCHP.ESTADO_REGISTRO='REGISTRO VALIDADO.' ");
	  while($row=mysql_fetch_array($res)){ $TOTAL=$TOTAL+$row[0]+$row[1]+$row[2]+$row[3]+$row[4]+$row[5];
	  }
require('../Pdf_Fpdf/mc_table.php');
$pdf=new PDF_MC_Table();
class PDF extends FPDF
{
function Footer()
{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print current and total page numbers
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
//Creación del objeto de la clase heredada
//$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetLeftMargin(12);
$pdf->SetRightMargin(30);
$pdf->Ln(10);
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,4,'DIRECCION DE ADMINISTRACION TRIBUTARIA MUNICIPAL',0,'C');
$pdf->Multicell(180,4,'AREA DE OTROS INGRESOS',0,'C');$pdf->Ln(2);
$pdf->Multicell(180,4,'000'.$CODIGO_NRO,0,'C');
//$pdf->SetDash(1,1);
//$pdf->Line(200,100,297,100);
$pdf->Ln(1);
$pdf->Multicell(70,4,'FECHA DE EMISION  '.date('d/m/Y'),1,'C');
$pdf->Ln(2);
$pdf->Multicell(180,4,utf8_decode('Numero de Cuenta Corriente :   10000004711912 - BANCO UNION S.A.'),0,'J');$pdf->Ln(1);
$pdf->Multicell(180,4,utf8_decode('Nombre de la Asociación:       '),0,'J');$pdf->Ln(1);
$pdf->Multicell(180,4,utf8_decode('" '.$ASOCIACION.' "'),0,'C');$pdf->Ln(1);
$pdf->Multicell(100,4,utf8_decode('Gestion:          	       	    '.$sltGestion),0,'J');
$pdf->Ln(2);
$pdf->Multicell(180,4,utf8_decode('Importe Total a Pagar:         Bs.- '.$TOTAL),0,'J');
$pdf->Multicell(180,6,utf8_decode('Traer 3 Fotocopias del Comprobante del Banco.'),1,'C');
$pdf->Ln(3);
$pdf->Multicell(180,6,utf8_decode('La válides de la presente proforma tiene vigencia hasta la fecha.' .date('d/m/Y')),1,'C');
$pdf->AddPage();
$pdf->Multicell(180,4,utf8_decode('REGISTRO DE CONTRIBUYENTES HABILITADOS PARA PAGO DE LA GESTION '.$sltGestion),0,'C');$pdf->Ln(3);
$cont=0;
$TOTALCONT=0;
$TOTALPAGAR=0;
$pdf->SetFont('courier','',7);
$pdf->SetWidths(array (8,25,45,25,35,20,13,15));
$pdf->Row(array ('No.','No.DE DOCUMENTO','  NOMBRE(S) Y APELLIDO(S)','DESCRIPCION','      FILA','PUESTO','GESTION','TOTAL A PAGAR'));
$res=mysql_query("select CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCHP.TIPO_VENTA,RCHP.FILA,RCHP.PUESTO,RCHP.GESTION,RCHP.MONTO,RCHP.MANT_VALOR,RCHP.MIDF,RCHP.INTERES,RCHP.OTRAS_MULTAS,RCHP.FORMULARIO from reg_contribuyente_habilitado_pago RCHP, contribuyentes CONTRI where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCHP.GESTION='$sltGestion' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO' and RCHP.ESTADO_REGISTRO='REGISTRO VALIDADO.' and CONTRI.ESTADO='ACTIVO'");
while($rows=mysql_fetch_array($res)){ 
$TOTALCONT=$rows[11]+$rows[12]+$rows[13]+$rows[14]+$rows[15]+$rows[16];
$TOTALPAGAR=$TOTALPAGAR+$TOTALCONT;
if($rows[1]== null){ $DOCUMENTO=$rows[0].' '.$rows[1].' '.$rows[2];}else{$DOCUMENTO=$rows[0].' - '.$rows[1].' '.$rows[2];}
if($rows[6]== null){$NOMBRES=$rows[3].' '.$rows[4].' '.$rows[5].' '.$rows[6];}else{$NOMBRES=$rows[3].' '.$rows[4].' '.$rows[5].' de '.$rows[6];} 
$cont++;			  
$pdf->Row(array ($cont,$DOCUMENTO,$NOMBRES,$rows[7],$rows[8],$rows[9],$rows[10],'Bs.- '.$TOTALCONT));
$TOTALCONT=0;
}
$pdf->Multicell(180,4,utf8_decode('TOTAL A PAGAR Bs.- '.$TOTALPAGAR),0,'R');
$pdf->Multicell(180,4,utf8_decode('Total de Contribuyentes Habilitados para pago:'.$cont),0,'L');
$NOMBRE='REPORTE_000'.$CODIGO_NRO;
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','PROFORMA / ORDEN DE PAGO DETALLADO','EMISION DE PROFORMA / ORDEN DE PAGO DETALLADO No. $CODIGO_NRO.','EMISION DE PROFORMA / ORDEN DE PAGO No. $CODIGO_NRO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 


$sql1="insert into reg_documentos_generados(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,NRO_DOCUMENTO,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','REPORTE PROFORMA RESUMIDO  000$CODIGO_NRO','Reportes/$GESTION/ $NOMBRE.pdf')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");require '../Conexion_BD/Cerrar_Dbms.php';
$direccion=$serv.$GESTION.'/';
$pdf->Output($direccion.' '.$NOMBRE.'.pdf','F');
echo"<script language='javascript'>window.open('Reportes/$GESTION/ $NOMBRE.pdf','_self','');</script>";
		exit;

require '../Conex_Dbms/Cerrar_Dbms.php';
?>