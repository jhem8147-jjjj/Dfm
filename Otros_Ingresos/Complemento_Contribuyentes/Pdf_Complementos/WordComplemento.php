<?php

function complementoWordEscapeXml($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_XML1, 'UTF-8');
}

function complementoWordNormalizeAuthorityValue($value)
{
    $value = str_replace(
        array("\xC2\xA0", "\t", "\r", "\n"),
        ' ',
        (string)$value
    );
    $value = preg_replace('/ +/', ' ', $value);

    return trim($value);
}

function complementoWordParagraph($text, $options)
{
    $paragraphProperties = '';

    if (isset($options['align'])) {
        $paragraphProperties .= '<w:jc w:val="' . $options['align'] . '"/>';
    }

    if (isset($options['before']) || isset($options['after'])) {
        $before = isset($options['before']) ? (int)$options['before'] : 0;
        $after = isset($options['after']) ? (int)$options['after'] : 0;

        $paragraphProperties .=
            '<w:spacing w:before="' . $before .
            '" w:after="' . $after .
            '" w:line="275" w:lineRule="auto"/>';
    }

    if (!empty($options['borderBottom'])) {
        $paragraphProperties .=
            '<w:pBdr><w:bottom w:val="single" w:sz="8" w:space="4" w:color="222222"/></w:pBdr>';
    }

    if (!empty($options['keepNext'])) {
        $paragraphProperties .= '<w:keepNext/>';
    }

    if ($paragraphProperties !== '') {
        $paragraphProperties = '<w:pPr>' . $paragraphProperties . '</w:pPr>';
    }

    $runProperties =
        '<w:rFonts w:ascii="Liberation Sans" w:hAnsi="Liberation Sans" w:eastAsia="Liberation Sans"/>';

    if (!empty($options['bold'])) {
        $runProperties .= '<w:b/>';
    }

    if (!empty($options['underline'])) {
        $runProperties .= '<w:u w:val="single"/>';
    }

    if (isset($options['size'])) {
        $size = (int)$options['size'];
        $runProperties .=
            '<w:sz w:val="' . $size . '"/>' .
            '<w:szCs w:val="' . $size . '"/>';
    }

    if (isset($options['color'])) {
        $runProperties .=
            '<w:color w:val="' .
            complementoWordEscapeXml($options['color']) .
            '"/>';
    }

    $runs = '';
    $lines = explode("\n", (string)$text);

    foreach ($lines as $index => $line) {
        if ($index > 0) {
            $runs .= '<w:r><w:br/></w:r>';
        }

        $runs .=
            '<w:r><w:rPr>' . $runProperties . '</w:rPr>' .
            '<w:t xml:space="preserve">' .
            complementoWordEscapeXml($line) .
            '</w:t></w:r>';
    }

    return '<w:p>' . $paragraphProperties . $runs . '</w:p>';
}


