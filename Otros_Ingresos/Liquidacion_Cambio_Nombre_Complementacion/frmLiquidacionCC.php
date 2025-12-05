<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
$GESTION = date('Y');

$res = mysql_query("select * from nros_correlativos ");
while ($ro = mysql_fetch_array($res)) {
	$CODIGO_NRO = $ro['NRO_REPORTE'] + 1;
}
$TOTAL = 0;
$query = mysql_query("UPDATE nros_correlativos  SET NRO_REPORTE='$CODIGO_NRO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
$res = mysql_query("select MONTO,MULTA,FORMULARIO,COMUNICACION_INTERNA from reg_contribuyente_habilitado_pago_complementacion RCHP where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and  RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.ESTADO_COMUNICACION_INTERNA='GENERADO' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO'");
while ($row = mysql_fetch_array($res)) {
	$TOTAL = $TOTAL + $row[0] + $row[1] + $row[2];
	$COMUNICACION_INTERNA = $row[3];
}
require('../Pdf_Fpdf/mc_table.php');
$pdf = new PDF_MC_Table();

//Creación del objeto de la clase heredada
//$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetLeftMargin(12);
$pdf->SetRightMargin(30);
$pdf->Ln(10);
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180, 4, 'DIRECCION DE ADMINISTRACION TRIBUTARIA MUNICIPAL', 0, 'C');
$pdf->Multicell(180, 4, 'PROFORMA POR CONCEPTO DE COMPLEMENTO(S) DE CONTRIBUYENTE(S)', 0, 'C');
$pdf->Multicell(180, 4, 'AREA DE OTROS INGRESOS', 0, 'C');
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180, 4, 'Nro. 000' . $CODIGO_NRO, 0, 'C');
$pdf->Ln(1);
$pdf->Multicell(180, 4, 'FECHA DE EMISION  ' . date('d/m/Y'), 1, 'C');
$pdf->Ln(2);
$pdf->Multicell(180, 4, utf8_decode('Numero de Cuenta Corriente :   ' . $txtDepositoCC . ' - ' . $txtBancoCc), 0, 'C');
$pdf->Ln(1);
$pdf->Multicell(180, 4, utf8_decode('I. DATOS DE LA ASOCIACION.'), 0, 'J');
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180, 4, utf8_decode('    Documento de registro : ' . $DOCUMENTOREG), 0, 'J');
$pdf->Multicell(180, 4, utf8_decode('    Nombre de la Asociación: "' . $ASOCIACION . '"'), 0, 'J');
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180, 4, utf8_decode('II. DATOS DE PAGO.'), 0, 'J');
$pdf->Multicell(180, 4, utf8_decode('    Importe Total a Pagar:   Bs.- ' . $TOTAL), 0, 'J');
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180, 4, utf8_decode('III. OBSERVACIONES.'), 0, 'J');
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180, 3, utf8_decode('     - La válides de la presente proforma tiene vigencia hasta la fecha.' . date('d/m/Y')), 0, 'J');
$pdf->Ln(1);
$pdf->Multicell(180, 3, utf8_decode('     - Traer 3 Fotocopias del Comprobante del Banco.'), 0, 'J');
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180, 4, utf8_decode('IV. DETALLE DE CONTRIBUYENTES HABILITADOS PARA PAGO DE COMPLEMENTACION(ES) DE CONTRIBUYENTE(S).'), 0, 'J');
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180, 4, utf8_decode('    COMUNICACION INTERNA: ' . $COMUNICACION_INTERNA), 0, 'J');
$pdf->Ln(1);
$cont = 0;
$pdf->SetFont('courier', '', 7);
$pdf->SetWidths(array(7, 30, 55, 40, 20, 18, 17));
$pdf->Row(array('No.', 'No.DE DOCUMENTO', '  NOMBRE(S) Y APELLIDO(S)', 'ACTIVIDAD', '  PUESTO', '     FILA', 'TOTAL'));
$res = mysql_query("select C.TIPO_DOCUMENTO,C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,C.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_VENTA,RCHPC.FILA,RCHPC.PUESTO,RCHPC.MONTO,RCHPC.MULTA,RCHPC.FORMULARIO from reg_contribuyente_habilitado_pago_complementacion RCHPC,contribuyentes C where RCHPC.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHPC.ESTADO_COMUNICACION_INTERNA='GENERADO'  and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHPC.ESTADO='ACTIVO' and RCHPC.CODIGO_CONTRIBUYENTE=C.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO'");
while ($row = mysql_fetch_array($res)) {
	$TOTALCONT = $row[13] + $row[14] + $row[15];
	// ARMA CEDULA DE IDENTIDAD
	if ($row[2] == null) {
		$CEDULA_IDENTIDAD = $row[1] . ' ' . $row[3];
	} else {
		$CEDULA_IDENTIDAD = $row[1] . ' - ' . $row[2] . ' ' . $row[3];
	}
	//ARMA NOMBRES
	if ($row[7] == null) {
		$NOMBRE_CONT = $row[4] . ' ' . $row[5] . ' ' . $row[6];
	} else {
		$NOMBRE_CONT = $row[4] . ' ' . $row[5] . ' ' . $row[6] . ' de ' . $row[7];
	}
	$NOMBRE_CONT = utf8_decode($NOMBRE_CONT);
	$cont++;
	$pdf->Row(array($cont, $CEDULA_IDENTIDAD, $NOMBRE_CONT, $row[10], $row[11], $row[12], 'Bs.- ' . $TOTALCONT));
	$TOTALPAGAR = $TOTALPAGAR + $TOTALCONT;
	$TOTALCONT = 0;
}
$pdf->SetFont('courier', 'B', 9);
$pdf->SetWidths(array(170, 17));
$pdf->Row(array('                                                        TOTAL EXPRESADO EN BOLIVIANOS:', 'Bs.- ' . $TOTALPAGAR));
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180, 4, utf8_decode('Total de Contribuyentes Habilitados para pago:' . $cont), 0, 'L');
$NOMBRE = 'REPORTE_000' . $CODIGO_NRO;
$COD_REGISTRO = date('Ymd His');
$sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','COMPLEMENTO DE CONTRIBUYENTE','EMISION DE PROFORMA / ORDEN DE PAGO COMPLEMENTO DE CONTRIBUYENTES DETALLADO No. $CODIGO_NRO.','EMISION DE PROFORMA / ORDEN DE PAGO COMPLEMENTO DE CONTRIBUYENTES No. $CODIGO_NRO.','0')";
$result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");

//REGISTRA EN LA TABLA reg_documentos_generados

$sql1 = "insert into reg_documentos_generados(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,NRO_DOCUMENTO,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','PROFORMA POR CONCEPTO DE COMPLEMENTO(S) DE CONTRIBUYENTE(S) No. $CODIGO_NRO','VISTO EN PANTALLA')";
$result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_documentos_generados.");

$pdf->Output($direccion . ' ' . $NOMBRE . '.pdf', 'I');
require '../Conexion_BD/Cerrar_Dbms.php';
