<?php
require_once('../../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../../Conexion_BD/Dbms.php';
require_once 'mc_table.php';

$CODIGO_REGISTRO = isset($_GET['CODIGO_REGISTRO']) && is_scalar($_GET['CODIGO_REGISTRO'])
    ? trim((string)$_GET['CODIGO_REGISTRO'])
    : '';
$COD_ASOCIACION = isset($_GET['COD_ASOCIACION']) && is_scalar($_GET['COD_ASOCIACION'])
    ? trim((string)$_GET['COD_ASOCIACION'])
    : '';
if ($CODIGO_REGISTRO === '' || $COD_ASOCIACION === '') {
    die('FALTAN DATOS PARA GENERAR LA NOMINA DE CAMBIO DE NOMBRE.');
}

$CODIGO_REGISTRO_SQL = mysql_real_escape_string($CODIGO_REGISTRO);
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$res = mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,RCHPC.TIPO_PUESTO,RCHPC.FILA,RCHPC.PUESTO from reg_contribuyente_habilitado_pago_cambio_nombre RCHPC inner join contribuyentes C on RCHPC.CODIGO_CONTRIBUYENTE_ENTRANTE=C.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO' where RCHPC.CODIGO_REGISTRO='$CODIGO_REGISTRO_SQL' and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RCHPC.ESTADO='ACTIVO' order by C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO")
    or die('NO SE PUDO CONSULTAR LA NOMINA DE CAMBIO DE NOMBRE. DETALLE: ' . htmlspecialchars(mysql_error(), ENT_QUOTES, 'UTF-8'));

$contribuyentes = array();
while ($row = mysql_fetch_assoc($res)) {
    $contribuyentes[] = $row;
}
if (count($contribuyentes) === 0) {
    die('NO SE ENCONTRARON CONTRIBUYENTES ACTIVOS PARA ESTA NOMINA.');
}

$asociacion = isset($_GET['ASOCIACION']) && is_scalar($_GET['ASOCIACION'])
    ? trim((string)$_GET['ASOCIACION'])
    : '';
require '../../Conexion_BD/Cerrar_Dbms.php';

$pdf = new PDF_MC_Table('P', 'mm', array(216,279));
$pdf->AddPage();
$pdf->SetMargins(20, 1, 15);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Ln(10);
$pdf->MultiCell(180, 5, 'NOMINA DE CONTRIBUYENTES HABILITADOS', 0, 'C');
$pdf->MultiCell(180, 5, 'CAMBIO DE NOMBRE', 0, 'C');
$pdf->MultiCell(180, 5, '"' . utf8_decode($asociacion) . '"', 0, 'C');
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(15,30,60,35,25,15));
$pdf->Row(array('Nro.', 'DOCUMENTO DE IDENTIFICACION', 'NOMBRE(S) Y APELLIDO(S)', 'ACTIVIDAD', 'FILA', 'PUESTO'));

foreach ($contribuyentes as $index => $row) {
    $documento = $row['DOC_IDENTIDAD_ALFA'] === null || $row['DOC_IDENTIDAD_ALFA'] === ''
        ? $row['DOC_IDENTIDAD'] . ' ' . $row['EXPEDIDO']
        : $row['DOC_IDENTIDAD'] . ' - ' . $row['DOC_IDENTIDAD_ALFA'] . ' ' . $row['EXPEDIDO'];
    $nombre = trim($row['NOMBRE_RSOCIAL'] . ' ' . $row['PRIMER_APELLIDO'] . ' ' . $row['SEGUNDO_APELLIDO']);
    if ($row['APELLIDO_ESPOSO'] !== null && $row['APELLIDO_ESPOSO'] !== '') {
        $nombre .= ' de ' . $row['APELLIDO_ESPOSO'];
    }
    $pdf->Row(array(
        $index + 1,
        utf8_decode($documento),
        utf8_decode($nombre),
        utf8_decode($row['TIPO_PUESTO']),
        utf8_decode($row['FILA']),
        utf8_decode($row['PUESTO'])
    ));
}

$pdf->Output('I', 'nomina-cambio-nombre.pdf');
?>