@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"><br>
            <div class="card">
                <style>
                    .pagination {
                        list-style: none;
                        display: flex;
                        gap: 5px;
                        padding: 0;
                    }

                    .pagination li {
                        padding: 4px 8px;
                        border: 1px solid #ccc;
                    }

                    .pagination li strong {
                        background: #007bff;
                        color: white;
                    }

                    .pagination li a {
                        text-decoration: none;
                        color: #007bff;
                    }
                </style>
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
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

                <div class="dataTable_wrapper p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">STUDENT LIST</h4>
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            Upload Student
                        </button>
                    </div> @if(session('success'))
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
                    <table style="font-size:12px;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th><strong>S/N</strong></th>
                                <th><strong>FULLNAMES</strong></th>
                                <th><strong>COURSE</strong></th>
                                <th><strong>LEVEL</strong></th>
                                <th><strong>ACTION</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->departmentOption->programme_option ?? '' }}</td>
                                <td>{{ $student->level->level_name ?? '' }}</td>
                                <td>
                                    <form action="{{ route('students.destroy', $student->std_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($students->onFirstPage())
                        <li><span>Previous</span></li>
                        @else
                        <li><a href="{{ $students->previousPageUrl() }}">Previous</a></li>
                        @endif

                        {{-- Page Numbers --}}
                        @for ($page = 1; $page <= $students->lastPage(); $page++)
                            @if ($page == $students->currentPage())
                            <li><strong>{{ $page }}</strong></li>
                            @else
                            <li><a href="{{ $students->url($page) }}">{{ $page }}</a></li>
                            @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($students->hasMorePages())
                            <li><a href="{{ $students->nextPageUrl() }}">Next</a></li>
                            @else
                            <li><span>Next</span></li>
                            @endif
                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Upload Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="programme" class="form-label">Programme</label>
                        <select class="form-control" name="prog" id="prog">
                            <option value="">Select</option>
                            @foreach ($programmes as $programme)
                            <option value="{{ $programme->programme_id }}">
                                {{ $programme->programme_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="programme_type" class="form-label">Programme Type</label>
                        <select class="form-control" name="progtype" id="progtype">
                            <option value="">Select</option>
                            @foreach ($programmeTypes as $programmeType)
                            <option value="{{ $programmeType->programmet_id }}">
                                {{ $programmeType->programmet_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="course_of_study" class="form-label">Course of Study</label>
                        <select class="form-control" name="course_of_study" id="course_of_study">
                            <option value="">Select</option>
                            @foreach ($courseofstudy as $course)
                            <option value="{{ $course->do_id }}">
                                {{ $course->programme_option }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-control" name="level" id="level">
                            <option value="">Select</option>
                            @foreach ($levels as $level)
                            <option value="{{ $level->level_id }}">
                                {{ $level->level_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Select Student list file in .csv file</label>
                        <input type="file" class="form-control" name="csv_file" accept=".csv" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
                <div class="text-center">
                    <a href="{{ asset('students.csv') }}" download>Download Template</a>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            dom: 'Bfrtip',
            paging: false,
            info: false,
            autoWidth: true,
            responsive: true,
            pageLength: <?= $students->count() ?>,
        });
    });
</script>
@endsection