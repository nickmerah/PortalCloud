<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="K5eg9TIJNwWudsb1bWC7tQlCTgnulY9KSaLOCkAz">

    <title>Delta State Polytechnic Ogwashi-Uku | Comprehensive Result Sheet</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles and Scripts -->
    <link rel="preload" as="style" href="{{ asset('build/assets/app-DZUsWXEA.css') }}" />
    <link rel="modulepreload" href="{{ asset('build/assets/app-pd4cR8cG.js') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-DZUsWXEA.css') }}" />
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
            <?php /*<tr>
                <th colspan="{{ $colspan }}" style="padding: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 80px; vertical-align: top;">
                                <img src="https://portal.mydspg.edu.ng/eportal/public/images/logo.png" width="120" height="140" alt="Logo">
                            </td>
                            <td style="text-align: left; padding-left: 10px; font-family: Tahoma, Geneva, sans-serif;">
                                <strong style="font-size: 16px;">{{ $schoolname }}</strong><br>
                                <span style="font-size:12px;"><strong>SCHOOL:</strong> {{ $courseofstudy[0]->department->faculty->faculties_name }}</span><br>
                                <span style="font-size:12px;"><strong>DEPARTMENT:</strong> {{ $courseofstudy[0]->programme_option }}</span><br>
                                <span style="font-size:12px;"><strong>EXAMINATION:</strong> {{ strtoupper($semester) }} RESULT</span><br>
                                <span style="font-size:12px;"><strong>PROGRAMME:</strong> {{ $courseofstudy[0]->programme->programme_name }} | LEVEL: {{ $level }}</span><br>
                                <span style="font-size:12px;"><strong>SESSION:</strong> {{ $session }}/{{ $session + 1 }}</span>
                            </td>
                        </tr>
                    </table>
                </th>
            </tr>*/ ?>
            <tr style="font-size:12px;">
                <th></th>
                <th><strong>FULLNAME</strong></th>
                <th><strong>
                        <div class="text-center" style="line-height: 1;">{!! str_replace(' ', '<br>', 'MATRICULATION NUMBER') !!}</div>
                    </strong></th>
                @foreach ($courses as $course)
                <th><strong>
                        <div class="text-center" style="line-height: 1;">{!! str_replace(' ', '<br>', $course->coursecode) !!}</div>
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

    </div>

    <!-- Summary Section -->
    <div class="page-break summary-section">
        <h4>Result Summary</h4>
        <p>Total Students: {{ count($results) }}</p>
        <p>Passed: {{ $results->where('status', 'PROMOTED')->count() }}</p>
        <p>Failed: {{ $results->where('status', '!=', 'PROMOTED')->count() }}</p>
    </div>

    </main>


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