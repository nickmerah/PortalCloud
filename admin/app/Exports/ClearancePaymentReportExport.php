<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClearancePaymentReportExport implements FromArray, WithHeadings, WithEvents
{
    protected $paymentReport;
    protected $fromdate;
    protected $todate;

    public function __construct($paymentReport, $fromdate, $todate)
    {
        $this->paymentReport = $paymentReport;
        $this->fromdate = $fromdate;
        $this->todate = $todate;
    }

    // The array of data to be used in the report
    public function array(): array
    {
        $data = [];
        $totalAmount = 0;
        // 


        // Add table data
        foreach ($this->paymentReport as $index => $transaction) {
            $deptname = $transaction->clearanceStudents->clearanceDept->programme_option ?? "";
            $level_name = $transaction->clearanceStudents->clearanceLevel->level_name ?? "";
            $amount = $transaction->total_amount;
            $totalAmount += $amount;

            $data[] = [
                $index + 1,
                strtoupper($transaction->fullnames),
                $transaction->matno,
                $transaction->clearanceStudents->programme->programme_name,
                $deptname,
                $level_name,
                " $transaction->rrr",
                $transaction->fee_name,
                number_format($transaction->total_amount, 2),
                Carbon::parse($transaction->t_date)->format('d-M-Y'),
            ];
        }

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Total',
            number_format($totalAmount, 2),
            '',
        ];

        return $data;
    }

    // Headings of the table (column headers)
    public function headings(): array
    {
        return [
            [Controller::SCHOOLNAME],
            ['Payment Report from ' . Carbon::parse($this->fromdate)->format('jS F, Y') . ' to ' . Carbon::parse($this->todate)->format('jS F, Y')],
            [''],
            ['S/N', 'Fullname', 'Mat Number', 'Programme', 'Department', 'Level', 'RRR', 'Fee Name', 'Amount', 'Date Paid']
        ];
    }

    // Use the AfterSheet event to style and manipulate cells
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge header cells and center align them
                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');
                $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2:J2')->getFont()->setBold(true);
                $sheet->getStyle('A4:J4')->getFont()->setBold(true);

                // Set column auto size
                foreach (range('A', 'J') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Style the table border
                $lastRow = count($this->paymentReport) + 6; // +6 because we have 5 rows before the data (headers and title)
                $sheet->getStyle('A4:J' . $lastRow)->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Style the total row
                $sheet->getStyle('A' . ($lastRow + 1) . ':J' . ($lastRow + 1))
                    ->getFont()->setBold(true);
                $sheet->getStyle('J' . ($lastRow + 1))->getAlignment()->setHorizontal('right');
            }
        ];
    }
}
