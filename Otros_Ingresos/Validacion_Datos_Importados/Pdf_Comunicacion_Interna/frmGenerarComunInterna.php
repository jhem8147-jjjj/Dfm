<?php require_once('../../Control_Sesiones_Forms/frmControlSesionUsuario.php');require '../../Conexion_BD/Dbms.php';$GESTION=date('Y');
$cont=0;
$ANIOS=date('Y')-1;
$COD_REGISTRO=date('Ymd').rand(1,100);
//crea carpeta
$serv = $_SERVER['DOCUMENT_ROOT'] . "/dfm/Otros_Ingresos/Validacion_Datos_Importados/Pdf_Comunicacion_Interna/";
$ruta = $serv . $GESTION;
if(!file_exists($ruta))
{
mkdir ($ruta);
}
$cont=0;
$res=mysql_query("select * from nros_comunicacion_interna where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$ENCONTRADO=1;
}
if($ENCONTRADO==1){}else{
$query = mysql_query("UPDATE nros_comunicacion_interna  SET ESTADO='NO ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna.");
$sql1="insert into nros_comunicacion_interna(GESTION,NRO)values('$GESTION','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_comunicacion_interna.");
	}

$res=mysql_query("select * from nros_comunicacion_interna where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO']+1;
}
$query = mysql_query("UPDATE nros_comunicacion_interna  SET NRO='$CODIGO_NRO' where GESTION='$GESTION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna.");

//extrae DATOS del secretario general
$res=mysql_query("select SG.DOC_IDENTIDAD,SG.DOC_IDENTIDAD_ALFA,SG.EXPEDIDO,SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,SG.APELLIDO_ESPOSO,SG.TELEFONO,SG.CELULAR,SG.EMAIL  from reg_secretario_general_asociacion RSGA, secretario_general SG where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL and RSGA.ESTADO='ACTIVO' and RSGA.GESTION='$ANIOS' and SG.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ if($row[6]== null){$SEC_GENERAL=$row[3].' '.$row[4].' '.$row[5].', REFERENCIAS: ';}else{$SEC_GENERAL= $row[3].' '.$row[4].' '.$row[5].' de '.$row[6].', REFERENCIA (S):';}
			  if(strlen($row[7])>4 ){$CONTACTOS=' TEL.'.$row[7].'.';}
			   if(strlen($row[8])>4){$CONTACTOS=$CONTACTOS.' CEL.'.$row[8].'.';}
			   if(strlen($row[9])>5){$CONTACTOS=$CONTACTOS.' EMAIL '.$row[9].'.';}
			  
			  }
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



$HOY_ES=$dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
$NOMBRE_ARCHIVO='SMDE/DFM/AC/AP/0'.$CODIGO_NRO.'/'.$GESTION;
$ENLACE='SMDE_DFM_AP_0'.$CODIGO_NRO.'_'.$GESTION;
$GESTION_PAGO=$sltGestion;
//require('fpdf.php');
require('mc_table.php');
class PDF extends FPDF
{

//Pie de página
 public function Footer()
 {
     parent::Footer();
     foreach ($this->listeners as $l) {
         $l->onFooter();
     }
 }
}

//$pdf = new FPDF();
$pdf=new PDF_MC_Table('P','mm',array(216,279));
//$pdf = new FPDF('P','mm',array(216,279));
$pdf->AddPage();
$L=180;
//$pdf->SetLeftMargin(20);
//$pdf->SetRightMargin(15);
//$pdf->SetTopMargin(70);
$pdf->SetMargins(20,35,15);

$pdf->SetFont('Arial','B',11);
$pdf->Ln(10);
$pdf->MultiCell($L,5,'COMUNICACION INTERNA',0,'C');
$pdf->MultiCell($L,5,'SMDE/DFM/AC/AP/0'.$CODIGO_NRO.'/'.$GESTION,0,'C');
$COMUNICACION_INTERNA='SMDE/DFM/AC/AP/0'.$CODIGO_NRO.'/'.$GESTION;
$pdf->SetFont('Arial','',9);
$SWT=0;
$I=30;
$J=70;
$K=4;
$resulty=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' order by NIVEL "); while($rowy=mysql_fetch_array($resulty)){if($rowy['NIVEL']=='NIVEL 1'){ $NIVELES='A :'; }else{$NIVELES='VIA :';}
$NOMB_EMISOR=$SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO;
if (strpos($rowy['NOMBRE_A'], $NOMB_EMISOR) !== false) {
$SWT=1;
}
//$pdf->MultiCell(49,$K,$NIVELES,0,'R');
if($SWT==0){
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
}
$pdf->SetXY($J,$I);
$pdf->Cell(1, 6,'DE:',0,1,'R'); 
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,utf8_decode($SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO.'.'), 0 , 1);
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
$I=$I+4; 
$pdf->Cell(70, 6,'AUTORIZACION PAGO DE PATENTE EVENTUAL ANUAL '.$sltGestion, 0 , 1);
//$pdf->SetXY($J,$I);
//$pdf->Cell(70, 6,'DE IMPUESTO EVENTUAL ANUAL '.$GESTION_PAGO.'.', 0 , 1);
$pdf->SetFont('Arial','',9);
$I=$I+7; 
$pdf->SetXY($J,$I);
$pdf->Cell(1, 6,'FECHA:',0,1,'R'); 
$pdf->SetXY($J,$I);
$pdf->Cell(70, 6,$HOY_ES, 0 , 1);
$pdf->MultiCell($L,5,'_____________________________________________________________________________________________',0,'C');
$pdf->Ln(3);
$pdf->MultiCell($L,4,utf8_decode('En atención a solicitud de pago de Patente presentado por la Asociacion, se remite la autorizacion para el pago de patente eventual de acuerdo a las siguientes caracteristicas:'),0,'J');
$pdf->Ln(2);
$pdf->SetFont('Arial','',7);
$pdf->SetWidths(array(80,100));
$pdf->Row(array('NOMBRE LA ASOCIACION',$ASOCIACION));
$pdf->Row(array('CANTIDAD DE AFILIADOS SEGUN '.$OM,$AFILIADOS));
//CUENTA LA CANTIDAD DE AFILIADOS AUTORIZADOS
$txtContri=0;
$res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.CODIGO_CONTRIBUYENTE,RCA.ESTADO_REGISTRO,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion' ");
		  	  while($row=mysql_fetch_array($res)){ $txtContri=$txtContri+1;}
			  
