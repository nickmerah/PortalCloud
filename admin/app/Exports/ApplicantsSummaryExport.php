<?php

namespace App\Exports;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicantsSummaryExport  implements FromCollection, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $prog;
    protected $progtype;
    protected $frommonth;
    protected $tomonth;
    protected $totalSum;

    public function __construct($data, $prog, $progtype, $frommonth, $tomonth, $totalSum)
    {

        $this->data = $data;
        $this->prog = $prog;
        $this->progtype = $progtype;
        $this->frommonth = $frommonth;
        $this->tomonth = $tomonth;
        $this->totalSum = $totalSum;
    }

    public function collection()
    {
        $rows = collect();
        $rows->push([Controller::SCHOOLNAME]);
        $rows->push([]);
        $rows->push(["Application Payments Summary showing from {$this->frommonth->format('M, Y')} to {$this->tomonth->format('M, Y')}"]);
        $rows->push([]);

        // Add headers
        $rows->push(['S/N', 'FEE NAME', 'PROGRAMME', 'PROGRAMME TYPE', 'TOTAL AMOUNT']);

        // Add data rows
        foreach ($this->data as $index => $report) {
            $rows->push([
                $index + 1,
                $report->fee_name,
                $this->prog ?? 'ND and HND',
                $this->progtype ?? 'FT and PT',
                number_format($report->total_amount),
            ]);
        }

        // Add blank row and total
        $rows->push([]);
        $rows->push(['', '', '', 'TOTAL', number_format($this->totalSum)]);

        return $rows;
    }

    public function headings(): array
    {
        // Headings are included directly in the collection, no need here
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for the title and date range
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        // Get the highest row and column for dynamic range
        $highestRow = $sheet->getHighestRow();  // Last row number
        $highestColumn = $sheet->getHighestColumn();  // Last column letter

        // Apply border to the entire range dynamically
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black border
                ],
            ],
        ]);

        return [
            // Bold and center alignment for the title and date range
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2 => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => 'center']],

            // Bold headers
            3 => ['font' => ['bold' => true]],
        ];
    }
}
