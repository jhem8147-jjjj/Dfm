<?php 
require_once('../../../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../../../Conexion_BD/Dbms.php';
require_once('tcpdf_include.php');

/**
 * PARA OBTENER LA IMPRESION DE UN SOLO PATENTE 
 * http://172.16.100.32/dfm/Otros_Ingresos/Reimpresion_Comprobante_Pago/tcpdf/Reproduccion/frmOriginalComprobanteReimpresion.php?COD_ASOCIACION=20190506%20114257&COD_REGISTRO=20211129%200948322645&id=318277
 * 
 * 
 */


// Función para limpiar y convertir caracteres especiales
function limpiarTexto($texto) {
    if (empty($texto)) return '';
    
    // Convertir a UTF-8 si no lo está
    if (!mb_check_encoding($texto, 'UTF-8')) {
        $texto = utf8_encode($texto);
    }
    
    // Reemplazar caracteres problemáticos
    $texto = str_replace(array('Ñ', 'ñ'), array('&Ntilde;', '&ntilde;'), $texto);
    $texto = str_replace(array('Á', 'É', 'Í', 'Ó', 'Ú'), array('&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'), $texto);
    $texto = str_replace(array('á', 'é', 'í', 'ó', 'ú'), array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;'), $texto);
    $texto = str_replace(array('Ü', 'ü'), array('&Uuml;', '&uuml;'), $texto);
    
    // Limpiar caracteres de control y no imprimibles
    $texto = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $texto);
    
    return trim($texto);
}

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Establecer codificación por defecto
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', '', 9);

// id corresponde al numero de registro 
$filtroAux = " ";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $filtroAux = " and id = " . intval($_GET['id']);
} 

$COD_ASOCIACION_SAFE = mysql_real_escape_string($COD_ASOCIACION);
$COD_REGISTRO_SAFE = mysql_real_escape_string($COD_REGISTRO);

