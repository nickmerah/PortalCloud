@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12"><br>
                <div class="card">
                    <!-- DataTables CSS -->
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                    <link rel="stylesheet"
                          href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

                    <!-- jQuery -->
                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

                    <!-- DataTables JS -->
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

                    <!-- Buttons JS -->
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th colspan="{{ $colspan }}" style="padding: 10px;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 80px; vertical-align: top;">
                                                <img src="https://portal.mydspg.edu.ng/eportal/public/images/logo.png"
                                                     width="120" height="140" alt="Logo">
                                            </td>
                                            <td style="text-align: left; padding-left: 10px; font-family: Tahoma, Geneva, sans-serif;">
                                                <strong style="font-size: 16px;">{{ $schoolname }}</strong><br>
                                                <span style="font-size:12px;"><strong>SCHOOL:</strong> {{$courseofstudy[0]->department->faculty->faculties_name}}</span><br>
                                                <span style="font-size:12px;"><strong>DEPARTMENT:</strong> {{$courseofstudy[0]->programme_option}}</span><br>
                                                <span style="font-size:12px;"><strong>EXAMINATION:</strong> {{ strtoupper($semester) }} RESULT</span><br>
                                                <span style="font-size:12px;"><strong>PROGRAMME:</strong> {{ $courseofstudy[0]->programme->programme_name}} | LEVEL: {{ $level }} </span><br>
                                                <span style="font-size:12px;"><strong>SESSION:</strong> {{ $session }}/{{ $session + 1 }} </span>
                                            </td>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                            <tr style="font-size:12px;">
                                <th></th>
                                <th><strong>FULLNAME</strong></th>
                                <th><strong>
                                        <div class="text-center"
                                             style="line-height: 1;">{!! str_replace(' ', '<br>', 'MATRICULATION NUMBER') !!}
                                        </div>
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
                                <th><strong></strong></th>
                                <th></th>
                                @foreach ($courses as $course)
                                    <th><strong>
                                            <div class="text-center"
                                                 style="line-height: 1;">{!! str_replace(' ', '<br>', $course->courseunit) !!}</div>
                                        </strong></th>
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
                                            {{ $data?->std_mark ?? '' }}{{ $data?->std_rstatus ?? '' }}
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
                    <a href="{{ route('resultSummary', [$result->level_id, $session, $semester == 'First Semester' ? 1 : 2, $courseofstudy[0]->do_id, 'print']) }}"
                       class="btn btn-success" target="_blank">
                        View Result Summary
                    </a>

                </div>
            </div>
        </div>

@endsection
