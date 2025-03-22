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
                            <a href="#" onClick="return false;">Users</a>
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

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add User<i class="material-icons">add</i> </button>
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
                                            <form class="form-signin" method="post" action="{{ route('users.store') }}" autocomplete="off">
                                                @csrf
                                                <label for="email_address1">Surname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Surname" name="u_surname" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Firstname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Firstname" name="u_firstname" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Email</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" placeholder="Enter Emal" name="u_email" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Role</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="u_group" class="form-control" required>
                                                            <option value="">Select Role</option>
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->group_id }}">{{ $role->group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <br>
                                                ACCOUNT INFO
                                                <hr>
                                                <label for="email_address1">Username</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Username" name="u_username" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Password</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Password" name="u_password" required="required">
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
                                            <h5 class="modal-title" id="formModal">Edit User</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PUT')
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

                                                <label for="email_address1">Email</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" placeholder="Enter Email" id="eu_email" name="u_email" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Role</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="u_group" id="eu_group" class="form-control" required>
                                                            <option value="">Select Role</option>
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->group_id }}">{{ $role->group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="u_status" id="eu_status" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Disabled</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <br>
                                                ACCOUNT INFO
                                                <hr>
                                                <label for="email_address1">Username</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Username" id="eu_username" name="u_username" required="required">
                                                    </div>
                                                </div>

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


                            <!--change pass -->
                            <div class="modal fade" id="editpModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Change Password</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editpForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PATCH')

                                                ACCOUNT INFO
                                                <hr>
                                                <label for="email_address1">Username</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="pu_username" name="u_username" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Password</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Password" name="u_password" required="required">
                                                    </div>
                                                </div>

                                                <input type="hidden" class="form-control" id="puser_id" name="user_id" required="required">
                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect" onclick="return confirm('Are you sure you want to change the password?')">Change Password</button>


                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end change pass -->

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
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $user->u_surname }} {{ $user->u_firstname }}</td>
                                        <td>{{ $user->u_username }}</td>
                                        <td>{{ $user->usergroup->group_name ?? 'NA'}}</td>
                                        <td>
                                            <b style="color: {{ $user->u_status == 1 ? 'green' : 'red' }}">
                                                {{ $user->u_status == 1 ? 'Active' : 'Disabled' }}
                                            </b>

                                        </td>
                                        <td>

                                            <button data-bs-toggle="modal" data-id="{{ $user->user_id }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>

                                            <button data-bs-toggle="modal" data-id="{{ $user->user_id }}" id="fieldPassword" class="btn btn-danger edit">
                                                <i class="material-icons">lock</i>
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
                                                $('#eu_email').val(response.data.u_email);
                                                $('#eu_status').val(response.data.u_status);
                                                $('#eu_group').val(response.data.u_group);
                                                $('#editForm').attr('action', "{{ url('users') }}/" + user_id);
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
                                $(document).on('click', '#fieldPassword', function(e) {
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
                                        success: function(responsep) {
                                            $('#editpModal').modal('show');
                                            if (responsep.done) {
                                                $('#puser_id').val(responsep.data.user_id);
                                                $('#pu_username').val(responsep.data.u_username);
                                                $('#editpForm').attr('action', "{{ url('updateuserspass') }}/" + user_id);
                                            } else {
                                                $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' + responsep.data + '</div>');
                                            }
                                        },
                                        error: function(responsep) {
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