$pdf->Row(array('CANTIDAD AUTORIZADA PARA EL PAGO DE PATENTE ',$txtContri.' PUESTO(S) DE VENTA'));
$pdf->Row(array('ZONIFICACION ',$ZONATRIBUTARIA));
$pdf->Row(array('GESTION CORRESPONDIENTE AL PAGO ',$sltGestion));
$pdf->Row(array('LUGAR DE ASENTAMIENTO',$LUGARES_ASENT.' - '.$LUGARES_ASENTA));
$pdf->Row(array('NOMBRE DEL (LA) SECRETARIO (A) GENERAL',$SEC_GENERAL.' '.$CONTACTOS));
$pdf->Ln(2);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell($L,5,utf8_decode('A la presente se adjunta la lista de contribuyente(s) Autorizados para la emisión de los comprobantes de pago de Impuesto Anual Eventual para la gestión: '.$sltGestion.'.'),0,'J');
$pdf->Ln(2);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell($L,5,utf8_decode('Atentamente,'),0,'J');
$pdf->SetFont('Arial','',5);
$pdf->Ln(30);
$pdf->MultiCell($L,2,utf8_decode('c.c./Arch.'),0,'J');
$pdf->MultiCell($L,2,utf8_decode('c.c./D.F.M. '.$US_SIOI),0,'J');
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',9);
$pdf->MultiCell($L,5,utf8_decode('LISTA DE CONTRIBUYENTES HABILITADOS PARA EL COBRO DE IMPUESTO EVENTUAL ANUAL'),0,'C');
$pdf->MultiCell($L,5,utf8_decode($ASOCIACION),0,'C');
$pdf->MultiCell($L,5,utf8_decode('ZONA TRIBUTARIA '.$ZONATRIBUTARIA),0,'C');
$pdf->SetFont('Helvetica','B',7);
$pdf->SetWidths(array(6,30,55,20,65));
$pdf->Row(array('No.','DOCUMENTO DE IDENTIFICACION','NOMBRE(S) Y APELLIDO(S)','GESTION','DESCRIPCION DE PUESTO DE VENTA'));
$pdf->SetFont('Helvetica','',7);
//BUSCA LOS REGISTROS HABILITADOS
  $res=mysql_query("select  CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCA.GESTION,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO,RCA.Id,CONTRI.APELLIDO_ESPOSO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion'");
		  	  while($row=mysql_fetch_array($res)){
$conts++;
if($row['1']== null){$CIS=$row['0'].' '.$row['1'].' '.$row['2'];}else{$CIS=$row['0'].' - '.$row['1'].' '.$row['2'];};
if($row['6']== null){$NOMBRES=$row['3'].' '.$row['4'].' '.$row['5'];}else{$NOMBRES=$row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'];}
$pdf->Row(array($conts,$CIS,$NOMBRES,$row['7'],$row['8'].' '.$row['9'].' '.$row['10']));
//ACTUALIZA LOS REGISTROS DE LA COMUNICACION INTERNA
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET COMUNICACION_INTERNA='$COMUNICACION_INTERNA', ENLACE='$GESTION/$ENLACE' where Id='$row[14]' and CODIGO_REGISTRO='$CODIGO_REGISTRO' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");

}

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','COMUNICACION INTERNA PAGO DE IMPUESTO ANUAL','GENERO COMUNICACION INTERNA PAGO DE IMPUESTO ANUAL $sltGestion - $COMUNICACION_INTERNA','GENERO COMUNICACION INTERNA PAGO DE IMPUESTO ANUAL $sltGestion -  $COMUNICACION_INTERNA','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
//REGISTRA LA COMUNICACION INTERNA
$sql1="insert into reg_comunicacion_interna(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,COMUNICACION_INTERNA,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','$COMUNICACION_INTERNA','$GESTION/$ENLACE.pdf')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
require '../../Conexion_BD/Cerrar_Dbms.php';
$pdf->Output($GESTION.'/'.$ENLACE.'.pdf','F');
$pdf->Output();
?>