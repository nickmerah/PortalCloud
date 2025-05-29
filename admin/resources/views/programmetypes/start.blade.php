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
                            <h4 class="page-title">Programme Types</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Programme Types</a>
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

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Programme<i class="material-icons">add</i> </button>
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
                                            <form class="form-signin" method="post" action="{{ route('programmetypes.store') }}" autocomplete="off">
                                                @csrf
                                                <label for="email_address1">Programme Type Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Programme Type Name" name="programmet_name" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="d_status" id="d_status" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>

                                                        </select>
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
                                            <h5 class="modal-title" id="formModal">Edit Programme Type</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PUT')

                                                <label for="email_address1">Programme Type Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="eprogrammet_name" name="programmet_name" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="d_status" id="ed_status" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="form-control" id="eprogrammet_id" name="programmet_id" required="required">
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programmetypes as $programmetype)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $programmetype->programmet_name }}</td>
                                        <td><span style="color: {{ $programmetype->pt_status == 1 ? 'green' : 'red' }}">
                                                {{ $programmetype->pt_status == 1 ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>

                                            <button data-bs-toggle="modal" data-id="{{ $programmetype->programmet_id }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>


                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();

                                    var programmet_id = $(this).data('id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: "{{ url('programmetypes') }}/" + programmet_id,
                                        type: "GET",
                                        data: {
                                            programmet_id: programmet_id,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');
                                            //console.log(response);
                                            if (response.done) {
                                                $('#eprogrammet_name').val(response.data.programmet_name);
                                                $('#ed_status').val(response.data.pt_status);
                                                $('#eprogrammet_id').val(programmet_id);
                                                $('#editForm').attr('action', "{{ url('programmetypes') }}/" + programmet_id);
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