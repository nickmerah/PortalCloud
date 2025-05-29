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
                            <h4 class="page-title">Applicant Fees</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Fee Amount</a>
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
                                            <h5 class="modal-title" id="formModal">Edit Field</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" autocomplete="off">
                                                @csrf

                                                <label for="email_address1">Amount</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class="form-control" id="eamount" name="amount" required="required">
                                                    </div>
                                                </div>
                                                <input type="hidden" class="form-control" id="efee_id" name="fee_id" required="required">
                                                <input type="hidden" class="form-control" id="eitem_id" name="item_id" required="required">
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
                                        <th>Fee Name</th>
                                        <th>Programme</th>
                                        <th>ProgrammeType</th>
                                        <th>Amount</th>
                                        <th>Std Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($fees as $fee)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $fee->fees->field_name }} </td>
                                        <td>{{ $fee?->programme?->programme_name }} </td>
                                        <td>{{ $fee?->programmeType?->programmet_name }} </td>
                                        <td>{{ $fee->amount }} </td>
                                        <td>{{ $fee->stdstatus == 1 ? 'Deltans' : 'General'}} </td>
                                        <td> <button data-bs-toggle="modal" data-id="{{ $fee->fee_id }}" data-item_id="{{ $fee->item_id }}" id="fieldEdit" class="btn btn-success edit">
                                                <i class="material-icons">create</i>
                                            </button></td>

                                    </tr>@endforeach
                                </tbody>

                            </table>
                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();

                                    var id = $(this).data('id');
                                    var item_id = $(this).data('item_id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: "{{ url('appfeeamt') }}/" + id,
                                        type: "GET",
                                        data: {
                                            id: id,
                                            item_id: item_id,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');
                                            if (response.done) {
                                                $('#eamount').val(response.data.amount);
                                                $('#efee_id').val(response.data.fee_id);
                                                $('#eid').val(response.data.id);
                                                $('#eitem_id').val(response.data.item_id);
                                                $('#editForm').attr('action', "{{ url('updateappfeeamt') }}");
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