$res = mysql_query("SELECT * FROM reg_contribuyente_asociacion_pago 
                   WHERE CODIGO_ASOCIACION='$COD_ASOCIACION_SAFE' 
                   AND CODIGO_REGISTRO='$COD_REGISTRO_SAFE' 
                   AND ESTADO='ACTIVO' $filtroAux");

if (!$res) {
    die('Error en la consulta: ' . mysql_error());
}

while ($rows = mysql_fetch_array($res)) {
    // Limpiar todos los campos de texto
    $rows['CONTRIBUYENTE'] = limpiarTexto($rows['CONTRIBUYENTE']);
    $rows['ASOCIACION'] = limpiarTexto($rows['ASOCIACION']);
    $rows['DIRECCION'] = limpiarTexto($rows['DIRECCION']);
    $rows['ZONA_UBICACION'] = limpiarTexto($rows['ZONA_UBICACION']);
    $rows['ACTIVIDAD'] = limpiarTexto($rows['ACTIVIDAD']);
    $rows['DESCRIPCION_1'] = limpiarTexto($rows['DESCRIPCION_1']);
    $rows['DESCRIPCION_2'] = limpiarTexto($rows['DESCRIPCION_2']);
    $rows['DESCRIPCION_3'] = limpiarTexto($rows['DESCRIPCION_3']);
    $rows['GLOSA_DESCRIPCION_1'] = limpiarTexto($rows['GLOSA_DESCRIPCION_1']);
    $rows['GLOSA_DESCRIPCION_2'] = limpiarTexto($rows['GLOSA_DESCRIPCION_2']);
    $rows['DESCRIPCION_2_1'] = limpiarTexto($rows['DESCRIPCION_2_1']);
    $rows['LITERAL'] = limpiarTexto($rows['LITERAL']);
    $rows['OBSERVACIONES'] = limpiarTexto($rows['OBSERVACIONES']);
    $rows['TRANSCRIPTOR'] = limpiarTexto($rows['TRANSCRIPTOR']);
    $rows['CAJERO'] = limpiarTexto($rows['CAJERO']);
    $rows['VERIFICADOR'] = limpiarTexto($rows['VERIFICADOR']);
    $rows['PAGO_REALIZADO'] = limpiarTexto($rows['PAGO_REALIZADO']);
    
    // Validar campos numéricos
    $rows['TOTAL1'] = isset($rows['TOTAL1']) ? floatval($rows['TOTAL1']) : 0;
    $rows['TOTAL2'] = isset($rows['TOTAL2']) ? floatval($rows['TOTAL2']) : 0;
    $rows['TOTAL3'] = isset($rows['TOTAL3']) ? floatval($rows['TOTAL3']) : 0;
    $rows['TOTAL'] = isset($rows['TOTAL']) ? floatval($rows['TOTAL']) : 0;
    
    if ($rows['TOTAL2'] == 0) {
        $MULTAS = '';
        $TAMANIO1 = 'font-size: 11px';
        $TAMANIO2 = 'font-size: 11.5px';
    } else {
        $TAMANIO1 = 'font-size: 11px';
        $TAMANIO2 = 'font-size: 11px';
        $MULTAS = number_format($rows['TOTAL2'], 2);
    }
    
    $pdf->AddPage();
    
    // Validar fecha de impresión
    $fecha_impresion = isset($rows['FECHA_IMPRESION']) ? $rows['FECHA_IMPRESION'] : date('d/m/Y');
    if (strlen($fecha_impresion) >= 10) {
        $dia = substr($fecha_impresion, 0, 2);
        $mes = substr($fecha_impresion, 3, 2);
        $anio = substr($fecha_impresion, 6, 4);
    } else {
        $dia = date('d');
        $mes = date('m');
        $anio = date('Y');
    }
    
    $ASOCIACIONES = $rows['ASOCIACION'];
    $CONTARDIRECCION = strlen($rows['DIRECCION']);
    
    // Formatear números
    $total1_formatted = number_format($rows['TOTAL1'], 2);
    $total3_formatted = number_format($rows['TOTAL3'], 2);
    $total_formatted = number_format($rows['TOTAL'], 2);
    
    // set some text to print
    $tbl = '
    <table width="100%" border="0" cellspacing="2" cellpadding="1">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="11%" rowspan="6"><br><br><img src="../../Img/vuelo2.png" width="116" style="max-width:116px;"/></td>
                        <td width="14%">&nbsp;</td>
                        <td width="54%">&nbsp;</td>
                        <td width="21%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="3" align="center" style="font-size: 18px; font-weight: bold; color: #F30;">000' . htmlspecialchars($rows['NRO_COMPROBANTE']) . '</td>
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
                        <td>
                            <table width="100%" height="27" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">' . $dia . '</td>
                                    <td align="center">' . $mes . '</td>
                                    <td align="center">' . $anio . '</td>
                                </tr>
                            </table>
                        </td>
                        <td align="center">ORIGINAL</td>
                        <td>VENTANILLA N&deg;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
                    <tr align="center">
                        <td height="29" colspan="2">Padr&oacute;n Placa Catastro Varios</td>
                        <td colspan="5">Nombre del Contribuyente o Raz&oacute;n Social</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td width="20%">N.I.T.:</td>
                                    <td width="80%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>C.I.:</td>
                                    <td>' . htmlspecialchars($rows['CEDULA_IDENTIDAD']) . '</td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="5" align="center">
                            <table width="100%" border="0" cellspacing="3" cellpadding="2">
                                <tr>
                                    <td align="center">' . $rows['CONTRIBUYENTE'] . '</td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-size: 9px">' . $rows['ASOCIACION'] . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" rowspan="2">P.M.C.:</td>
                        <td colspan="3" align="center">Avenida o Calle</td>
                        <td align="center">N&deg;</td>
                        <td colspan="2" align="center">Zona</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" style="font-size: 7px">' . $rows['DIRECCION'] . '</td>
                        <td align="center">-----</td>
                        <td colspan="2" align="center" style="font-size: 9px">' . $rows['ZONA_UBICACION'] . '</td>
                    </tr>
                    <tr>
                        <td height="30" colspan="7">
                            <table width="100%" border="0" cellspacing="3" cellpadding="3">
                                <tr>
                                    <td>Actividad: ' . $rows['ACTIVIDAD'] . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">C&Oacute;DIGO</td>
                        <td height="27" colspan="5" align="center">DESCRIPCI&Oacute;N</td>
                        <td align="center">IMPORTE</td>
                    </tr>
                    <tr>
                        <td align="left" style="' . $TAMANIO1 . '">
                            <blockquote>
                                <p>' . htmlspecialchars($rows['CODIGO_CUENTA1']) . '</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>' . htmlspecialchars($rows['CODIGO_CUENTA2']) . '</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>' . htmlspecialchars($rows['CODIGO_CUENTA3']) . '</p>
                            </blockquote>
                        </td>
                        <td colspan="5" align="left" style="' . $TAMANIO2 . '">
                            <blockquote>
                                <p>' . $rows['DESCRIPCION_1'] . '</p>
                                <p>' . $rows['GLOSA_DESCRIPCION_1'] . '</p>
                                <p>' . $rows['GLOSA_DESCRIPCION_2'] . '</p>
                                <p>' . $rows['DESCRIPCION_2'] . '</p>
                                <p>' . $rows['DESCRIPCION_2_1'] . '</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>' . $rows['DESCRIPCION_3'] . '</p>
                            </blockquote>
                        </td>
                        <td align="left" style="' . $TAMANIO1 . '">
                            <blockquote>
                                <p>' . $total1_formatted . '</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>' . $MULTAS . '</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>' . $total3_formatted . '</p>
                            </blockquote>
                        </td>
                    </tr>
                    <tr>
                        <td height="38" colspan="5">
                            <table width="100%" border="0" cellspacing="3" cellpadding="2">
                                <tr>
                                    <td>Son: ' . $rows['LITERAL'] . '</td>
                                    <td align="right">Bolivianos</td>
                                </tr>
                            </table>
                        </td>
                        <td align="right">
                            <table width="100%" border="0" cellspacing="2" cellpadding="3">
                                <tr>
                                    <td align="right">Importe a pagar</td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" valign="top">
                            <table width="100%" border="0" cellspacing="2" cellpadding="3">
                                <tr>
                                    <td align="center">' . $total_formatted . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Transcriptor</td>
                        <td colspan="6">Observaciones:</td>
                    </tr>
                    <tr>
                        <td height="39" align="center" style="font-size: 9px">' . $rows['TRANSCRIPTOR'] . '</td>
                        <td colspan="6"><p>' . $rows['OBSERVACIONES'] . '</p></td>
                    </tr>
                    <tr align="center">
                        <td colspan="2">Cajero</td>
                        <td>Verificador</td>
                        <td colspan="4" align="left">Pago realizado en:</td>
                    </tr>
                    <tr align="center">
                        <td colspan="2">
                            <p>' . $rows['CAJERO'] . '</p>
                            <p>&nbsp;</p>
                        </td>
                        <td>' . $rows['VERIFICADOR'] . '</td>
                        <td colspan="4" align="left">
                            <p>' . $rows['PAGO_REALIZADO'] . '</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';

    $pdf->writeHTML($tbl, true, false, false, false, '');
    
    if ($CONTARDIRECCION > 300) {
        $ESPACIO = '122';
    } else {
        $ESPACIO = '117';
    }
    
    // Limpiar datos para QR
    $qr_data = limpiarTexto($rows['NRO_COMPROBANTE'] . ' - ' . $rows['CEDULA_IDENTIDAD'] . ' ' . $rows['CONTRIBUYENTE'] . ', ' . $rows['GLOSA_DESCRIPCION_1'] . ', ' . $rows['OBSERVACIONES'] . ' Bs.- ' . $rows['TOTAL']);
    
    //[crv] 56 indica que el qr estara mas abajo en 2cm
    $pdf->write2DBarcode($qr_data, 'QRCODE,Q', 152, ($ESPACIO), 23, 23, $style, 'N');
    //break;
}

// REGISTRA LAS TRANSACCIONES
$COD_REGISTRO = date('Ymd His');

// Escapar variables para la inserción
$hostname_safe = mysql_real_escape_string($hostname);
$hostlocal_safe = mysql_real_escape_string($hostlocal);
$US_SIOI_safe = mysql_real_escape_string($US_SIOI);
$nombres_safe = mysql_real_escape_string($SIAUNOMBRES . ' ' . $USPRIMERAPELLIDO . ' ' . $SIAUSEGUNDOAPELLIDO);
$FECHA_safe = mysql_real_escape_string($FECHA);
$HORA_safe = mysql_real_escape_string($HORA);
$COD_REGISTRO_safe = mysql_real_escape_string($COD_REGISTRO);
$COD_ASOCIACION_safe = mysql_real_escape_string($COD_ASOCIACION);
$ASOCIACIONES_safe = mysql_real_escape_string($ASOCIACIONES);

$sql1 = "INSERT INTO reg_contribuyente_transacciones(
    PC_NAME, PC_IP, USUARIO, NOMBRE_USUARIO, FECHA, HORA, CODIGO_REGISTRO, 
    CODIGO_ASOCIACION, ASOCIACION, TRANSACCION_1, DESCRIPCION_TRAMITE, 
    OBSERVACIONES, ENLACE
) VALUES(
    '$hostname_safe', '$hostlocal_safe', '$US_SIOI_safe', '$nombres_safe', 
    '$FECHA_safe', '$HORA_safe', '$COD_REGISTRO_safe', '$COD_ASOCIACION_safe', 
    '$ASOCIACIONES_safe', 'REIMPRESION DE COMPROBANTE DE PAGO ORIGINAL', 
    'REIMPRESION DE COMPROBANTE DE PAGO ORIGINAL - $ASOCIACIONES_safe.', 
    'REIMPRESION DE COMPROBANTE DE PAGO ORIGINAL - $ASOCIACIONES_safe.', '0'
)";

$result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones: " . mysql_error());

require '../../../Conexion_BD/Cerrar_Dbms.php';

$pdf->Output('Comprobante_Pago_Original_Reimp.pdf', 'D');
exit;
?>
