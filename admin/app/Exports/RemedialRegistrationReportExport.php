<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RemedialRegistrationReportExport implements FromArray, WithHeadings, WithEvents
{
    protected $registrationReport;
    protected $csession;

    public function __construct($registrationReport, $csession)
    {
        $this->registrationReport = $registrationReport;
        $this->csession = $csession;
    }

    // The array of data to be used in the report
    public function array(): array
    {
        $i = 0;
        $data = [];


        // Add table data
        foreach ($this->registrationReport as $index => $remedial) {
            $fullnames = $remedial['surname'] . ' ' . $remedial['firstname'] . ' ' . $remedial['othername'];
            $course = $remedial['course_codes']->toArray();
            $data[] = [
                $i = $i + 1,
                $remedial['matno'],
                strtoupper($fullnames),
                $remedial['level'],
                count($course),
                implode(', ', $course)
            ];
        }

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        return $data;
    }

    // Headings of the table (column headers)
    public function headings(): array
    {
        return [
            [Controller::SCHOOLNAME],
            ['Remedial Registration Report for ' . $this->csession->cs_session . '/' . ($this->csession->cs_session + 1) . ' Session'],
            [''],
            ['S/N', 'Fullname', 'Mat Number', 'Level', 'No of Courses', 'Courses']
        ];
    }

    // Use the AfterSheet event to style and manipulate cells
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge header cells and center align them
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:F1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2:F2')->getFont()->setBold(true);
                $sheet->getStyle('A4:F4')->getFont()->setBold(true);

                // Set column auto size
                foreach (range('A', 'F') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Style the table border
                $lastRow = count($this->registrationReport) + 6; // +6 because we have 5 rows before the data (headers and title)
                $sheet->getStyle('A4:F' . $lastRow)->applyFromArray([
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
                $sheet->getStyle('A' . ($lastRow + 1) . ':H' . ($lastRow + 1))
                    ->getFont()->setBold(true);
                $sheet->getStyle('H' . ($lastRow + 1))->getAlignment()->setHorizontal('right');
            }
        ];
    }
}
