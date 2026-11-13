<?php

class ComunicacionInternaStyledPdf extends PDF_MC_Table
{
    var $headerImage;
    var $footerImage;
    var $tableHeader;
    var $tableHeaderWidths;
    var $tableHeaderFontSize;

    function SetInstitutionalImages($headerImage, $footerImage)
    {
        if (!is_readable($headerImage) || !is_readable($footerImage)) {
            throw new RuntimeException('No se encuentran las imágenes institucionales de cabecera y pie.');
        }

        $this->headerImage = $headerImage;
        $this->footerImage = $footerImage;
    }

    function Header()
    {
        if ($this->headerImage) {
            $this->Image($this->headerImage, 30, 6, 156);
        }
    }

    function Footer()
    {
        if ($this->footerImage) {
            $this->Image($this->footerImage, 30, 257, 156);
        }
        $this->SetY(-9);
        $this->SetFont('Arial', '', 7);
        $this->Cell(156, 4, $this->PageNo(), 0, 0, 'R');
    }

    function SetCommunicationTableHeader($data, $widths, $fontSize)
    {
        $this->tableHeader = $this->EncodeRow($data);
        $this->tableHeaderWidths = $widths;
        $this->tableHeaderFontSize = $fontSize;
    }

    function CommunicationPageBreakNeeded($height)
    {
        return $this->GetY() + $height > $this->PageBreakTrigger;
    }

    function CommunicationTableRow($data, $header, $fontSize)
    {
        $data = $this->EncodeRow($data);
        $this->SetWidths($this->tableHeaderWidths);

        $lineHeight = $header ? 4.2 : 3.8;
        $this->SetFont('Arial', $header ? 'B' : '', $fontSize);
        $lines = 1;
        for ($i = 0; $i < count($data); $i++) {
            $lines = max($lines, $this->NbLines($this->tableHeaderWidths[$i], $data[$i]));
        }
        $height = $lineHeight * $lines;

        if ($this->GetY() + $height > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            if (!$header && $this->tableHeader) {
                $this->DrawCommunicationTableRow(
                    $this->tableHeader,
                    true,
                    $this->tableHeaderFontSize,
                    4.2
                );
            }
        }

        $this->DrawCommunicationTableRow($data, $header, $fontSize, $lineHeight);
    }

    function DrawCommunicationTableRow($data, $header, $fontSize, $lineHeight)
    {
        $this->SetFont('Arial', $header ? 'B' : '', $fontSize);

        $lines = 1;
        for ($i = 0; $i < count($data); $i++) {
            $lines = max($lines, $this->NbLines($this->tableHeaderWidths[$i], $data[$i]));
        }
        $height = $lineHeight * $lines;

        for ($i = 0; $i < count($data); $i++) {
            $width = $this->tableHeaderWidths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $width, $height, 'D');
            $this->MultiCell($width, $lineHeight, $data[$i], 0, $i === 0 ? 'C' : 'L');
            $this->SetXY($x + $width, $y);
        }

        $this->SetXY(30, $this->GetY() + $height);
    }

    function EncodeRow($data)
    {
        $encoded = array();
        foreach ($data as $value) {
            $encoded[] = comunicacionInternaPdfEncode($value);
        }
        return $encoded;
    }
}

function comunicacionInternaPdfEncode($value)
{
    $value = (string)$value;
    return preg_match('//u', $value) ? utf8_decode($value) : $value;
}

function comunicacionInternaPdfCreate($pageSize)
{
    $pdf = new ComunicacionInternaStyledPdf('P', 'mm', $pageSize);
    $pdf->SetMargins(30, 40, 30);
    $pdf->SetAutoPageBreak(true, 27);
    $pdf->SetInstitutionalImages(
        dirname(dirname(__FILE__)) . '/images/cabecera.png',
        dirname(dirname(__FILE__)) . '/images/pie_de_pagina.png'
    );
    return $pdf;
}

