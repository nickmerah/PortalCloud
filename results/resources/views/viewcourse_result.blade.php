@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"><br>
            <div class="card">
                <!-- DataTables CSS -->
                <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

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
                                <th colspan="9" style="text-align:center; font-size:20px; font-family:Tahoma, Geneva, sans-serif">
                                    <img src="https://portal.mydspg.edu.ng/eportal/public/images/logo.png" width="70" height="80" alt="Logo" class="responsive-logo"><br> {{ $schoolname }}<br>
                                    <span style="font-size:14px;">
                                        {{ $level }} {{ strtoupper($semester) }} - {{ $session }} / {{ $session + 1 }} SESSION
                                    </span><br>
                                    <span style="font-size:14px;">
                                        {{ $results[0]?->course_code }} - {{ $results[0]?->course_title }} - {{ $results[0]?->course_unit }}
                                    </span>
                                </th>
                            </tr>
                            <tr style="font-size:12px;">
                                <th><strong>S/N</strong></th>
                                <th><strong>REG NUMBER</strong></th>
                                <th><strong>CAT (40%)</strong></th>
                                <th><strong>EXAM (60%)</strong></th>
                                <th><strong>TOTAL (100%)</strong></th>
                                <th><strong>REMARK</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result->matric_no }}</td>
                                <td>{{ $result->cat }}</td>
                                <td>{{ $result->exam }}</td>
                                <td>{{ $result->std_mark }}</td>
                                <td>{{ $result->std_rstatus }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>




                </div>
            </div>
        </div>
    </div>




    <script>
        const levelSessionText = "{{ $results[0]->clevel_id }}00 LEVEL {{ $results[0]->cyearsession }} / {{ $results[0]->cyearsession + 1 }} SESSION";
        const courseTitleText = "{{ $results[0]->coursecode }} - {{ $results[0]->coursetitle }}";

        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                dom: 'Bfrtip',
                paging: false,
                info: false,
                buttons: [{
                        extend: 'copyHtml5',
                        title: 'DELTA STATE POLYTECHNIC, OGWASHI-UKU',
                        messageTop: 'COURSE RESULT\n' +
                            levelSessionText + '\n' +
                            courseTitleText,
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the last column (REMARK)
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'DELTA STATE POLYTECHNIC, OGWASHI-UKU',
                        messageTop: 'COURSE RESULT\n' +
                            levelSessionText + '\n' +
                            courseTitleText,
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the last column (REMARK)
                        }
                    }
                ],
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'DELTA STATE POLYTECHNIC, OGWASHI-UKU',
                        messageTop: 'COURSE RESULT\n' +
                            levelSessionText + '\n' +
                            courseTitleText,
                    },
                    {
                        extend: 'pdfHtml5',
                        title: '',
                        customize: function(doc) {
                            doc.content.splice(0, 0, {
                                text: [
                                    "DELTA STATE POLYTECHNIC, OGWASHI-UKU\n",
                                    "COURSE RESULT\n",
                                    levelSessionText + "\n",
                                    courseTitleText
                                ],
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                fontSize: 12,
                                bold: true
                            });
                        },
                        orientation: 'landscape',
                        pageSize: 'A4'
                    }
                ]
            });
        });
    </script>
    @endsection