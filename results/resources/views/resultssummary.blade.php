@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8"> <br>
            <div class="card">
                <div class="card-header">{{ __('View Result Summary') }}</div>

                <div class="card-body">


                    <form method="GET" action="{{ url('viewResult') }}">
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
                                        <th colspan="2">Instruction: Browse to select session, level, semester, course of study and view results. </th>
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
                                                <option value=""> Select Level </option>
                                                @foreach ($levels as $clevel)
                                                <option value="{{ $clevel->level_id}}"> {{ $clevel->level_name}} </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semester</strong></td>
                                        <td>

                                            <select name="semester" id="semester" class="form-control" required disabled>
                                                <option value=""> Select Semester </option>
                                                <option value="First Semester"> First Semester </option>
                                                <option value="Second Semester"> Second Semester </option>
                                            </select>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Course of Study</strong></td>
                                        <td>

                                            <select name="courseofstudy" id="courseofstudy" class="form-control" required disabled>
                                                <option value=""> Select Course of Study </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td> <button id="button" type="submit" class="btn btn-success">View Result </i>
                                            </button> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#clevel').change(function() {
        $('#semester').prop('disabled', false);
    });

    $('#semester').change(function() {
        $('#courseofstudy').prop('disabled', false);
        let levelId = $('#clevel').val();
        if (levelId) {
            $.ajax({
                url: '{{ url("/get-cos") }}',
                type: 'GET',
                data: {
                    level_id: levelId
                },
                success: function(data) {
                    $('#courseofstudy').empty().append('<option value=""> Select Course of Study </option>');
                    $.each(data, function(key, program) {
                        $('#courseofstudy').append('<option value="' + program.do_id + '">' + program.programme_option + '</option>');
                    });
                }
            });
        } else {
            $('#courseofstudy').empty().append('<option value=""> Select Course of Study </option>');
        }

    });
</script>
@endsection