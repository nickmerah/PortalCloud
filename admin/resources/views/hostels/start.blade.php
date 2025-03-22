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
                            <h4 class="page-title">Hostels</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Hostels</a>
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
                                            <h5 class="modal-title" id="formModal">Edit Hostel</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PUT')

                                                <label for="email_address1">Hostel Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="ehostelname" name="hostelname" disabled="disabled">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Hostel Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="hostel_status" id="ehostel_status" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <input type="hidden" class="form-control" id="ehid" name="hid" required="required">
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
                                        <th>Block</th>
                                        <th>Type</th>
                                        <th>Gender</th>
                                        <th>Rooms</th>
                                        <th>Rate</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hostels as $hostel)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $hostel->hostelname }}</td>
                                        <td>{{ $hostel->blockname }}</td>
                                        <td>{{ $hostel->blocktype }}</td>
                                        <td>{{ $hostel->gender }}</td>
                                        <td>
                                            <a href="{{ route('hostels.rooms', ['hostel' => $hostel->hid]) }}">
                                                {{ $hostel->rooms()->count() }}
                                            </a>
                                        </td>
                                        <td>{{ $hostel->ofee->of_amount ? number_format($hostel->ofee->of_amount) : 0 }}</td>
                                        <td>
                                            <b style="color: {{ $hostel->hostel_status == 1 ? 'green' : 'red' }}">
                                                {{ $hostel->hostel_status == 1 ? 'Enabled' : 'Disabled' }}
                                            </b>
                                        </td>

                                        <td>

                                            <button data-bs-toggle="modal" data-id="{{ $hostel->hid }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>


                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();
                                    var hid = $(this).data('id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: "{{ url('hostels') }}/" + hid,
                                        type: "GET",
                                        data: {
                                            hid: hid,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');
                                            if (response.done) {
                                                $('#ehid').val(response.data.hid);
                                                $('#ehostelname').val(response.data.hostelname);
                                                $('#ehostel_status').val(response.data.hostel_status);
                                                $('#editForm').attr('action', "{{ url('hostels') }}/" + hid);
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