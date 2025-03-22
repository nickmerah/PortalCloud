<?php

namespace App\Exports;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicantPaymentListExport  implements FromCollection, WithStyles, ShouldAutoSize
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
        $feename =  $this->data[0]->fee_name;
        $prog = $this->prog ?? 'ND and HND';
        $progtype = $this->progtype ?? 'FT and PT';
        $rows = collect();
        $rows->push([Controller::SCHOOLNAME]);
        $rows->push([]);
        $rows->push(["Applicant List for  $feename  showing from {$this->frommonth->format('M, Y')} to {$this->tomonth->format('M, Y')} for $prog, $progtype"]);
        $rows->push([]);

        // Add headers
        $rows->push(['S/N', 'APPLICANT NO', 'APPLICANT NAME', 'FEE NAME', 'RRR', 'TOTAL AMOUNT', 'DATE PAID']);

        // Add data rows
        foreach ($this->data as $index => $report) {
            $rows->push([
                $index + 1,
                $report?->appno,
                $report?->fullnames,
                $report?->fee_name,
                " $report?->rrr",
                number_format($report?->fee_amount),
                \Carbon\Carbon::parse($report?->t_date)->format('jS F, Y'),
            ]);
        }

        // Add blank row and total
        $rows->push([]);
        $rows->push(['', '', '', '', 'TOTAL', number_format($this->totalSum), '', '',]);

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
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

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
