<?php

namespace App\Support;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Dependency-free styled Excel exporter.
 *
 * Produces SpreadsheetML 2003 (the XML flavour of Excel) so the output opens
 * natively in Microsoft Excel with colours, borders, column widths, a frozen
 * header and an auto-filter — without requiring the PhpSpreadsheet package or
 * the PHP zip extension.
 */
class ExcelExporter
{
    /**
     * Stream a styled Excel file to the browser.
     *
     * @param  string  $filename   Download file name (include the .xls extension).
     * @param  string  $sheetName  Worksheet / tab name.
     * @param  array<int, array{label:string,width?:float,type?:string,align?:string}>  $columns
     * @param  iterable<array<int, mixed>>  $rows  Values in the same order as $columns.
     * @param  array{title?:string,subtitle?:string,brand?:string,freeze?:bool,autofilter?:bool}  $options
     */
    public static function download(
        string $filename,
        string $sheetName,
        array $columns,
        iterable $rows,
        array $options = []
    ): StreamedResponse {
        $brand = ltrim($options['brand'] ?? '0F2942', '#');
        $title = $options['title'] ?? Str::title($sheetName);
        $subtitle = $options['subtitle'] ?? null;
        $freeze = $options['freeze'] ?? true;
        $autofilter = $options['autofilter'] ?? true;

        $data = [];
        foreach ($rows as $row) {
            $data[] = array_values((array) $row);
        }

        $colCount = max(1, count($columns));
        $headerRowIndex = 4;
        $firstDataRow = $headerRowIndex + 1;
        $lastDataRow = $headerRowIndex + count($data);
        $total = count($data);

        $response = new StreamedResponse(function () use (
            $sheetName,
            $columns,
            $data,
            $brand,
            $title,
            $subtitle,
            $freeze,
            $autofilter,
            $colCount,
            $headerRowIndex,
            $lastDataRow,
            $total
        ) {
            $out = fopen('php://output', 'w');

            fwrite($out, '<?xml version="1.0" encoding="UTF-8"?>' . "\n");
            fwrite($out, '<?mso-application progid="Excel.Sheet"?>' . "\n");
            fwrite($out, '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"'
                . ' xmlns:o="urn:schemas-microsoft-com:office:office"'
                . ' xmlns:x="urn:schemas-microsoft-com:office:excel"'
                . ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"'
                . ' xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n");

            fwrite($out, '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">'
                . '<Title>' . self::esc($title) . '</Title>'
                . '<Author>SIPRAK SMKN 1 Gunungputri</Author>'
                . '</DocumentProperties>' . "\n");

            fwrite($out, self::styles($brand, $columns));

            fwrite($out, '<Worksheet ss:Name="' . self::esc(self::sheetName($sheetName)) . '">' . "\n");
            fwrite($out, '<Table ss:ExpandedColumnCount="' . $colCount . '" ss:ExpandedRowCount="'
                . ($headerRowIndex + $total) . '" x:FullColumns="1" x:FullRows="1" ss:DefaultRowHeight="15">' . "\n");

            foreach ($columns as $index => $column) {
                $width = (float) ($column['width'] ?? 16);
                $points = (int) round($width * 7 + 5);
                fwrite($out, '<Column ss:Index="' . ($index + 1) . '" ss:AutoFitWidth="0" ss:Width="' . $points . '"/>' . "\n");
            }

            // Row 1 — title
            fwrite($out, '<Row ss:Height="24"><Cell ss:MergeAcross="' . ($colCount - 1)
                . '" ss:StyleID="sTitle"><Data ss:Type="String">' . self::esc($title) . '</Data></Cell></Row>' . "\n");

            // Row 2 — subtitle / meta
            $meta = $subtitle ?: ('SIPRAK SMKN 1 Gunungputri  •  Diekspor: ' . date('d/m/Y H:i') . '  •  Total: ' . $total . ' data');
            fwrite($out, '<Row ss:Height="16"><Cell ss:MergeAcross="' . ($colCount - 1)
                . '" ss:StyleID="sSubtitle"><Data ss:Type="String">' . self::esc($meta) . '</Data></Cell></Row>' . "\n");

            // Row 3 — spacer
            fwrite($out, '<Row ss:Height="6"/>' . "\n");

            // Row 4 — header
            fwrite($out, '<Row ss:Height="28">');
            foreach ($columns as $column) {
                fwrite($out, '<Cell ss:StyleID="sHeader"><Data ss:Type="String">'
                    . self::esc($column['label'] ?? '') . '</Data></Cell>');
            }
            fwrite($out, '</Row>' . "\n");

            // Data rows
            foreach ($data as $rowIndex => $row) {
                $alt = $rowIndex % 2 === 1;
                fwrite($out, '<Row ss:Height="18">');
                for ($c = 0; $c < $colCount; $c++) {
                    $value = $row[$c] ?? null;
                    $type = strtolower((string) ($columns[$c]['type'] ?? 'string'));
                    $align = $columns[$c]['align'] ?? 'left';
                    $style = 'sCell' . ucfirst($align) . ($alt ? 'Alt' : '');

                    if ($value === null || $value === '') {
                        fwrite($out, '<Cell ss:StyleID="' . $style . '"/>');
                        continue;
                    }

                    if ($type === 'number' && is_numeric($value)) {
                        fwrite($out, '<Cell ss:StyleID="' . $style . '"><Data ss:Type="Number">'
                            . self::esc((string) $value) . '</Data></Cell>');
                    } else {
                        fwrite($out, '<Cell ss:StyleID="' . $style . '"><Data ss:Type="String">'
                            . self::esc((string) $value) . '</Data></Cell>');
                    }
                }
                fwrite($out, '</Row>' . "\n");
            }

            fwrite($out, '</Table>' . "\n");

            fwrite($out, '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">' . "\n");
            fwrite($out, '<PageSetup><Layout x:Orientation="Landscape"/></PageSetup>' . "\n");
            fwrite($out, '<FitToPage/>' . "\n");
            if ($freeze) {
                fwrite($out, '<FreezePanes/><FrozenNoSplit/><SplitHorizontal>' . $headerRowIndex
                    . '</SplitHorizontal><TopRowBottomPane>' . $headerRowIndex
                    . '</TopRowBottomPane><ActivePane>2</ActivePane><Panes><Pane><Number>3</Number></Pane>'
                    . '<Pane><Number>2</Number></Pane></Panes>' . "\n");
            }
            fwrite($out, '<ProtectObjects>False</ProtectObjects><ProtectScenarios>False</ProtectScenarios>');
            fwrite($out, '</WorksheetOptions>' . "\n");

            if ($autofilter) {
                fwrite($out, '<AutoFilter x:Range="R' . $headerRowIndex . 'C1:R' . max($headerRowIndex, $lastDataRow)
                    . 'C' . $colCount . '" xmlns="urn:schemas-microsoft-com:office:excel"/>' . "\n");
            }

            fwrite($out, '</Worksheet>' . "\n");
            fwrite($out, '</Workbook>');

            fclose($out);
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->headers->set('Pragma', 'public');

        return $response;
    }

    private static function styles(string $brand, array $columns): string
    {
        $border = '<Borders>'
            . '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>'
            . '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>'
            . '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>'
            . '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>'
            . '</Borders>';

        $headerBorder = '<Borders>'
            . '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>'
            . '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>'
            . '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>'
            . '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>'
            . '</Borders>';

        $xml = '<Styles>' . "\n";
        $xml .= '<Style ss:ID="Default" ss:Name="Normal">'
            . '<Alignment ss:Vertical="Center"/><Font ss:FontName="Calibri" x:CharSet="1" ss:Size="11" ss:Color="#1E293B"/>'
            . '</Style>' . "\n";
        $xml .= '<Style ss:ID="sTitle">'
            . '<Font ss:FontName="Calibri" x:CharSet="1" ss:Size="15" ss:Bold="1" ss:Color="#' . $brand . '"/>'
            . '<Alignment ss:Horizontal="Left" ss:Vertical="Center"/></Style>' . "\n";
        $xml .= '<Style ss:ID="sSubtitle">'
            . '<Font ss:FontName="Calibri" x:CharSet="1" ss:Size="10" ss:Italic="1" ss:Color="#64748B"/>'
            . '<Alignment ss:Horizontal="Left" ss:Vertical="Center"/></Style>' . "\n";
        $xml .= '<Style ss:ID="sHeader">'
            . '<Font ss:FontName="Calibri" x:CharSet="1" ss:Size="11" ss:Bold="1" ss:Color="#FFFFFF"/>'
            . '<Interior ss:Color="#' . $brand . '" ss:Pattern="Solid"/>'
            . '<Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>'
            . $headerBorder . '</Style>' . "\n";

        foreach (['left', 'center', 'right'] as $align) {
            $horizontal = ucfirst($align);
            foreach (['' => false, 'Alt' => true] as $suffix => $alt) {
                $fill = $alt ? '<Interior ss:Color="#F1F5F9" ss:Pattern="Solid"/>' : '';
                $xml .= '<Style ss:ID="sCell' . ucfirst($align) . $suffix . '">'
                    . '<Font ss:FontName="Calibri" x:CharSet="1" ss:Size="11" ss:Color="#1E293B"/>'
                    . $fill
                    . '<Alignment ss:Horizontal="' . $horizontal . '" ss:Vertical="Center" ss:WrapText="1"/>'
                    . $border . '</Style>' . "\n";
            }
        }

        $xml .= '</Styles>' . "\n";

        return $xml;
    }

    private static function sheetName(string $name): string
    {
        $name = preg_replace('/[\\\\\/\?\*\[\]:]/', ' ', $name) ?? $name;
        $name = trim($name);

        return $name === '' ? 'Sheet1' : mb_substr($name, 0, 31);
    }

    private static function esc(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
