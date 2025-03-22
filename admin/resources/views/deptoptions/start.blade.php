@extends('apphead')

@section('contents')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Course of Study</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Course of Study</a>
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

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Course of Study<i class="material-icons">add</i> </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Add New</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" action="{{ route('cos.store') }}" autocomplete="off">
                                                @csrf
                                                <label for="email_address1">Department</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="dept_id" name="dept_id" class="form-control" required>
                                                            <option value="">Select Department</option>
                                                            @foreach($departments as $department)
                                                            <option value="{{ $department->departments_id }}">{{ $department->departments_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Course of Study Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Course of Study" name="programme_option" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="prog_id" name="prog_id" class="form-control" required>
                                                            <option value="">Select Programme</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Code</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Course of Study Code" name="deptcode" required="required">
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Save</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--edit -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Edit Course of Study</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PUT')

                                                <label for="email_address1">Department Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="dept_id" id="edept_id" class="form-control" required>
                                                            <option value="">Select Department</option>
                                                            @foreach($departments as $department)
                                                            <option value="{{ $department->departments_id }}">{{ $department->departments_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Course of Study Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="eprogramme_option" name="programme_option" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="prog_id" id="eprog_id" name="prog_id" class="form-control" required>
                                                            <option value="">Select Programme</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Code</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="ecode" name="deptcode" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Exam Date</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" id="eexam_date" name="exam_date">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Exam Time</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="time" class="form-control" id="eexam_time" name="exam_time">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Admission Letter Date</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" id="eadmletter_date" name="admletter_date">
                                                    </div>
                                                </div>
                                                <label for="email_address1">FT Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="d_status" id="ed_status" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <label for="email_address1">PT Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="d_status_pt" id="ed_status_pt" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <label for="email_address1">Available Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="prog_option" id="eprog_option" class="form-control" required>
                                                            <option value="">Select Available Status</option>
                                                            <option value="0">Both</option>
                                                            <option value="2">Only FT</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="form-control" id="edo_id" name="do_id" required="required">
                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Update</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end edit -->
                        </div>
                        </p>



                    </div>



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
                            <table class="table table-hover js-basic-example contact_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Programme</th>
                                        <th>Code</th>
                                        <?php /*      <th>ExamDate</th>
                                        <th>ExamTime</th> */ ?>
                                        <th>Status</th>
                                        <th>FTStatus</th>
                                        <th>PTStatus</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dept_options as $cos)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $cos->programme->aprogramme_name }} {{ $cos->programme_option }}</td>
                                        <td>{{ $cos->department->departments_name }}</td>
                                        <td>{{ $cos->programme->programme_name }}</td>
                                        <td>{{ $cos->deptcode }}</td>
                                        <?php /*   <td>{{ $cos->exam_date ? \Carbon\Carbon::parse($cos->exam_date)->format('jS F, Y') : '-' }}</td>
                                        <td>{{ $cos->exam_time ? \Carbon\Carbon::parse($cos->exam_time)->format('g:ia') : '-' }}</td>
                                        <td>{{ $cos->admletter_date ? \Carbon\Carbon::parse($cos->admletter_date)->format('jS F, Y')  : '-' }}</td>*/ ?>
                                        <td><span style="color: {{ $cos->prog_option == 0 ? 'green' : 'red' }}">
                                                {{ $cos->prog_option == 2 ? 'FT' : 'Both' }}
                                            </span></td>
                                        <td><span style="color: {{ $cos->d_status == 1 ? 'green' : 'red' }}">
                                                {{ $cos->d_status == 1 ? 'Enabled' : 'Disabled' }}
                                            </span></td>
                                        <td><span style="color: {{ $cos->d_status_pt == 1 ? 'green' : 'red' }}">
                                                {{ $cos->d_status_pt == 1 ? 'Enabled' : 'Disabled' }}
                                            </span></td>
                                        <td>
                                            <button data-bs-toggle="modal" data-id="{{ $cos->do_id }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>
                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();

                                    var do_id = $(this).data('id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');
                                    console.log(do_id);
                                    $.ajax({
                                        url: "{{ url('cos') }}/" + do_id,
                                        type: "GET",
                                        data: {
                                            do_id: do_id,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');
                                            if (response.done) {
                                                $('#edept_id').val(response.data.dept_id);
                                                $('#eprogramme_option').val(response.data.programme_option);
                                                $('#eprog_id').val(response.data.prog_id);
                                                $('#ecode').val(response.data.deptcode);
                                                $('#eexam_date').val(response.data.exam_date);
                                                $('#eexam_time').val(response.data.exam_time);
                                                $('#eadmletter_date').val(response.data.admletter_date);
                                                $('#ed_status').val(response.data.d_status);
                                                $('#ed_status_pt').val(response.data.d_status_pt);
                                                $('#eprog_option').val(response.data.prog_option);
                                                $('#editForm').attr('action', "{{ url('cos') }}/" + do_id);
                                            } else {
                                                $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' + response.data + '</div>');
                                            }
                                        },
                                        error: function(response) {
                                            //console.log(response);
                                            $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>An error occurred while processing your request.</div>');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection