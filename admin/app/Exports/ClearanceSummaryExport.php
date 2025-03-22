<?php

namespace App\Exports;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClearanceSummaryExport  implements FromCollection, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $frommonth;
    protected $tomonth;
    protected $totalSum;

    public function __construct($data, $frommonth, $tomonth, $totalSum)
    {

        $this->data = $data;
        $this->frommonth = $frommonth;
        $this->tomonth = $tomonth;
        $this->totalSum = $totalSum;
    }

    public function collection()
    {
        $rows = collect();
        $rows->push([Controller::SCHOOLNAME]);
        $rows->push([]);
        $rows->push(["Clearance Payments Summary showing from {$this->frommonth->format('M, Y')} to {$this->tomonth->format('M, Y')}"]);
        $rows->push([]);

        // Add headers
        $rows->push(['S/N', 'FEE NAME', 'TOTAL AMOUNT']);

        // Add data rows
        foreach ($this->data as $index => $report) {
            $rows->push([
                $index + 1,
                $report->fee_name,
                number_format($report->total_amount),
            ]);
        }

        // Add blank row and total
        $rows->push([]);
        $rows->push(['', 'TOTAL', number_format($this->totalSum)]);

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
        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');

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
