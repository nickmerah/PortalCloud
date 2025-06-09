@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8"><br>
                <div class="card">
                    <div class="card-header">{{ __('Upload Result Sheet') }}</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ url('importResult') }}">
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
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Instruction: Browse to select the excel sheet, select a session,
                                            level, semester, course of study and import. Excel Files must be in .xls
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody style="font-size:13px">

                                    <tr>
                                        <td><strong>Current Session</strong></td>
                                        <td><select name="sess" id="sess" class="form-control" required="required">

                                                <option value="{{ $sess }}">{{ $sess }} / {{ $sess + 1 }}</option>

                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Level</strong></td>
                                        <td>

                                            <select name="clevel" id="clevel" class="form-control" required>
                                                <option value=""> Select Level</option>
                                                @foreach ($levels as $clevel)
                                                    <option
                                                        value="{{ $clevel->level_id}}"> {{ $clevel->level_name}} </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semester</strong></td>
                                        <td>

                                            <select name="semester" id="semester" class="form-control" required
                                                    disabled>
                                                <option value=""> Select Semester</option>
                                                <option value="First Semester"> First Semester</option>
                                                <option value="Second Semester"> Second Semester</option>
                                            </select>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Course of Study</strong></td>
                                        <td>

                                            <select name="courseofstudy" id="courseofstudy" class="form-control"
                                                    required disabled>
                                                <option value=""> Select Course of Study</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Course</strong></td>
                                        <td>

                                            <select name="courses" id="courses" class="form-control" required disabled>
                                                <option value=""> Select Course Code</option>
                                            </select>

                                        </td>
                                    </tr>
                                    <td><span class="fieldarea"><strong>Location of the Excel File</strong></span></td>
                                    <td><input id="uploadImage" type="file" accept=".xls" name="file"
                                               placeholder="Select Excel file" required class="form-control"/>
                                        File must be saved in .xls extension
                                    </td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <button id="button" type="submit" class="btn btn-success">Upload Excel
                                                Sheet </i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="text-center">
                            <a href="{{ asset('result.xls') }}" download>Download Result Template</a>

                            | <a href="{{ route('uploadedresult') }}"> Check Uploaded Results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#clevel').change(function () {
            $('#semester').prop('disabled', false);
        });

        $('#semester').change(function () {
            $('#courseofstudy').prop('disabled', false);
            let levelId = $('#clevel').val();
            if (levelId) {
                $.ajax({
                    url: '{{ url("/get-cos") }}',
                    type: 'GET',
                    data: {
                        level_id: levelId
                    },
                    success: function (data) {
                        $('#courseofstudy').empty().append('<option value=""> Select Course of Study </option>');
                        $.each(data, function (key, program) {
                            $('#courseofstudy').append('<option value="' + program.do_id + '">' + program.programme_option + '</option>');
                        });
                    }
                });
            } else {
                $('#courseofstudy').empty().append('<option value=""> Select Course of Study </option>');
            }

        });

        $('#courseofstudy').change(function () {
            $('#courses').prop('disabled', false);
            let levelId = $('#clevel').val();
            let semester = $('#semester').val();
            let cosId = $(this).val();
            if (levelId && semester && cosId) {
                $.ajax({
                    url: '{{ url("/get-courses") }}',
                    type: 'GET',
                    data: {
                        level_id: levelId,
                        semester: semester,
                        cos_id: cosId
                    },
                    success: function (data) {
                        $('#courses').empty().append('<option value=""> Select Course Code </option>');
                        $.each(data, function (key, course) {
                            $('#courses').append('<option value="' + course.thecourse_id + '">' + course.thecourse_code + '</option>');
                        });
                    }
                });
            } else {
                $('#courses').empty().append('<option value=""> Select Course Code </option>');
            }
        });
    </script>
@endsection
