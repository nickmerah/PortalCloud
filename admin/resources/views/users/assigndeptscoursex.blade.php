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
                            <h4 class="page-title">Users</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Assign Course Advisers</a>
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
                            <!--edit -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Edit Course Adviser</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="{{route('courseadvisers')}}" autocomplete="off">
                                                @csrf
                                                <label for="email_address1">Surname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Surname" id="eu_surname" name="u_surname" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Firstname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Firstname" id="eu_firstname" name="u_firstname" required="required">
                                                    </div>
                                                </div>

                                                <label>Departments</label>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="form-line" id="courseOfStudyContainer">
                                                    </div>
                                                </div>

                                                <label>Level</label>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="form-line" id="levelContainer">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Courses Update Type
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="updatettype" class="form-control" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Add to Already assigned Departments</option>
                                                                <option value="0">Remove existing and add my selection</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <input type="hidden" class="form-control" id="euser_id" name="user_id" required="required">
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


                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example contact_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Assigned Departments</th>
                                        <th>Assigned Level</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $user->u_surname }} {{ $user->u_firstname }}</td>
                                        <td>@foreach($user->department_names as $deptName)
                                            <li>{{ $deptName }}</li>
                                            @endforeach
                                        </td>
                                        <td>@foreach($user->level_names as $levelName)
                                            <li>{{ $levelName }}</li>
                                            @endforeach
                                        </td>
                                        <td>
                                            <b style="color: {{ $user->u_status == 1 ? 'green' : 'red' }}">
                                                {{ $user->u_status == 1 ? 'Active' : 'Disabled' }}
                                            </b>

                                        </td>
                                        <td>

                                            <button data-bs-toggle="modal"
                                                data-id="{{ $user->user_id }}"
                                                data-level="{{ $user->u_level }}"
                                                data-department="{{ $user->u_cos }}"
                                                id="fieldEdit"
                                                class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>

                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();

                                    var user_id = $(this).data('id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: "{{ url('users') }}/" + user_id,
                                        type: "GET",
                                        data: {
                                            user_id: user_id,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');
                                            if (response.done) {
                                                $('#euser_id').val(response.data.user_id);
                                                $('#eu_username').val(response.data.u_username);
                                                $('#eu_surname').val(response.data.u_surname);
                                                $('#eu_firstname').val(response.data.u_firstname);
                                                $('#eu_status').val(response.data.u_status);

                                                const userLevels = response.data.u_level ? response.data.u_level.split(',') : [];
                                                $('#levelContainer input[type="checkbox"]').prop('checked', false);
                                                userLevels.forEach(function(levelId) {
                                                    $(`#levelContainer input[type="checkbox"][value="${levelId.trim()}"]`).prop('checked', true);
                                                });

                                                const userDepartments = response.data.u_cos ? response.data.u_cos.split(',') : [];
                                                $('#courseOfStudyContainer input[type="checkbox"]').prop('checked', false);
                                                userDepartments.forEach(function(deptId) {
                                                    $(`#courseOfStudyContainer input[type="checkbox"][value="${deptId.trim()}"]`).prop('checked', true);
                                                });

                                            } else {
                                                $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' + response.data + '</div>');
                                            }
                                        },
                                        error: function(response) {
                                            $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>An error occurred while processing your request.</div>');
                                        }
                                    });
                                });
                            </script>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    const levels = @json($levels);
                                    const departments = @json($departments);

                                    // Render departments (course of study)
                                    $('#courseOfStudyContainer').html('');
                                    if (departments.length > 0) {
                                        departments.forEach(function(dept) {
                                            $('#courseOfStudyContainer').append(`
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="cos[]" value="${dept.do_id}" />
                            <span>${dept.programme_option}</span>
                        </label>
                    </div>
                `);
                                        });
                                    } else {
                                        $('#courseOfStudyContainer').html('<p>No departments available.</p>');
                                    }

                                    // Render levels
                                    $('#levelContainer').html('');
                                    if (levels.length > 0) {
                                        levels.forEach(function(level) {
                                            $('#levelContainer').append(`
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="level[]" value="${level.level_id}" />
                            <span>${level.level_name}</span>
                        </label>
                    </div>
                `);
                                        });
                                    } else {
                                        $('#levelContainer').html('<p>No levels available.</p>');
                                    }
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