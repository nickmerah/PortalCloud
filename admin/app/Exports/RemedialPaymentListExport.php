<?php

namespace App\Exports;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RemedialPaymentListExport  implements FromCollection, WithStyles, ShouldAutoSize
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
        $feename =  $this->data[0]->fee_name;
        $rows = collect();
        $rows->push([Controller::SCHOOLNAME]);
        $rows->push([]);
        $rows->push(["Remedial List for  $feename  showing from {$this->frommonth->format('M, Y')} to {$this->tomonth->format('M, Y')}"]);
        $rows->push([]);

        // Add headers
        $rows->push(['S/N', 'MATRICULATION NO', 'STUDENT NAME', 'FEE NAME',  'RRR', 'TOTAL AMOUNT', 'DATE PAID']);

        // Add data rows
        foreach ($this->data as $index => $report) {
            $rows->push([
                $index + 1,
                $report?->matno,
                $report?->fullnames,
                $report?->fee_name,
                " $report?->rrr",
                number_format($report?->fee_amount),
                \Carbon\Carbon::parse($report?->t_date)->format('jS F, Y'),
            ]);
        }

        // Add blank row and total
        $rows->push([]);
        $rows->push(['', '',  '', '', 'TOTAL', number_format($this->totalSum), '', '',]);

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for the title and date range
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

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
