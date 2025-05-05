<?php

namespace App\Exports;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentPaymentListExport  implements FromCollection, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $prog;
    protected $progtype;
    protected $frommonth;
    protected $tomonth;
    protected $totalSum;
    protected $sess;

    public function __construct($data, $prog, $progtype, $frommonth, $tomonth, $totalSum, $sess)
    {

        $this->data = $data;
        $this->prog = $prog;
        $this->progtype = $progtype;
        $this->frommonth = $frommonth;
        $this->tomonth = $tomonth;
        $this->totalSum = $totalSum;
        $this->sess = $sess;
    }

    public function collection()
    {
        $feename =  $this->data[0]->trans_name;
        $prog = !empty($this->prog) ? $this->prog : 'ND and HND';
        $progtype = !empty($this->progtype) ? $this->progtype : 'FT and PT';
        $session = isset($this->sess) && is_numeric($this->sess)
            ? " - {$this->sess}/" . ($this->sess + 1) . " Session"
            : 'All Sessions';
        $rows = collect();
        $rows->push([Controller::SCHOOLNAME]);
        $rows->push([]);
        $rows->push(["Student List for  $feename  showing from {$this->frommonth->format('M, Y')} to {$this->tomonth->format('M, Y')} for $prog, $progtype $session"]);
        $rows->push([]);

        // Add headers
        $rows->push(['S/N', 'MATRICULATION NO', 'STUDENT NAME',  'STATE', 'LGA', 'FEE NAME', 'FEE TYPE', 'RRR', 'TOTAL AMOUNT', 'DATE PAID']);
        $student = new Student();
        // Add data rows
        foreach ($this->data as $index => $report) {
            $lgaName = $report?->log_id ? $student->getLgaNameByLogId($report->log_id) : null;
            $rows->push([
                $index + 1,
                $report?->appno,
                $report?->fullnames,
                $report?->stateor->state_name,
                $lgaName,
                $report?->trans_name,
                $report?->fee_type == 'fees' ? 'Fees' : 'Other Fees',
                " $report?->rrr",
                number_format($report?->trans_amount),
                \Carbon\Carbon::parse($report?->t_date)->format('jS F, Y'),
            ]);
        }

        // Add blank row and total
        $rows->push([]);
        $rows->push(['', '', '', '', '', 'TOTAL', number_format($this->totalSum), '', '',]);

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for the title and date range
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');

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
