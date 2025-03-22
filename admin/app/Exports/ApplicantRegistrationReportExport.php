<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicantRegistrationReportExport implements FromArray, WithHeadings, WithEvents
{
    protected $applicants;
    protected $currentSession;

    public function __construct($applicants, $currentSession)
    {
        $this->currentSession = $currentSession;
        $this->applicants = $applicants;
    }

    // The array of data to be used in the report
    // File: ApplicantReport.php

    public function array(): array
    {
        $data = [];

        // Add table data
        foreach ($this->applicants as $index => $applicant) {
            $fullnames = $applicant->surname . ' ' . $applicant->firstname . ' ' . $applicant->othernames;

            // Initialize row data
            $row = [
                $index + 1,
                $applicant->app_no,
                strtoupper($fullnames),
                $applicant->programme->programme_name,
                $applicant->stdcourseOption->programme_option,
                $applicant->std_courseOption->programme_option,
                ($applicant->birthdate === '0000-00-00') ? 'NA' : Carbon::parse($applicant->birthdate)->format('d-M-Y'),
                $applicant->gender,
                $applicant->stateor->state_name ?? '',
                $applicant->lga->lga_name ?? '',
                $applicant->student_email,
                " $applicant->student_mobiletel",
            ];


            if ($applicant->stdprogramme_id == '1') {

                $jambNo = $applicant->jamb->first()->jambno ?? 'NA';
                $totalJambScore = $applicant->jamb->sum('jscore');
                $row[] = $jambNo;
                $row[] = $totalJambScore;
            } elseif ($applicant->stdprogramme_id == '2') {
                // For HND, include ND Course, ND Grade, School Attended, and Year of Graduation
                $row[] = $applicant->eduhistory->ndCourse->programme_option ?? 'NA';
                $row[] = $applicant->eduhistory->grade ?? 'NA';
                $row[] = $applicant->eduhistory->polytechnic->pname ?? 'NA';
                $row[] = $applicant->eduhistory->todate ?? 'NA';
            }

            // Add other columns like submission date and application status
            $row[] = ($applicant->appsubmitdate === '0000-00-00') ? 'NA' : Carbon::parse($applicant->appsubmitdate)->format('d-M-Y');
            $row[] = $applicant->std_custome9 == 1 ? 'Submitted' : 'Not Submitted';

            $data[] = $row;
            //    print_r($row);
            //  exit;
        }

        // Footer row for total number of applicants
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
            '',
            'Total',
            number_format(count($this->applicants)),
            '',
        ];

        return $data;
    }


    // Headings of the table (column headers)
    public function headings(): array
    {

        $defaultHeadings = ['S/N', 'Application Number', 'Applicant Name', 'Programme', 'First Choice', 'Second Choice', 'Date of Birth', 'Gender', 'State', 'LGA', 'Email', 'GSM'];


        if ($this->applicants[0]->stdprogramme_id == '1') {
            $additionalHeadings = ['Jamb No', 'Jamb Score'];
        } elseif ($this->applicants[0]->stdprogramme_id == '2') {
            $additionalHeadings = ['ND Course', 'ND Grade', 'School Attended', 'Year of Graduation'];
        } else {
            $additionalHeadings = []; // Default case (if needed)
        }

        $finalHeadings = array_merge($defaultHeadings, $additionalHeadings, ['Submission Date', 'Application Status']);

        return [
            [Controller::SCHOOLNAME],
            ['Applicant Registration Report for ' . $this->currentSession . ' to ' . ($this->currentSession + 1)],
            [''], // Empty row for spacing
            $finalHeadings
        ];
    }

    // Use the AfterSheet event to style and manipulate cells
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Get the dynamic headings to determine the number of columns
                $headings = $this->headings();
                $totalColumns = count($headings[3]); // The actual data headings
                $lastColumn = chr(64 + $totalColumns); // Convert number to letter (e.g., 14 columns -> 'N')

                // Merge header cells and center align them dynamically
                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->getStyle("A1:{$lastColumn}1")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A2:{$lastColumn}2")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle("A2:{$lastColumn}2")->getFont()->setBold(true);
                $sheet->getStyle("A4:{$lastColumn}4")->getFont()->setBold(true);

                // Set column auto size dynamically
                foreach (range('A', $lastColumn) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Style the table border dynamically
                $lastRow = count($this->applicants) + 6; // +6 because we have 5 rows before the data (headers and title)
                $sheet->getStyle("A4:{$lastColumn}{$lastRow}")->applyFromArray([
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

                // Style the total row dynamically
                $sheet->getStyle("A" . ($lastRow + 1) . ":{$lastColumn}" . ($lastRow + 1))
                    ->getFont()->setBold(true);
                $sheet->getStyle("M" . ($lastRow + 1))->getAlignment()->setHorizontal('right');
            }
        ];
    }
}