// TABLAS DEL DOCUMENTO
function complementoWordTable($rows, $widths, $options)
{
    $totalWidth = array_sum($widths);

    $border = !empty($options['bordered']) ? 'single' : 'nil';

    $tableBorders = '<w:tblBorders>';

    foreach (array('top', 'left', 'bottom', 'right', 'insideH', 'insideV') as $side) {
        $sideBorder = $border;

        if (!empty($options['bottomOnly'])) {
            $sideBorder = $side === 'bottom' ? 'single' : 'nil';
        }

        if (!empty($options['separators']) && $side === 'insideV') {
            $sideBorder = 'double';
        }

        $tableBorders .=
            '<w:' . $side .
            ' w:val="' . $sideBorder .
            '" w:sz="6" w:space="0" w:color="222222"/>';
    }

    $tableBorders .= '</w:tblBorders>';

    $table =
        '<w:tbl><w:tblPr>' .
        '<w:tblW w:w="' . $totalWidth . '" w:type="dxa"/>' .
        '<w:tblLayout w:type="fixed"/>' .
        '<w:tblCellMar>' .
        '<w:top w:w="85" w:type="dxa"/>' .
        '<w:left w:w="90" w:type="dxa"/>' .
        '<w:bottom w:w="85" w:type="dxa"/>' .
        '<w:right w:w="90" w:type="dxa"/>' .
        '</w:tblCellMar>' .
        $tableBorders .
        '</w:tblPr><w:tblGrid>';

    foreach ($widths as $width) {
        $table .= '<w:gridCol w:w="' . (int)$width . '"/>';
    }

    $table .= '</w:tblGrid>';

    $hasGroupHeader = !empty($options['groupHeader']);
    if ($hasGroupHeader) {
        array_unshift($rows, $options['groupHeader']);
    }

    foreach ($rows as $rowIndex => $row) {
        $table .= '<w:tr><w:trPr><w:cantSplit/></w:trPr>';
        $gridColumnIndex = 0;

        foreach ($row as $cell) {
            $cellText = is_array($cell) ? $cell['text'] : $cell;
            $columnSpan = is_array($cell) && isset($cell['span'])
                ? (int)$cell['span']
                : 1;
            $verticalMerge = is_array($cell) && isset($cell['vMerge'])
                ? $cell['vMerge']
                : '';
            $cellWidth = array_sum(
                array_slice($widths, $gridColumnIndex, $columnSpan)
            );

            $isBold =
                (!empty($options['headerRow']) &&
                    ($hasGroupHeader ? $rowIndex <= 1 : $rowIndex === 0)) ||
                (!empty($options['boldFirstColumn']) && $gridColumnIndex === 0) ||
                (is_array($cell) && !empty($cell['bold']));

            $alignment =
                is_array($cell) && isset($cell['align'])
                ? $cell['align']
                : 'left';

            $cellParagraph = complementoWordParagraph(
                $cellText,
                array(
                    'size' => isset($options['fontSize'])
                        ? $options['fontSize']
                        : 18,
                    'bold' => $isBold,
                    'align' => $alignment,
                    'after' => 0
                )
            );

            $table .=
                '<w:tc><w:tcPr>' .
                '<w:tcW w:w="' . (int)$cellWidth . '" w:type="dxa"/>' .
                ($columnSpan > 1
                    ? '<w:gridSpan w:val="' . $columnSpan . '"/>'
                    : '') .
                ($verticalMerge === 'restart'
                    ? '<w:vMerge w:val="restart"/>'
                    : ($verticalMerge === 'continue' ? '<w:vMerge/>' : '')) .
                ($hasGroupHeader && $rowIndex === 0
                    ? '<w:tcBorders>' .
                        '<w:top w:val="single" w:sz="6" w:color="222222"/>' .
                        '<w:left w:val="single" w:sz="6" w:color="222222"/>' .
                        '<w:bottom w:val="single" w:sz="6" w:color="222222"/>' .
                        '<w:right w:val="single" w:sz="6" w:color="222222"/>' .
                      '</w:tcBorders>'
                    : '') .
                '<w:vAlign w:val="center"/>' .
                '</w:tcPr>' .
                $cellParagraph .
                '</w:tc>';
            $gridColumnIndex += $columnSpan;
        }

        $table .= '</w:tr>';
    }

    return $table . '</w:tbl>';
}


// DESTINATARIOS SIN BORDES
function complementoWordAutoridad($etiqueta, $nombre, $cargo)
{
    $etiqueta = complementoWordNormalizeAuthorityValue($etiqueta);
    $nombre = complementoWordNormalizeAuthorityValue($nombre);
    $cargo = complementoWordNormalizeAuthorityValue($cargo);
    if ($etiqueta === '' || $nombre === '' || $cargo === '') {
        return '';
    }

    $etiqueta = complementoWordEscapeXml($etiqueta);
    $nombre = complementoWordEscapeXml($nombre);
    $cargo = complementoWordEscapeXml($cargo);

    $institucion = complementoWordEscapeXml(
        'GOBIERNO AUTÓNOMO MUNICIPAL DE EL ALTO'
    );

    $tabs = '<w:tabs><w:tab w:val="left" w:pos="1400"/></w:tabs>';

    $normal =
        '<w:rFonts w:ascii="Liberation Sans" w:hAnsi="Liberation Sans"/>' .
        '<w:sz w:val="21"/><w:szCs w:val="21"/>';

    $bold =
        '<w:rFonts w:ascii="Liberation Sans" w:hAnsi="Liberation Sans"/>' .
        '<w:b/><w:sz w:val="21"/><w:szCs w:val="21"/>';

    $p =
        '<w:p><w:pPr>' . $tabs .
        '<w:spacing w:after="0" w:line="265" w:lineRule="auto"/>' .
        '</w:pPr>';

    $p .=
        '<w:r><w:rPr>' . $bold . '</w:rPr>' .
        '<w:t>' . $etiqueta . '</w:t></w:r>' .
        '<w:r><w:tab/></w:r>';

    $p .=
        '<w:r><w:rPr>' . $normal . '</w:rPr>' .
        '<w:t>' . $nombre . '</w:t></w:r></w:p>';

    foreach (array($cargo, $institucion) as $linea) {
        $p .=
            '<w:p><w:pPr>' . $tabs .
            '<w:spacing w:after="0" w:line="265" w:lineRule="auto"/>' .
            '</w:pPr>';

        $p .=
            '<w:r><w:tab/></w:r>' .
            '<w:r><w:rPr>' . $bold . '</w:rPr>' .
            '<w:t>' . $linea . '</w:t></w:r></w:p>';
    }

    return $p;
}


