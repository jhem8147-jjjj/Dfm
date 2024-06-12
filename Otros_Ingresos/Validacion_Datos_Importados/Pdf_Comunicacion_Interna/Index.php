<?php
require_once('../frmSesiones.php');require '../../Conex_Dbms/Dbms.php';$GESTION=date('Y');$cont=0;
$res=mysql_query("select * from nros_comunicacion_interna where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$ENCONTRADO=1;
}
if($ENCONTRADO==1){}else{
$query = mysql_query("UPDATE nros_comunicacion_interna  SET ESTADO='NO ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna.");
$sql1="insert into nros_comunicacion_interna(GESTION,NRO)values('$GESTION','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_comunicacion_interna.");
	}
$res=mysql_query("select  * from reg_contribuyente_habilitado_pago_complementacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and CODIGO_REGISTRO='$txtCodigoRegistro' and ESTADO='ACTIVO' ");
		  	  while($row=mysql_fetch_array($res)){ $cont++;}
	//extrae nombre del secretario general
$res=mysql_query("select SG.DOC_IDENTIDAD,SG.DOC_IDENTIDAD_ALFA,SG.EXPEDIDO,SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,RSGA.GESTION,RSGA.ESTADO  from reg_secretario_general_asociacion RSGA, secretario_general SG where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL and RSGA.ESTADO='ACTIVO' and RSGA.GESTION='$ANIOS' and SG.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ $SEC_GENERAL=$row[3].' '.$row[4].' '.$row[5]; }
if($SEC_GENERAL==null){$SEC_GENERAL='NO DEFINIDO';}
$result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
	if($row['AFILIADOS']==0){$AFILIADOS=utf8_decode($row['OBSERVACIONES']);}else{
$AFILIADOS=$row['AFILIADOS'];}
$OM=utf8_decode($row['ORDENANZA_MUNICIPAL']);
$ASOCIACION=utf8_decode($row['DESCRIPCION']);
$LUGARES_ASENT=utf8_decode($row['ZONA_UBICACION']);
$LUGARES_ASENTA=utf8_decode($row['DIRECCION']);
	}
//OBTIENE LA ZONA TRIBUTARIA
$result=mysql_query("select ZT.DESCRIPCION from reg_asociacion_zona_tributaria AZT,zona_tributaria ZT where AZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and ZT.CODIGO_ZONA=AZT.CODIGO_ZONA and AZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
$ZONATRIBUTARIA=utf8_decode($row['0']);

	}

$res=mysql_query("select * from nros_comunicacion_interna where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO']+1;
}
$query = mysql_query("UPDATE nros_comunicacion_interna  SET NRO='$CODIGO_NRO' where GESTION='$GESTION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna.");

