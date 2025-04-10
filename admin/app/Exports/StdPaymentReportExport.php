<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StdPaymentReportExport implements FromArray, WithHeadings, WithEvents
{
    protected $stdPaymentReport;
    protected $fromdate;
    protected $todate;
    protected $sess;
    protected $session;

    public function __construct($stdPaymentReport, $fromdate, $todate, $sess)
    {
        $this->stdPaymentReport = $stdPaymentReport;
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $this->sess = $sess;
        $this->session = $this->sess ?? "All";
    }

    public function query()
    {
        return $this->stdPaymentReport;
    }

    // The array of data to be used in the report
    public function array(): array
    {
        $data = [];
        $totalAmount = 0;
        //retrieve gender
        $studentModel = new Student();


        // Add table data
        foreach ($this->stdPaymentReport as $index => $transaction) {
            $gender = $studentModel->getGenderByLogId($transaction->log_id);
            $amount = $transaction->trans_amount;
            $totalAmount += $amount;
            $studentId = $studentModel->getStudentIdByLogId($transaction->log_id);
            $studentId = $studentId == 0 ? "" : $studentId;
            $data[] = [
                $index + 1,
                strtoupper($transaction->fullnames),
                $transaction->appno,
                $transaction->student->programme->programme_name,
                $transaction->student->stdcourseOption->programme_option,
                $transaction->transLevel->level_name,
                " $transaction->rrr",
                $gender,
                $studentId,
                $transaction->trans_name,
                number_format($transaction->trans_amount, 2),
                $transaction->trans_year,
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
            ['Payment Report from ' . Carbon::parse($this->fromdate)->format('jS F, Y') . ' to ' . Carbon::parse($this->todate)->format('jS F, Y') . ' for ' . $this->session . ' Session'],
            [''],
            ['S/N', 'Fullname', 'MatNo', 'Programme', 'Course of Study',  'Level', 'RRR', 'Gender',  'StudentId', 'Fee Name', 'Amount', 'Session', 'Date Paid']
        ];
    }

    // Use the AfterSheet event to style and manipulate cells
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge header cells and center align them
                $sheet->mergeCells('A1:M1');
                $sheet->mergeCells('A2:M2');
                $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:M2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:M1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2:M2')->getFont()->setBold(true);
                $sheet->getStyle('A4:M4')->getFont()->setBold(true);

                // Set column auto size
                foreach (range('A', 'M') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Style the table border
                $lastRow = count($this->stdPaymentReport) + 6; // +6 because we have 5 rows before the data (headers and title)
                $sheet->getStyle('A4:M' . $lastRow)->applyFromArray([
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
                $sheet->getStyle('A' . ($lastRow + 1) . ':K' . ($lastRow + 1))
                    ->getFont()->setBold(true);
                $sheet->getStyle('L' . ($lastRow + 1))->getAlignment()->setHorizontal('right');
            }
        ];
    }
}
