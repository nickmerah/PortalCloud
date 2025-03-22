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
                            <h4 class="page-title">Hostel Rooms</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="{{ route('hostels.index') }}"> Rooms in {{ $hostel->hostelname }}</a>
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
                                            <h5 class="modal-title" id="formModal">Edit Room</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="{{ route('rooms') }}" autocomplete="off">
                                                @csrf
                                                <label for="email_address1">Room No</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="eroomno" name="roomno" disabled="disabled">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Room Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="eroom_type" name="room_type" disabled="disabled">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Room Capacity</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="ecapacity" name="capacity">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Room Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="room_status" id="eroom_status" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="form-control" id="eroomid" name="roomid">
                                                <input type="hidden" class="form-control" id="ehostelid" name="hostelid">
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
                                        <th>Room No</th>
                                        <th>Room Type</th>
                                        <th>Capacity</th>
                                        <th>Allocated Students</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hostel->rooms as $room)
                                    <tr class="odd">
                                        <td class="center">
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $room->roomno }}</td>
                                        <td>{{ $room->room_type }}</td>
                                        <td>{{ $room->capacity }}</td>
                                        <td>{{ $room->allocations()->count() }}</td>
                                        <td>
                                            <b style="color: {{ $room->room_status == 1 ? 'green' : 'red' }}">
                                                {{ $room->room_status == 1 ? 'Enabled' : 'Disabled' }}
                                            </b>
                                        </td>
                                        <td>

                                            <button data-bs-toggle="modal" data-id="{{ $room->roomid }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button>


                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <a href="{{ route('hostels.index') }}">
                                << Back to Hostel: {{ $hostel->hostelname }}
                                    </a>

                                    <script type="text/javascript">
                                        $(document).on('click', '#fieldEdit', function(e) {
                                            e.preventDefault();
                                            var roomid = $(this).data('id');
                                            let _token = $('meta[name="csrf-token"]').attr('content');

                                            $.ajax({
                                                url: "{{ url('rooms') }}/" + roomid,
                                                type: "GET",
                                                data: {
                                                    roomid: roomid,
                                                    _token: _token
                                                },
                                                success: function(response) {
                                                    $('#editModal').modal('show');
                                                    if (response.done) {
                                                        $('#eroomid').val(response.data.roomid);
                                                        $('#eroomno').val(response.data.roomno);
                                                        $('#ehostelid').val(response.data.hostelid);
                                                        $('#eroom_type').val(response.data.room_type);
                                                        $('#ecapacity').val(response.data.capacity);
                                                        $('#eroom_status').val(response.data.room_status);
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