$HOY_ES=$dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
//require('fpdf.php');
require('mc_table.php');
//$pdf = new FPDF();
$pdf=new PDF_MC_Table('P','mm',array(216,279));
//$pdf = new FPDF('P','mm',array(216,279));
$pdf->AddPage();
$L=180;
//$pdf->SetLeftMargin(20);
//$pdf->SetRightMargin(15);
//$pdf->SetTopMargin(70);
$pdf->SetMargins(20,1,15);
$pdf->SetFont('Arial','B',11);
$pdf->Ln(10);
$pdf->MultiCell($L,5,'COMUNICACION INTERNA',0,'C');
$pdf->MultiCell($L,5,'SMDE/DFM/AC/CC/'.$CODIGO_NRO.'/'.$GESTION,0,'C');
$pdf->SetFont('Arial','',9);
$I=30;
$J=70;
$K=4;
$resulty=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' order by NIVEL "); while($rowy=mysql_fetch_array($resulty)){if($rowy['NIVEL']=='NIVEL 1'){ $NIVELES='A :'; }else{$NIVELES='VIA :';}
//$pdf->MultiCell(49,$K,$NIVELES,0,'R');
$pdf->SetXY($J,$I);
$pdf->Cell(1, 6,$NIVELES,0,1,'R'); 
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,$rowy['NOMBRE_A'].'.', 0 , 1); 
$I=$I+4;
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,$rowy['CARGO_A'], 0 , 1); 
$I=$I+4;
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,'GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO', 0 , 1); 
$I=$I+7;
$K=$K+2;
}
$pdf->SetXY($J,$I);
$pdf->Cell(1, 6,'DE:',0,1,'R'); 
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,$SIOIUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO.'.', 0 , 1);
$I=$I+4;
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,$SIOICARGO, 0 , 1); 
$I=$I+4;
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,'GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO', 0 , 1);
$I=$I+7; 
$pdf->SetXY($J,$I);
$pdf->Cell(1, 6,'REF.:',0,1,'R'); 
$pdf->SetFont('Arial','B',10);
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,'AUTORIZACION DE PAGO DE COMPLEMENTO', 0 , 1);
$pdf->SetFont('Arial','',9);
$I=$I+7; 
$pdf->SetXY($J,$I);
$pdf->Cell(1, 6,'FECHA:',0,1,'R'); 
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,$HOY_ES, 0 , 1);
$pdf->MultiCell($L,5,'_____________________________________________________________________________________________',0,'C');
$pdf->Ln(3);
$pdf->MultiCell($L,4,utf8_decode('En atencion a solicitud de complementación, presentada por la '.$ASOCIACION. ', en hoja de ruta internacon registro interno '.$txtDocumento.' en fecha '.$txtFecha.', y en cumplimiento a la RESOLUCION ADMINISTRATIVA MUNICIPAL BI-SECTORIAL No. 001/2019 "DE LOS REQUISITOS Y PROCEDIMIENTOS PARA EL CAMBIO DE NOMBRE POR ALTAS Y BAJAS, ABANDONO Y FALLECIMIENTO POR ASENTAMIENTO DE TRABAJADORES GREMIALES, ARTESANOS, COMERCIANTES MINORISTAS Y VIVANDEROS Y MERCADOS EN EL MUNICIPIO DE EL ALTO", se remite la autorización para el pago de complementación, haciendo constar que el nombre del entrante ya se encuentran registrado en la Herramienta Informática Gremial de acuerdo a las siguientes caracterisitcas:'),0,'J');
$pdf->Ln(2);
$pdf->SetWidths(array(90,90));
$pdf->Row(array('NOMBRE LA ASOCIACION',$ASOCIACION));
$pdf->Row(array('CANTIDAD DE AFILIADOS SEGUN '.$OM,$AFILIADOS));
$pdf->Row(array('CANTIDAD AUTORIZADO PARA PAGAR LA COMPLEMENTACION',$cont.' PUESTO(S) DE VENTA'));
$pdf->Row(array('LUGAR DE ASENTAMIENTO',$LUGARES_ASENT.' - '.$LUGARES_ASENTA));
$pdf->Row(array('NOMBRE DEL (LA) SECRETARIO (A) GENERAL',$SEC_GENERAL));
$pdf->Ln(2);
$pdf->MultiCell($L,5,utf8_decode('A continuación se detalla la lista de contribuyente(s):'),0,'J');
$pdf->Ln(2);
$pdf->SetFont('Arial','',7);
$pdf->SetWidths(array(15,60,105));
$pdf->Row(array('  Nro.','  DOCUMENTO DE IDENTIFICACION','          NOMBRE(S) Y APELLIDO(S)'));
$res=mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,C.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_VENTA from reg_contribuyente_habilitado_pago_complementacion RCHPC,contribuyentes C where RCHPC.CODIGO_REGISTRO='$txtCodigoRegistro' and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHPC.ESTADO='ACTIVO' and RCHPC.CODIGO_CONTRIBUYENTE=C.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO' order by C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO");while($row=mysql_fetch_array($res)){
$conts++;
if($row['1']== null){$CIS=$row['0'].' '.$row['2'];}else{$CIS=$row['0'].' - '.$row['1'].' '.$row['2'];};
if($row['6']== null){$NOMBRES=$row['3'].' '.$row['4'].' '.$row['5'];}else{$NOMBRES=$row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'];}
$pdf->Row(array($conts,$CIS,$NOMBRES));
}
$pdf->Ln(2);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell($L,5,utf8_decode('Atentamente,'),0,'J');
$pdf->SetFont('Arial','',5);
$pdf->Ln(30);
$pdf->MultiCell($L,2,utf8_decode('c.c./Arch.'),0,'J');
$pdf->MultiCell($L,2,utf8_decode('c.c./DFM.'.$US_SIOI),0,'J');
require '../../Conex_Dbms/Cerrar_Dbms.php';
$pdf->Output();
?>