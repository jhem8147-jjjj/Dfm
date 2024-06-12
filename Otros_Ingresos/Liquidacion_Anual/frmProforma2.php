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
}
$query = mysql_query("UPDATE nros_correlativos  SET NRO_REPORTE='$CODIGO_NRO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
$TOTAL=0;
 $cont=0;
$res=mysql_query("select RCHP.MONTO,RCHP.MANT_VALOR,RCHP.MIDF,RCHP.INTERES,RCHP.OTRAS_MULTAS,RCHP.FORMULARIO from reg_contribuyente_habilitado_pago RCHP where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.GESTION='$sltGestion' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO' and RCHP.ESTADO_REGISTRO='REGISTRO VALIDADO.' ");
	  while($row=mysql_fetch_array($res)){ $cont++; $TOTAL=$TOTAL+$row[0]+$row[1]+$row[2]+$row[3]+$row[4]+$row[5];
	  }

require('../Pdf_Fpdf/fpdf.php');
class PDF extends FPDF
{
    function SetDash($black=false, $white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
}

//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(30);
$pdf->Ln(10);
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,4,'DIRECCION DE ADMINISTRACION TRIBUTARIA MUNICIPAL',0,'C');
$pdf->Multicell(180,4,'AREA DE OTROS INGRESOS',0,'C');
$pdf->Multicell(180,4,'000'.$CODIGO_NRO,0,'C');

$pdf->Ln(2);
$pdf->SetDash(1,1);
//$pdf->Line(200,100,297,100);
$pdf->Ln(1);
$pdf->Multicell(70,4,'FECHA DE EMISION  '.date('d/m/Y'),1,'C');
$pdf->Ln(2);
$pdf->Multicell(180,4,utf8_decode('Numero de Cuenta Corriente :   10000004711912 - BANCO UNION S.A.'),0,'J');$pdf->Ln(1);
$pdf->Multicell(180,4,utf8_decode('Nombre de la Asociación:       '),0,'J');$pdf->Ln(1);
$pdf->Multicell(180,4,utf8_decode('" '.$ASOCIACION.' "'),0,'C');
$pdf->Ln(1);
 $pdf->Multicell(100,4,utf8_decode('Gestion:          	       	    '.$sltGestion),0,'J');
$pdf->Ln(2);
$pdf->Multicell(180,4,utf8_decode('Importe Total a Pagar:         Bs.- '.$TOTAL),0,'J');
$pdf->Ln();
$pdf->Multicell(180,6,utf8_decode('Traer 3 Fotocopias del Comprobante del Banco.'),1,'C');$pdf->Ln(3);
$pdf->Multicell(180,6,utf8_decode('La válides de la presente proforma tiene vigencia hasta la fecha.' .date('d/m/Y')),1,'C');
$pdf->Ln();

$pdf->Ln(40);
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','PROFORMA / ORDEN DE PAGO RESUMIDO.','EMISION DE PROFORMA / ORDEN DE PAGO RESUMIDO No. $CODIGO_NRO.','EMISION DE PROFORMA / ORDEN DE PAGO  RESUMIDO No. $CODIGO_NRO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 


$pdf->Ln(4);
//REGISTRA LA COMUNICACION INTERNA
$COD_REGISTRO=date('Ymd His');
$NOMBRE='REPORTE_000'.$CODIGO_NRO;
$sql1="insert into reg_documentos_generados(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,NRO_DOCUMENTO,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','REPORTE PROFORMA RESUMIDO  000$CODIGO_NRO','Reportes/$GESTION/ $NOMBRE.pdf')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); require '../Conexion_BD/Cerrar_Dbms.php';
$direccion=$serv.$GESTION.'/';
$pdf->Output($direccion.' '.$NOMBRE.'.pdf','F');
echo"<script language='javascript'>window.open('Reportes/$GESTION/ $NOMBRE.pdf','_self','');</script>";
		exit;

?>