function comunicacionInternaPdfBegin($pdf, $number, $date, $destinatarios, $emisor, $cargoEmisor)
{
    $pdf->AddPage();
    $pdf->SetX(30);
    $pdf->SetFont('Arial', 'BU', 13);
    $pdf->Cell(156, 6, comunicacionInternaPdfEncode('COMUNICACIÓN INTERNA'), 0, 1, 'C');
    $pdf->SetX(30);
    $pdf->SetFont('Arial', 'B', 10.5);
    $pdf->Cell(156, 6, comunicacionInternaPdfEncode($number), 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX(30);
    $pdf->Cell(28, 5, 'FECHA:', 0, 0, 'L');
    $pdf->Cell(72, 5, comunicacionInternaPdfEncode($date), 0, 0, 'L');
    $pdf->Cell(56, 5, comunicacionInternaPdfEncode($number), 0, 1, 'R');
    $pdf->Line(30, $pdf->GetY(), 186, $pdf->GetY());
    $pdf->Ln(3);

    foreach ($destinatarios as $destinatario) {
        comunicacionInternaPdfAuthority(
            $pdf,
            $destinatario['etiqueta'],
            $destinatario['nombre'],
            $destinatario['cargo']
        );
    }
    comunicacionInternaPdfAuthority($pdf, 'DE:', $emisor, $cargoEmisor);
}

function comunicacionInternaPdfAuthority($pdf, $label, $name, $position)
{
    $pdf->SetX(30);
    $pdf->SetFont('Arial', 'B', 9.5);
    $pdf->Cell(20, 4, comunicacionInternaPdfEncode($label), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->MultiCell(136, 4, comunicacionInternaPdfEncode($name));
    $pdf->SetX(50);
    $pdf->SetFont('Arial', 'B', 9.5);
    $pdf->MultiCell(136, 4, comunicacionInternaPdfEncode($position));
    $pdf->SetX(50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(136, 4, 'GOBIERNO AUTÓNOMO MUNICIPAL DE EL ALTO');
    $pdf->Ln(2);
}

function comunicacionInternaPdfReference($pdf, $reference)
{
    $pdf->SetX(30);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 5, 'REF.:', 0, 0, 'L');
    $pdf->MultiCell(136, 5, comunicacionInternaPdfEncode($reference));
    $pdf->Line(30, $pdf->GetY(), 186, $pdf->GetY());
    $pdf->Ln(3);
}

function comunicacionInternaPdfParagraph($pdf, $text, $fontSize)
{
    $pdf->SetX(30);
    $pdf->SetFont('Arial', '', $fontSize);
    $pdf->MultiCell(156, 4.5, comunicacionInternaPdfEncode($text), 0, 'J');
    $pdf->Ln(2);
}

function comunicacionInternaPdfSummary($pdf, $rows)
{
    $pdf->SetWidths(array(55, 101));
    foreach ($rows as $row) {
        $pdf->SetX(30);
        $pdf->SetFont('Arial', '', 8.5);
        $pdf->Row(array(
            comunicacionInternaPdfEncode($row[0]),
            comunicacionInternaPdfEncode($row[1])
        ));
    }
    $pdf->Ln(3);
}

function comunicacionInternaPdfTable($pdf, $title, $header, $widths, $rows, $fontSize)
{
    comunicacionInternaPdfParagraph($pdf, $title, 9.5);
    $pdf->SetCommunicationTableHeader($header, $widths, $fontSize);
    $pdf->SetX(30);
    $pdf->CommunicationTableRow($header, true, $fontSize);
    foreach ($rows as $row) {
        $pdf->SetX(30);
        $pdf->CommunicationTableRow($row, false, $fontSize);
    }
    $pdf->Ln(3);
}

function comunicacionInternaPdfEnd($pdf, $copies, $signatureName = '', $signaturePosition = '')
{
    $requiredHeight = 24 + (count($copies) * 4);
    if ($signatureName !== '') {
        $requiredHeight += 12;
    }
    if ($pdf->CommunicationPageBreakNeeded($requiredHeight)) {
        $pdf->AddPage();
    }

    $pdf->SetX(30);
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->MultiCell(156, 5, 'Atentamente,');
    $pdf->Ln(19);
    if ($signatureName !== '') {
        $pdf->SetX(30);
        $pdf->SetFont('Arial', 'B', 9.5);
        $pdf->Cell(156, 4, comunicacionInternaPdfEncode($signatureName), 0, 1, 'C');
        $pdf->SetX(30);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(156, 4, comunicacionInternaPdfEncode($signaturePosition), 0, 1, 'C');
        $pdf->Ln(4);
    }
    $pdf->SetFont('Arial', '', 7);
    foreach ($copies as $copy) {
        $pdf->SetX(30);
        $pdf->Cell(156, 4, comunicacionInternaPdfEncode($copy), 0, 1, 'L');
    }
}
