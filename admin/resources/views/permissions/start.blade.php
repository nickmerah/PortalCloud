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
                            <a href="#" onClick="return false;">Permissions</a>
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

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Group Permission<i class="material-icons">add</i> </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Add New Group Permission</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" action="{{ route('permissions.store') }}" autocomplete="off">
                                                @csrf


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

                                                <label>Permissions</label>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        @foreach($menuPermissions as $key => $label)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="permissions[]" value="{{ $key }}" />
                                                                <span>{{ $label }}</span>
                                                            </label>
                                                        </div>
                                                        @endforeach
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
                                            <h5 class="modal-title" id="formModal">Edit User Permission</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PUT')

                                                <label for="email_address1">Role</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="u_group" id="egroup_id" class="form-control" required>
                                                            <option value="">Select Role</option>
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->group_id }}">{{ $role->group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label>Permissions</label>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        @foreach($menuPermissions as $key => $label)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="efeature" name="permissions[]" value="{{ $key }}" />
                                                                <span>{{ $label }}</span>
                                                            </label>
                                                        </div>
                                                        @endforeach
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
                                        <th>User Group</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php

                                    $groupedPermissions = $permissions->groupBy('group_name');
                                    @endphp

                                    @foreach ($groupedPermissions as $groupName => $groupPermissions)

                                    @php

                                    $groupId = $groupPermissions->first()->group_id;
                                    @endphp
                                    <tr>
                                        <td>{{ $groupName }}</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                @foreach ($groupPermissions as $permission)
                                                <li>{{ ucfirst(substr($permission->feature, 6)) }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>

                                            <button data-bs-toggle="modal" data-id="{{ $groupId }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();

                                    var group_id = $(this).data('id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: "{{ url('permissions') }}/" + group_id,
                                        type: "GET",
                                        data: {
                                            group_id: group_id,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');

                                            if (response.done) {
                                                $('#egroup_id').val(response.data[0].group_id);

                                                $('input[name="permissions[]"]').prop('checked', false);
                                                response.data.forEach(function(permission) {
                                                    $('input[name="permissions[]"][value="' + permission.feature + '"]').prop('checked', true);
                                                });
                                                $('#editForm').attr('action', "{{ url('permissions') }}/" + group_id);
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection