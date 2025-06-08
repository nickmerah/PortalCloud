<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="K5eg9TIJNwWudsb1bWC7tQlCTgnulY9KSaLOCkAz">

    <title>{{ $schoolname }} | Comprehensive Result Sheet</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles and Scripts -->
    <link rel="preload" as="style" href="{{ asset('build/assets/app-DZUsWXEA.css') }}"/>
    <link rel="modulepreload" href="{{ asset('build/assets/app-pd4cR8cG.js') }}"/>
    <link rel="stylesheet" href="{{ asset('build/assets/app-DZUsWXEA.css') }}"/>
    <script type="module" src="{{ asset('build/assets/app-pd4cR8cG.js') }}"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Print Signature Styles -->
    <style>
        @media print {
            .signature-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                display: flex;
                justify-content: space-between;
                text-align: center;
                padding: 20px;
                page-break-inside: avoid;
            }

            .signature-footer div {
                width: 30%;
            }

            body {
                margin-bottom: 100px;
                /* space for footer */
            }
        }

        @media print {
            .page-break {
                page-break-before: always;
            }
        }

        .gpa-stats-container {
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Space between tables */
            max-width: 1000px; /* Limits total width */
            margin: 0 auto; /* Centers the container */
        }

        .gpa-stats-table {
            width: 45%; /* Each table takes roughly half the container width */
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        .gpa-stats-table th,
        .gpa-stats-table td {
            padding: 8px;
            text-align: center;
        }

        .gpa-stats-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 600px) {
            .gpa-stats-container {
                flex-direction: column;
            }

            .gpa-stats-table {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- jQuery & DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<table class="table table-bordered table-hover" style="font-size:12px; line-height:1;" id="dataTables-example">
    <thead>
    <tr style="font-size:12px;">
        <th></th>
        <th><strong>FULLNAME</strong></th>
        <th><strong>
                <div class="text-center"
                     style="line-height: 1;">{!! str_replace(' ', '<br>', 'MATRICULATION NUMBER') !!}</div>
            </strong></th>
        @foreach ($courses as $course)
            <th><strong>
                    <div class="text-center"
                         style="line-height: 1;">{!! str_replace(' ', '<br>', $course->coursecode) !!}</div>
                </strong></th>
        @endforeach
        <th><strong>TCU</strong></th>
        <th><strong>TPS</strong></th>
        <th><strong>GPA</strong></th>
        <th><strong>
                <div style="line-height: 1;">{!! str_replace(' ', '<br>', 'SEM PERF') !!}</div>
            </strong></th>
        <th><strong>REMARK</strong></th>
    </tr>
    <tr style="font-size:12px;">
        <th></th>
        <th></th>
        <th></th>
        @foreach ($courses as $course)
            <th>
                <div class="text-center">{{ $course->courseunit }}</div>
            </th>
        @endforeach
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($results as $result)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $result->fullnames ?? 'N/A' }}</td>
            <td class="text-center">{{ $result->matric_no }}</td>
            @foreach ($courses as $course)
                @php $data = $result->course_marks[$course->course_id] ?? null; @endphp
                <td class="text-center">
                    {{ (int)($data->std_mark ?? 0) }}{{ $data->std_rstatus ?? '' }}
                </td>
            @endforeach
            <td>{{ $result->total_unit }}</td>
            <td>{{ $result->tgp }}</td>
            <td>{{ $result->gpa }}</td>
            <td>{{ $result->status }}</td>
            <td>{{ $result->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Summary Section -->
<div class="page-break summary-section">

    <table style="width: 100%;">
        <tr>
            <td style="width: 80px; vertical-align: top;">
                <img src="https://portal.mydspg.edu.ng/eportal/public/images/logo.png" width="120"
                     height="140" alt="Logo">
            </td>
            <td style="text-align: left; padding-left: 10px; font-family: Tahoma, Geneva, sans-serif;">
                <strong style="font-size: 16px;">{{ $schoolname }}</strong><br>
                <span style="font-size:12px;"><strong>SCHOOL:</strong> {{ $courseofstudy[0]->department->faculty->faculties_name }}</span><br>
                <span
                    style="font-size:12px;"><strong>DEPARTMENT:</strong> {{ $courseofstudy[0]->programme_option }}</span><br>
                <span
                    style="font-size:12px;"><strong>EXAMINATION:</strong> {{ strtoupper($semester) }} RESULT</span><br>
                <span style="font-size:12px;"><strong>PROGRAMME:</strong> {{ $courseofstudy[0]->programme->programme_name }} | LEVEL: {{ $level }}</span><br>
                <span
                    style="font-size:12px;"><strong>SESSION:</strong> {{ $session }}/{{ $session + 1 }}</span>
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px">
        <table class="text-center table table-bordered table-hover" style="font-size:12px; line-height:1; "
               id="dataTables-example">
            <thead>
            <tr style="font-size:12px;">
                <th><strong>S/N</strong></th>
                <th><strong>Course Code</strong></th>
                <th><strong>Course Title</strong></th>
                <th><strong>Course Unit</strong></th>
                @foreach ($gradeLetters as $grade)
                    <th><strong>{{ $grade }}</strong></th>
                @endforeach
                <th><strong>TOTAL</strong></th>
                <th><strong>%PASS</strong></th>
                <th><strong>%FAIL</strong></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $course->coursecode }}</td>
                    <td>{{ $course->coursetitle }}</td>
                    <td>{{ $course->courseunit }}</td>
                    @foreach ($gradeLetters as $grade)
                        <td>{{ $courseGradeCounts[$course->course_id]['grades']["$grade"] }}</td>
                    @endforeach
                    <td>{{ $courseGradeCounts[$course->course_id]['student_count'] }}</td>
                    <td>@php
                            $failures = $courseGradeCounts[$course->course_id]['grades']['F'] ?? 0;
                        echo $percentagePass = $courseGradeCounts[$course->course_id]['student_count'] > 0 ? round((($courseGradeCounts[$course->course_id]['student_count'] - $failures) / $courseGradeCounts[$course->course_id]['student_count']) * 100, 2) : 0;
                        $percentageFail = $courseGradeCounts[$course->course_id]['student_count'] > 0 ? (100 - $percentagePass) : 0;
                        @endphp</td>
                    <td>{{ $percentageFail }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px" class="gpa-stats-container">
        <table class="text-left table table-bordered table-hover" class="gpa-stats-table"
               style="font-size:12px; line-height:1; width: 50%; ">
            <tbody>
            <tr>
                <td>Total Number OF Students That Sat For the Exams</td>
                <td>{{ $gpaStats['totalStudents'] }}</td>
            </tr>
            <tr>
                <td>HIGHEST GPA</td>
                <td>{{ $gpaStats['maxGpa'] }}</td>
            </tr>
            <tr>
                <td>LOWEST GPA</td>
                <td>{{ $gpaStats['minGpa'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With GPA Less Than 1.5</td>
                <td>{{ $gpaStats['countLessthanOnePointFive'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With GPA Between 1.5 - 1.74</td>
                <td>{{ $gpaStats['countBetweenOnePointFiveAndOnePointSevenFour'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With GPA Between 1.75 - 1.99</td>
                <td>{{ $gpaStats['countBetweenOnePointSevenFiveAndOnePointNineNine'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With GPA 2.00 above</td>
                <td>{{ $gpaStats['countGreaterthanTwoPoint'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With pass</td>
                <td>{{ $gpaStats['countPass'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With carryover</td>
                <td>{{ $gpaStats['totalStudents'] - $gpaStats['countPass'] }}</td>
            </tr>
            <tr>
                <td>Number of Students With Malpractice Cases</td>
                <td>0</td>
            </tr>
            </tbody>
        </table>

        <table class="text-left table table-bordered table-hover" class="gpa-stats-table"
               style="font-size:12px; line-height:1; width: 30%; ">
            <thead>
            <tr style="font-size:12px;">
                <th><strong>GRADE</strong></th>
                <th><strong>RANGE</strong></th>
                <th><strong>POINTS</strong></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($gradeScale as $scale)
                <tr>
                    <td>{{ $scale['grade'] }}</td>
                    <td>{{ $scale['min'] }}-{{ $scale['max'] }}</td>
                    <td>{{ $scale['point'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Signature Footer -->
<div class="signature-footer">
    <div>
        <span style="text-decoration: underline;">HOD'S SIGNATURE</span>
    </div>
    <div>
        <span style="text-decoration: underline;"><em>RECTOR'S SIGNATURE</em></span>
    </div>
    <div>
        <span style="text-decoration: underline;">DEAN'S SIGNATURE</span>
    </div>
</div>
</body>

</html>
