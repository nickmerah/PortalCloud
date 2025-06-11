@extends('apphead')

@section('contents')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">All Students</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{URL::to('/welcome') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Students</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">

                            <p>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#searchModal">Search Students<i
                                        class="material-icons">search</i>
                                </button>
                                &nbsp;
                                <a href="{{ route('addstudent') }}" class="btn btn-success">
                                    Add Student <i class="material-icons">add</i>
                                </a>

                                &nbsp;
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#studentModal">Student List<i class="material-icons">search</i>
                                </button>

                                <div class="modal fade" id="searchModal" tabindex="-1" role="dialog"
                                     aria-labelledby="formModal" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="formModal">Search Students</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="GET" action="{{ route('students.index') }}">
                                                    <label for="email_address1">Matriculation No</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" name="matric_no"
                                                                   value="{{ request('matric_no') }}">
                                                        </div>
                                                    </div>

                                                    <label for="email_address1">Surname</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" name="surname"
                                                                   value="{{ request('surname') }}">
                                                        </div>
                                                    </div>
                                                    <label for="email_address1">Programme</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="prog_id" id="prog_id" class="form-control">
                                                                <option value="">&nbsp;</option>
                                                                @foreach($programmes as $programme)
                                                                    <option
                                                                        value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <label for="email_address1">Course of Study</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="courseofstudy" id="courseofstudy"
                                                                    class="form-control" disabled>
                                                                <option value=""> Select Course of Study</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <label for="email_address1">Programme Type</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="progtype_id" class="form-control">
                                                                <option value="">&nbsp;</option>
                                                                @foreach($programmeTypes as $programmeType)
                                                                    <option
                                                                        value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <label for="email_address1">Level</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="level_id" class="form-control">
                                                                <option value="">&nbsp;</option>
                                                                @foreach($levels as $level)
                                                                    <option
                                                                        value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-info waves-effect">Search
                                                        Student
                                                    </button>

                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-danger waves-effect"
                                                        data-bs-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="studentModal" tabindex="-1" role="dialog"
                                     aria-labelledby="formModal" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="formModal">Get Students List</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ url('/studentlist') }}" target="_blank">
                                                    @csrf
                                                    <label for="email_address1">Programme</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="prog_id" class="form-control"
                                                                    required="required">
                                                                <option value="">&nbsp;</option>
                                                                @foreach($programmes as $programme)
                                                                    <option
                                                                        value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <label for="email_address1">Programme Type</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="progtype_id" class="form-control"
                                                                    required="required">
                                                                <option value="">&nbsp;</option>
                                                                @foreach($programmeTypes as $programmeType)
                                                                    <option
                                                                        value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <label for="email_address1">Level</label>
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="level_id" class="form-control"
                                                                    required="required">
                                                                <option value="">&nbsp;</option>
                                                                @foreach($levels as $level)
                                                                    <option
                                                                        value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-info waves-effect">Get Student
                                                        List
                                                    </button>

                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-danger waves-effect"
                                                        data-bs-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog"
                                     aria-labelledby="formModal" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="formModal">Enable Passport Upload</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-signin" method="post" enctype="multipart/form-data"
                                                      action="{{ route('uploadstudentphoto') }}">
                                                    @csrf

                                                    <div class="form-group">

                                                        <div class="form-line">
                                                            <input type="file"
                                                                   class="form-control"

                                                                   name="passport" required="required"
                                                                   accept=".jpg,.jpeg">
                                                        </div>

                                                        <input name="sid" type="hidden" id="sid"> Max. Upload size is
                                                        100kb.


                                                    </div>


                                                    <br>
                                                    <button type="submit" class="btn btn-info waves-effect">Save
                                                        Passport
                                                    </button>

                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-danger waves-effect"
                                                        data-bs-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                </p>

                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
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
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="body">
                                <div class="table-responsive">

                                    <table class="table table-hover "
                                           style="font-size:12px">
                                        <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th class="center"> Matriculation No</th>
                                            <th class="center"> Fullnames</th>
                                            <th class="center">Programme</th>
                                            <th class="center"> Programme</th>
                                            <th class="center"> Level</th>
                                            <th class="center"> Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($students as $student)
                                            <tr class="odd gradeX">
                                                <td class="table-img center">
                                                    <a data-bs-toggle="modal" data-bs-target="#pictureModal"
                                                       id="submit{{$student->std_id}}">

                                                        @php
                                                            $filePath = '/home/prtald/public_html/eportal/storage/app/public/passport/' . $student->std_photo;
                                                            $fileExists = file_exists($filePath);
                                                        @endphp

                                                        @if ($fileExists)
                                                            <img
                                                                src="{{ 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/' . $student->std_photo }}"
                                                                width="100" height="80">
                                                        @else
                                                            <img
                                                                src="{{ 'https://portal.mydspg.edu.ng/eportal/public/avatar.jpg' }}"
                                                                width="100" height="80">
                                                        @endif

                                                    </a>


                                                </td>
                                                <td class="center">{{ $student->matric_no }}</td>
                                                <td class="center">{{ stripslashes($student->surname) }} {{ stripslashes($student->firstname) }} {{ stripslashes($student->othername) }}</td>
                                                <td class="center">{{ $student->programme->programme_name ?? 'N/A' }}

                                                    <input id="smode{{$student->std_id}}" type="hidden"
                                                           value="{{ $student->std_id }}"/>

                                                </td>
                                                <td class="center"> {{ $student->programmeType->programmet_name ?? 'N/A' }} </td>
                                                <td class="center">

                                                    {{ $student->level->level_name ?? 'N/A' }}

                                                </td>
                                                <td class="center">
                                                    <a href="{{URL::to('/studentsview/'.$student->std_id) }}"
                                                       class="btn btn-tbl-edit">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{URL::to('/students/'.$student->std_id) }}"
                                                       class="btn btn-tbl-edit">
                                                        <i class="material-icons">create</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <script type="text/javascript">
                                                $("#submit{{$student->std_id}}").click(function () {
                                                    var text = $("#smode{{$student->std_id}}").val();
                                                    console.log(text);
                                                    $("#modal_body").html(text);
                                                    document.getElementById("sid").value = text;
                                                });
                                            </script>

                                        @endforeach


                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                    <div>
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            @if (!$students->onFirstPage())
                                                <li><a href="{{ $students->previousPageUrl() }}">Previous</a></li>
                                            @endif

                                            {{-- Page Numbers with sliding window --}}
                                            @php
                                                $start = max(1, $students->currentPage() - 2);
                                                $end = min($students->lastPage(), $students->currentPage() + 8);
                                            @endphp

                                            @if ($start > 1)
                                                <li><a href="{{ $students->url(1) }}">1</a></li>
                                                @if ($start > 2)
                                                    <li><span>…</span></li>
                                                @endif
                                            @endif

                                            @for ($page = $start; $page <= $end; $page++)
                                                @if ($page == $students->currentPage())
                                                    <li><strong>{{ $page }}</strong></li>
                                                @else
                                                    <li><a href="{{ $students->url($page) }}">{{ $page }}</a></li>
                                                @endif
                                            @endfor

                                            @if ($end < $students->lastPage())
                                                @if ($end < $students->lastPage() - 1)
                                                    <li><span>…</span></li>
                                                @endif
                                                <li>
                                                    <a href="{{ $students->url($students->lastPage()) }}">{{ $students->lastPage() }}</a>
                                                </li>
                                            @endif

                                            {{-- Next Page Link --}}
                                            @if ($students->hasMorePages())
                                                <li><a href="{{ $students->nextPageUrl() }}">Next</a></li>
                                            @endif
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#prog_id').change(function () {
            $('#courseofstudy').prop('disabled', false);
            let prog_id = $('#prog_id').val();
            if (prog_id) {
                $.ajax({
                    url: '{{ url("/get-cos/") }}' + '/' + prog_id,
                    type: 'GET',
                    success: function (data) {
                        $('#courseofstudy').empty().append('<option value=""> Select Course of Study </option>');
                        $.each(data, function (key, programme_option) {
                            $('#courseofstudy').append('<option value="' + key + '">' + programme_option + '</option>');
                        });
                    }
                });
            } else {
                $('#courseofstudy').empty().append('<option value=""> Select Course of Study </option>');
            }

        });
    </script>
@endsection
