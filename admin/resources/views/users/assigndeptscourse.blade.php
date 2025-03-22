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

                                                <label for="email_address1">Programme Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="progtype" id="progtype" class="form-control" required>
                                                            <option value="">Select Programme Type</option>
                                                            @foreach($programmeTypes as $programmeType)
                                                            <option value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="prog" id="prog" class="form-control" required>
                                                            <option value="">Select Programme</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label>Course of Study</label>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="form-line" id="courseOfStudyContainer">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Courses Update Type
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select name="updatettype" class="form-control" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Add to Already assigned Courses</option>
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
                                        <th>Prog</th>
                                        <th>ProgType</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $user->u_surname }} {{ $user->u_firstname }}</td>
                                        <td>@foreach($user->cos_option_names as $optionName)
                                            <li>{{ $optionName }}</li>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->programme?->aprogramme_name }}</td>
                                        <td>{{ $user->programmeType?->programmet_aname }}</td>
                                        <td>
                                            <b style="color: {{ $user->u_status == 1 ? 'green' : 'red' }}">
                                                {{ $user->u_status == 1 ? 'Active' : 'Disabled' }}
                                            </b>

                                        </td>
                                        <td>

                                            <button data-bs-toggle="modal" data-id="{{ $user->user_id }}" id="fieldEdit" class="btn btn-success edit">
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
                                    // Function to fetch course options
                                    function fetchCourseOptions() {
                                        let programmeId = $('#prog').val();
                                        let programmetId = $('#progtype').val();
                                        let _token = $('meta[name="csrf-token"]').attr('content');

                                        $('#courseOfStudyContainer').html(''); // Clear the container

                                        if (programmeId && programmetId) {
                                            $.ajax({
                                                url: "{{ url('dept-options') }}/" + programmeId + "/" + programmetId,
                                                type: "GET",
                                                headers: {
                                                    'X-CSRF-TOKEN': _token
                                                },
                                                success: function(response) {
                                                    if (response.options && response.options.length > 0) {
                                                        response.options.forEach(function(option) {
                                                            $('#courseOfStudyContainer').append(`
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="cos[]" value="${option.do_id}" />
                                            <span>${option.programme_option}</span>
                                        </label>
                                    </div>
                                `);
                                                        });
                                                    } else {
                                                        $('#courseOfStudyContainer').html('<p>No options available for this programme and programme type.</p>');
                                                    }
                                                },
                                                error: function() {
                                                    $('#courseOfStudyContainer').html('<p class="text-danger">An error occurred while fetching course options.</p>');
                                                }
                                            });
                                        } else {
                                            $('#courseOfStudyContainer').html('<p>Please select both Programme and Programme Type.</p>');
                                        }
                                    }

                                    // Trigger fetchCourseOptions when either prog or progtype changes
                                    $('#prog, #progtype').change(function() {
                                        fetchCourseOptions();
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