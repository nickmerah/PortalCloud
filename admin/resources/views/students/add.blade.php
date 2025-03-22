@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Add Student</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Student</a>
                        </li>
                        <li class="breadcrumb-item active">Add Student Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>View</strong> Student Details
                        </h2>

                    </div>
                    <div class="body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form class="form-signin" method="post" action="{{ route('addstudent') }}" autocomplete="off">
                            @csrf

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label for="email_address1">Matriculation Number</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control" name="matno">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="email_address1">Student Number</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control" name="stdno">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label for="email_address1">Surname</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control"
                                                name="surname" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="email_address1">Firstname</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control"

                                                name="firstname" required="required">
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Othernames</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"

                                                        name="othername">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Email</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="email"
                                                        class="form-control"

                                                        name="student_email" required="required">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address1">GSM</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number"
                                                    class="form-control"

                                                    name="student_mobiletel" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Contact Adress</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"
                                                        name="contact_address" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Next of Kin Name</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"

                                                        name="next_of_kin" required="required">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address1">Next of Kin Phone</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number"
                                                    class="form-control"

                                                    name="nok_tel" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Next of Kin Address</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"

                                                        name="nok_address" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address1">Gender</label>
                                        <div class="form-group">
                                            <div class="form-line">


                                                <select class="form-control select2" data-placeholder="Select" name="gender" required="required">
                                                    <option value="">Select</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address1">Date of Birth</label>
                                        <div class="form-group">
                                            <div class="form-line">

                                                <input type="date"
                                                    class="form-control"

                                                    name="birthdate" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">

                                            <label for="email_address1">Programme</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select class="form-control" name="prog" id="prog">
                                                        <option value="">Select</option>
                                                        @foreach ($programmes as $programme)
                                                        <option value="{{ $programme->programme_id }}">
                                                            {{ $programme->programme_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">

                                            <label for="email_address1">Programme Type</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select class="form-control" name="progtype" id="progtype">
                                                        <option value="">Select</option>
                                                        @foreach ($programmeTypes as $programmeType)
                                                        <option value="{{ $programmeType->programmet_id }}">
                                                            {{ $programmeType->programmet_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Course of Study</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="stdcourse" class="form-control" id="stdcourse">
                                                        <option value="">Select</option>

                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Level</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="stdlevel" id="stdlevel" class="form-control">
                                                        <option value="">Select</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">State of Origin</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select id="state" name="state_of_origin" class="form-control" required>
                                                        <option value="">Select State</option>
                                                        @foreach ($statesOfOrigin as $state)
                                                        <option value="{{ $state->state_id }}">
                                                            {{ $state->state_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">

                                            <label for="email_address1">LGA</label>
                                            <div class="form-group">
                                                <div class="form-line">

                                                    <select id="lga" name="local_gov" class="form-control" required>
                                                        <option value="">Select</option>
                                                    </select>


                                                </div>
                                            </div>
                                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#state').on('change', function() {
                                                        var stateId = $(this).val();

                                                        $('#lga').html('<option value="">Select LGA</option>');

                                                        if (stateId) {
                                                            $.ajax({
                                                                url: "{{ url('/get-lgas') }}/" + stateId,
                                                                type: "GET",
                                                                dataType: "json",
                                                                success: function(data) {
                                                                    $.each(data, function(key, value) {
                                                                        $('#lga').append('<option value="' + key + '">' + value + '</option>');
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                });
                                            </script>


                                            <script>
                                                $(document).ready(function() {
                                                    $('#prog').on('change', function() {
                                                        var progId = $(this).val();
                                                        $('#stdcourse').empty().append('<option value="">Select Course of Study</option>');
                                                        if (progId) {
                                                            $.ajax({
                                                                url: "{{ url('/get-cos') }}/" + progId,
                                                                type: "GET",
                                                                cache: false,
                                                                dataType: "json",
                                                                success: function(data) {

                                                                    var sortedData = Object.entries(data).sort(function(a, b) {
                                                                        return a[1].localeCompare(b[1]);
                                                                    });


                                                                    $.each(sortedData, function(key, value) {
                                                                        $('#stdcourse').append('<option value="' + value[0] + '">' + value[1] + '</option>');
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                });
                                            </script>


                                            <script>
                                                $(document).ready(function() {
                                                    $('#prog').on('change', function() {
                                                        var progId = $(this).val();
                                                        $('#stdlevel').empty().append('<option value="">Select Level</option>');
                                                        if (progId) {
                                                            $.ajax({
                                                                url: "{{ url('/get-level') }}/" + progId,
                                                                type: "GET",
                                                                cache: false,
                                                                dataType: "json",
                                                                success: function(data) {

                                                                    var sortedData = Object.entries(data).sort(function(a, b) {
                                                                        return a[1].localeCompare(b[1]);
                                                                    });


                                                                    $.each(sortedData, function(key, value) {
                                                                        $('#stdlevel').append('<option value="' + value[0] + '">' + value[1] + '</option>');
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                });
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="btn btn-primary waves-effect m-r-15">Add Student Details</button>
                                <a href="{{url('/students') }}" class="btn btn-danger waves-effect">Go Back</a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
@endsection