// IMAGEN INSTITUCIONAL
function complementoWordImageDrawing($relationshipId, $name, $width, $height, $drawingId)
{
    return
        '<w:r><w:drawing>' .
        '<wp:inline distT="0" distB="0" distL="0" distR="0">' .
        '<wp:extent cx="' . (int)$width . '" cy="' . (int)$height . '"/>' .
        '<wp:docPr id="' . (int)$drawingId . '" name="' .
        complementoWordEscapeXml($name) . '"/>' .
        '<wp:cNvGraphicFramePr>' .
        '<a:graphicFrameLocks noChangeAspect="1"/>' .
        '</wp:cNvGraphicFramePr>' .
        '<a:graphic>' .
        '<a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture">' .
        '<pic:pic>' .
        '<pic:nvPicPr>' .
        '<pic:cNvPr id="' . (int)$drawingId . '" name="' .
        complementoWordEscapeXml($name) . '"/>' .
        '<pic:cNvPicPr/>' .
        '</pic:nvPicPr>' .
        '<pic:blipFill>' .
        '<a:blip r:embed="' . $relationshipId . '"/>' .
        '<a:stretch><a:fillRect/></a:stretch>' .
        '</pic:blipFill>' .
        '<pic:spPr>' .
        '<a:xfrm>' .
        '<a:off x="0" y="0"/>' .
        '<a:ext cx="' . (int)$width . '" cy="' . (int)$height . '"/>' .
        '</a:xfrm>' .
        '<a:prstGeom prst="rect"><a:avLst/></a:prstGeom>' .
        '</pic:spPr>' .
        '</pic:pic>' .
        '</a:graphicData>' .
        '</a:graphic>' .
        '</wp:inline>' .
        '</w:drawing></w:r>';
}

function complementoWordCreateZip($path, $files)
{
    if (!function_exists('gzdeflate')) {
        throw new RuntimeException(
            'PHP requiere la extensión zlib para crear el documento Word.'
        );
    }

    $zipData = '';
    $centralDirectory = '';
    $offset = 0;
    $fileCount = 0;
    $dosTime = ((int)date('G') << 11) |
        ((int)date('i') << 5) |
        (int)floor((int)date('s') / 2);
    $year = max(1980, (int)date('Y'));
    $dosDate = (($year - 1980) << 9) |
        ((int)date('n') << 5) |
        (int)date('j');

    foreach ($files as $name => $contents) {
        $name = str_replace('\\', '/', $name);
        if (strpos($name, 'word/media/') === 0) {
            $contents = file_get_contents($contents);
            if ($contents === false) {
                throw new RuntimeException(
                    'No se pudo leer un archivo requerido para el documento Word.'
                );
            }
        }

        $compressed = gzdeflate($contents, 6);
        if ($compressed === false) {
            throw new RuntimeException(
                'No se pudo comprimir un archivo requerido para el documento Word.'
            );
        }

        $nameLength = strlen($name);
        $contentsLength = strlen($contents);
        $compressedLength = strlen($compressed);
        $checksum = crc32($contents);
        $localHeader = pack(
            'VvvvvvVVVvv',
            0x04034b50,
            20,
            0,
            8,
            $dosTime,
            $dosDate,
            $checksum,
            $compressedLength,
            $contentsLength,
            $nameLength,
            0
        );

        $centralDirectory .= pack(
            'VvvvvvvVVVvvvvvVV',
            0x02014b50,
            20,
            20,
            0,
            8,
            $dosTime,
            $dosDate,
            $checksum,
            $compressedLength,
            $contentsLength,
            $nameLength,
            0,
            0,
            0,
            0,
            0,
            $offset
        ) . $name;

        $zipData .= $localHeader . $name . $compressed;
        $offset += strlen($localHeader) + $nameLength + $compressedLength;
        $fileCount++;
    }

    $centralDirectoryOffset = strlen($zipData);
    $centralDirectoryLength = strlen($centralDirectory);
    $zipData .= $centralDirectory;
    $zipData .= pack(
        'VvvvvVVv',
        0x06054b50,
        0,
        0,
        $fileCount,
        $fileCount,
        $centralDirectoryLength,
        $centralDirectoryOffset,
        0
    );

    if (file_put_contents($path, $zipData) === false) {
        throw new RuntimeException(
            'No se pudo escribir el archivo Word temporal.'
        );
    }
}


