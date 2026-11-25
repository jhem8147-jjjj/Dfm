<?php
ob_start();

require_once('../../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../../Conexion_BD/Dbms.php';
require_once('mc_table.php');

$GESTION = date('Y');
$conts = 0;

// Verificar las variables que recibe el archivo
$CODIGO_REGISTRO = isset($CODIGO_REGISTRO) ? $CODIGO_REGISTRO : '';
$COD_ASOCIACION = isset($COD_ASOCIACION) ? $COD_ASOCIACION : '';
$ASOCIACION = isset($ASOCIACION) ? $ASOCIACION : '';

class PDF extends FPDF
{
    public function Footer()
    {
        parent::Footer();
        foreach ($this->listeners as $l) {
            $l->onFooter();
        }
    }
}

// Consulta original del sistema
$res = mysql_query("SELECT C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,C.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_PUESTO,RCHPC.FILA,RCHPC.PUESTO FROM reg_contribuyente_habilitado_pago_cambio_nombre RCHPC,contribuyentes C WHERE RCHPC.CODIGO_REGISTRO='$CODIGO_REGISTRO' AND RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' AND RCHPC.ESTADO='ACTIVO' AND RCHPC.CODIGO_CONTRIBUYENTE_ENTRANTE=C.CODIGO_CONTRIBUYENTE AND C.ESTADO='ACTIVO' ORDER BY C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO");

if ($res === false) {
    error_log('Error SQL en nomina de cambio de nombre: '.mysql_error());
    ob_end_clean();
    die('No se pudo consultar la nomina. Revise el registro de errores de PHP.');
}

// Diagnostico temporal si no hay registros
if (mysql_num_rows($res) == 0) {
    ob_end_clean();

    header('Content-Type: text/html; charset=UTF-8');

    echo '<h3>No se encontraron contribuyentes para la nomina.</h3>';
    echo 'CODIGO_REGISTRO: '.htmlspecialchars($CODIGO_REGISTRO, ENT_QUOTES, 'UTF-8').'<br>';
    echo 'COD_ASOCIACION: '.htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8').'<br>';
    echo 'ASOCIACION: '.htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8').'<br>';
    echo 'REGISTROS ENCONTRADOS: 0';

    exit;
}

// Crear el documento PDF
$pdf = new PDF_MC_Table('P','mm',array(216,279));
$pdf->AddPage();

$L = 180;

$pdf->SetMargins(20,1,15);
$pdf->SetFont('Arial','B',11);
$pdf->Ln(10);

$pdf->MultiCell($L,5,'NOMINA DE CONTRIBUYENTES HABILITADOS',0,'C');
$pdf->MultiCell($L,5,'CAMBIO DE NOMBRE',0,'C');
$pdf->MultiCell($L,5,'"'.$ASOCIACION.'"',0,'C');

$pdf->Ln(2);
$pdf->SetFont('Arial','',8);

$pdf->SetWidths(array(15,30,60,35,25,15));

$pdf->Row(array(
    '  Nro.',
    '  DOCUMENTO DE IDENTIFICACION',
    '         NOMBRE(S) Y APELLIDO(S)',
    'ACTIVIDAD',
    'FILA',
    'PUESTO'
));

// Recorrer los contribuyentes encontrados
while ($row = mysql_fetch_array($res)) {
    $conts++;

    if ($row[1] == null) {
        $CIS = $row[0].' '.$row[2];
    } else {
        $CIS = $row[0].' - '.$row[1].' '.$row[2];
    }

    if ($row[6] == null) {
        $NOMBRES = $row[3].' '.$row[4].' '.$row[5];
    } else {
        $NOMBRES = $row[3].' '.$row[4].' '.$row[5].' de '.$row[6];
    }

    $pdf->Row(array(
        $conts,
        $CIS,
        $NOMBRES,
        $row[9],
        $row[10],
        $row[11]
    ));
}

require '../../Conexion_BD/Cerrar_Dbms.php';

// Limpiar cualquier salida anterior al PDF
while (ob_get_level() > 0) {
    ob_end_clean();
}

// Generar el PDF una sola vez
$NOMBRE = rand(10000,10000000);
$pdf->Output($NOMBRE.'.pdf','I');
