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
                    <form method="POST" action="{{ url('saveResult') }}" enctype="multipart/form-data">
                        @csrf
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th colspan="9" style="text-align:center; font-size:20px; font-family:Tahoma, Geneva, sans-serif">
                                        <img src="https://portal.mydspg.edu.ng/eportal/public/images/logo.png" width="70" height="80" alt="Logo" class="responsive-logo"><br> {{ $schoolname }}<br>
                                        <span style="font-size:14px;">
                                            {{ $level }} {{ strtoupper($semester) }} - {{ $session }} / {{ $session + 1 }} SESSION
                                        </span><br>
                                        <span style="font-size:14px;">
                                            {{ $course?->course_code }} - {{ $course?->course_title }} - {{ $course?->course_unit }}
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
                                @foreach ($students as $matricno)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $matricno  }}</td>
                                    <td> <input type="number" width="1px" step="0.01" min=0 max=40 name="cat[{{ $loop->index }}]" class="form-control" required></td>
                                    <td> <input type="number" width="1px" step="0.01" min=0 max=60 name="exam[{{ $loop->index }}]" class="form-control" required></td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div> <button id="button" type="submit" class="btn btn-success"
                    onclick="return confirm('Are you sure you want to save these scores?');">
                    <i class="fa fa-save"></i>
                    Save Scores
                </button>
                </form>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                dom: 'Bfrtip',
                paging: false,
                info: false,
                ordering: false,
            });
        });
    </script>
    @endsection