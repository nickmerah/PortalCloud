@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <br>
            <div class="card">
                <div class="card-header">{{ __('Course Result Sheet') }}</div>

                <div class="card-body">


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

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <tbody>
                                <tr>
                                    <td><strong>S/N</strong></td>
                                    <td><strong>Course Code</strong></td>
                                    <td><strong>Course Title</strong></td>
                                    <td><strong>Semester</strong></td>
                                    <td><strong>Session</strong></td>
                                    <td><strong>Level</strong></td>
                                    <td><strong>Total Students</strong></td>
                                    <td><strong>Action</strong></td>
                                </tr>
                                @foreach ($results as $result) <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $result->course_code }}</td>
                                    <td>{{ $result->course_title }}</td>
                                    <td>{{ $result->semester }} @php $sem = $result->semester == 'First Semester' ? 1 : 2 @endphp</td>
                                    <td>{{ $result->cyearsession }}</td>
                                    <td>{{ $result->level->level_name }}</td>
                                    <td>{{ $result->total_students }}</td>
                                    <td><a href="{{ route('view.result', [$result->stdcourse_id, $result->level_id, $result->cyearsession, $sem]) }}" class="btn btn-primary btn-sm" target="_blank">View </a> <a href="{{ route('delete.result', [$result->stdcourse_id, $result->level_id, $result->cyearsession, $sem]) }}"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this result?');">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
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
            pageLength: <?= $results->count() ?>,
        });
    });
</script>




@endsection