// GENERAR COMUNICACIÓN INTERNA
function generarWordComplementacion($ruta, $nombreArchivo, $datos)
{
    $imagenCabecera =
        dirname(dirname(dirname(dirname(__FILE__)))) . '/images/cabecera.png';

    $imagenPie =
        dirname(dirname(dirname(dirname(__FILE__)))) . '/images/pie_de_pagina.png';

    if (!is_readable($imagenCabecera) || !is_readable($imagenPie)) {
        throw new RuntimeException(
            'No se encuentran las imágenes institucionales de cabecera y pie.'
        );
    }

    $cabeceraInfo = getimagesize($imagenCabecera);
    $pieInfo = getimagesize($imagenPie);

    if (
        !$cabeceraInfo ||
        $cabeceraInfo['mime'] !== 'image/png' ||
        !$pieInfo ||
        $pieInfo['mime'] !== 'image/png'
    ) {
        throw new RuntimeException(
            'Las imágenes institucionales deben ser archivos PNG válidos.'
        );
    }

    // CONTENIDO DEL DOCUMENTO
    $contenido = '';

    // TÍTULO
    $contenido .= complementoWordParagraph(
        'COMUNICACIÓN INTERNA',
        array(
            'align' => 'center',
            'bold' => true,
            'underline' => true,
            'size' => 26,
            'after' => 40,
            'keepNext' => true
        )
    );

    // NÚMERO DE COMUNICACIÓN
    $contenido .= complementoWordParagraph(
        $datos['numero'],
        array(
            'align' => 'center',
            'bold' => true,
            'size' => 20,
            'after' => 120,
            'keepNext' => true
        )
    );

    // FECHA Y CÓDIGOS
    $contenido .= complementoWordTable(
        array(
            array(
                array(
                    'text' => "FECHA:\n" . $datos['fecha'],
                    'align' => 'center'
                ),
                array(
                    'text' => $datos['numero'],
                    'align' => 'center'
                ),
                array(
                    'text' => "GOBIERNO AUTÓNOMO\nMUNICIPAL DE EL ALTO",
                    'align' => 'center'
                )
            )
        ),
        array(1850, 4250, 2740),
        array(
            'fontSize' => 18,
            'bottomOnly' => true,
            'separators' => true
        )
    );

    $contenido .= complementoWordParagraph(
        '',
        array('size' => 8, 'after' => 180)
    );

    // DESTINATARIOS
    foreach ($datos['destinatarios'] as $destinatario) {
        $autoridadXml = complementoWordAutoridad(
            $destinatario['etiqueta'],
            $destinatario['nombre'],
            $destinatario['cargo']
        );

        if ($autoridadXml === '') {
            continue;
        }

        $contenido .= $autoridadXml;
        $contenido .= complementoWordParagraph(
            '',
            array('size' => 8, 'after' => 190)
        );
    }

    // EMISOR
    $contenido .= complementoWordAutoridad(
        'DE:',
        $datos['emisor'],
        $datos['cargoEmisor']
    );

    $contenido .= complementoWordParagraph(
        '',
        array('size' => 8, 'after' => 190)
    );

    // REFERENCIA
    $contenido .= complementoWordTable(
        array(
            array(
                array('text' => 'REF.:', 'bold' => true),
                array(
                    'text' => isset($datos['referencia'])
                        ? $datos['referencia']
                        : (
                        'AUTORIZACIÓN DE PAGO DE COMPLEMENTO GESTIÓN: ' .
                        $datos['gestion']
                        ),
                    'bold' => true
                )
            )
        ),
        array(1100, 7740),
        array('fontSize' => 20)
    );

    $contenido .= complementoWordParagraph(
        '',
        array(
            'size' => 4,
            'borderBottom' => true,
            'after' => 130
        )
    );

    // INTRODUCCIÓN
    $contenido .= complementoWordParagraph(
        $datos['introduccion'],
        array(
            'size' => 21,
            'align' => 'both',
            'after' => 160
        )
    );

    // RESUMEN DE LA ASOCIACIÓN
    $contenido .= complementoWordTable(
        $datos['resumen'],
        array(3000, 5840),
        array(
            'fontSize' => 19,
            'bordered' => true
        )
    );

    if (isset($datos['parrafoAdicional']) && $datos['parrafoAdicional'] !== '') {
        $contenido .= complementoWordParagraph(
            $datos['parrafoAdicional'],
            array(
                'size' => 19,
                'align' => 'both',
                'before' => 100,
                'after' => 100
            )
        );
    }

    // LISTA DE CONTRIBUYENTES
    $contenido .= complementoWordParagraph(
        isset($datos['tituloLista'])
            ? $datos['tituloLista']
            : 'A continuación se detalla la lista de contribuyente(s):',
        array(
            'size' => 20,
            'before' => 170,
            'after' => 100,
            'keepNext' => true
        )
    );

    $filasContribuyentes = array(
        isset($datos['encabezadoContribuyentes'])
            ? $datos['encabezadoContribuyentes']
            : array(
                'No.',
                'DOC. DE IDENTIFICACIÓN',
                'NOMBRE(S) Y APELLIDO(S)',
                'ACTIVIDAD',
                'FILA',
                'PUESTO'
            )
    );

    foreach ($datos['contribuyentes'] as $contribuyente) {
        $filasContribuyentes[] = $contribuyente;
    }

    $contenido .= complementoWordTable(
        $filasContribuyentes,
        isset($datos['anchosContribuyentes'])
            ? $datos['anchosContribuyentes']
            : array(440, 1500, 2800, 1450, 1250, 1400),
        array(
            'fontSize' => isset($datos['tamanoLetraTablaContribuyentes'])
                ? (int)$datos['tamanoLetraTablaContribuyentes'] * 2
                : 17,
            'bordered' => true,
            'headerRow' => true,
            'groupHeader' => isset($datos['grupoEncabezadoContribuyentes'])
                ? $datos['grupoEncabezadoContribuyentes']
                : array()
        )
    );

    if (isset($datos['detalleFinal']) && $datos['detalleFinal'] !== '') {
        $contenido .= complementoWordParagraph(
                $datos['detalleFinal'],
                array(
                    'size' => 14,
                    'before' => 80,
                    'after' => 100
                )
        );
    }

    // CIERRE
    $contenido .= complementoWordParagraph(
        isset($datos['cierre']) ? $datos['cierre'] : 'Atentamente:',
        array(
            'size' => 20,
            'before' => 200,
            'after' => 0
        )
    );

    $contenido .= complementoWordParagraph(
        '',
        array('size' => 12, 'after' => 420)
    );

    $contenido .= complementoWordParagraph(
        isset($datos['copias'])
            ? implode("\n", $datos['copias'])
            : 'c.c./Arch.' . "\n" . 'c.c./D.F.M.' . $datos['usuario'],
        array(
            'size' => 14,
            'after' => 0
        )
    );

    // DIMENSIONES DE LAS IMÁGENES
    // 5.800.000 EMU equivalen aproximadamente a 15,22 cm.
    $anchoImagenCabecera = 5800000;

    $altoImagenCabecera = (int)round(
        $anchoImagenCabecera *
        $cabeceraInfo[1] /
        $cabeceraInfo[0]
    );

    $anchoImagenPie = 5800000;

    $altoImagenPie = (int)round(
        $anchoImagenPie *
        $pieInfo[1] /
        $pieInfo[0]
    );

    // ESPACIOS DE NOMBRES XML
    $namespaces =
        'xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ' .
        'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" ' .
        'xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" ' .
        'xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" ' .
        'xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture"';

    // CABECERA
    $headerXml =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<w:hdr ' . $namespaces . '>' .
        '<w:p><w:pPr>' .
        '<w:jc w:val="center"/>' .
        '<w:spacing w:after="0"/>' .
        '</w:pPr>' .
        complementoWordImageDrawing(
            'rId1',
            'Cabecera institucional',
            $anchoImagenCabecera,
            $altoImagenCabecera,
            1
        ) .
        '</w:p></w:hdr>';

    // PIE DE PÁGINA
    $footerXml =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<w:ftr ' . $namespaces . '>' .
        '<w:p><w:pPr>' .
        '<w:jc w:val="center"/>' .
        '<w:spacing w:before="0"/>' .
        '</w:pPr>' .
        complementoWordImageDrawing(
            'rId1',
            'Pie de página institucional',
            $anchoImagenPie,
            $altoImagenPie,
            2
        ) .
        '</w:p>' .
        '<w:p><w:pPr><w:jc w:val="right"/></w:pPr>' .
        '<w:r><w:fldChar w:fldCharType="begin"/></w:r>' .
        '<w:r><w:instrText xml:space="preserve"> PAGE </w:instrText></w:r>' .
        '<w:r><w:fldChar w:fldCharType="end"/></w:r>' .
        '</w:p>' .
        '</w:ftr>';

    // DOCUMENTO PRINCIPAL
    // Página carta: 12240 x 15840 twips.
    // Márgenes laterales: 1700 twips, aproximadamente 3 cm.
    // Ancho útil: 12240 - 1700 - 1700 = 8840 twips.
    $documentXml =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<w:document ' . $namespaces . '>' .
        '<w:body>' .
        $contenido .
        '<w:sectPr>' .
        '<w:headerReference w:type="default" r:id="rId1"/>' .
        '<w:footerReference w:type="default" r:id="rId2"/>' .
        '<w:pgSz w:w="12240" w:h="15840"/>' .
        '<w:pgMar ' .
        'w:top="2100" ' .
        'w:right="1700" ' .
        'w:bottom="1300" ' .
        'w:left="1700" ' .
        'w:header="200" ' .
        'w:footer="420" ' .
        'w:gutter="0"/>' .
        '</w:sectPr>' .
        '</w:body></w:document>';

    // TIPOS DE CONTENIDO DOCX
    $contentTypes =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">' .
        '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>' .
        '<Default Extension="xml" ContentType="application/xml"/>' .
        '<Default Extension="png" ContentType="image/png"/>' .
        '<Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>' .
        '<Override PartName="/word/header1.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml"/>' .
        '<Override PartName="/word/footer1.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"/>' .
        '</Types>';

    $packageRels =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
        '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>' .
        '</Relationships>';

    $documentRels =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
        '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/header" Target="header1.xml"/>' .
        '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer" Target="footer1.xml"/>' .
        '</Relationships>';

    $headerRels =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
        '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/cabecera.png"/>' .
        '</Relationships>';

    $footerRels =
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
        '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
        '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/pie_de_pagina.png"/>' .
        '</Relationships>';

    // RUTAS DEL ARCHIVO GENERADO
    $temporaryPath = $ruta . '/' . $nombreArchivo . '.tmp.zip';
    $finalPath = $ruta . '/' . $nombreArchivo . '.docx';

    if (file_exists($temporaryPath) && !unlink($temporaryPath)) {
        throw new RuntimeException(
            'No se pudo limpiar el archivo temporal DOCX anterior.'
        );
    }

    // CREAR DOCUMENTO DOCX SIN DEPENDER DE PharData/ZipArchive
    try {
        complementoWordCreateZip(
            $temporaryPath,
            array(
                '[Content_Types].xml' => $contentTypes,
                '_rels/.rels' => $packageRels,
                'word/document.xml' => $documentXml,
                'word/_rels/document.xml.rels' => $documentRels,
                'word/header1.xml' => $headerXml,
                'word/_rels/header1.xml.rels' => $headerRels,
                'word/footer1.xml' => $footerXml,
                'word/_rels/footer1.xml.rels' => $footerRels,
                'word/media/cabecera.png' => $imagenCabecera,
                'word/media/pie_de_pagina.png' => $imagenPie
            )
        );
    } catch (Exception $exception) {
        if (file_exists($temporaryPath)) {
            unlink($temporaryPath);
        }

        throw new RuntimeException(
            'No se pudo crear el documento Word DOCX: ' .
            $exception->getMessage()
        );
    }

    // GUARDAR ARCHIVO FINAL
    if (!rename($temporaryPath, $finalPath)) {
        if (file_exists($temporaryPath)) {
            unlink($temporaryPath);
        }

        throw new RuntimeException(
            'No se pudo guardar el documento Word DOCX en el directorio de generación.'
        );
    }

    return $finalPath;
}
