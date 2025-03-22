@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Edit Applicant</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Applicant</a>
                        </li>
                        <li class="breadcrumb-item active">Applicant Details</li>
                    </ul>
                </div>
            </div>
        </div>

        @php
        $userData = session('user_data');
        $canAccessBiodata = false;
        $isSuperAdmin = false;

        if ($userData) {
        $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
        $policy = new \App\Policies\MenuPolicy();
        $canAccessBiodata = $policy->accessBiodata($decryptedUserData);
        $isSuperAdmin = $decryptedUserData['uGroup'] == 1 ? true : false;
        }
        @endphp
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>View</strong> Applicant Details
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
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form class="form-signin" method="post" action="{{ route('updateapplicant') }}" autocomplete="off">
                            @csrf

                            <div class="row clearfix">
                                <input name="appid" type="hidden" value="{{ $applicant->std_id }}" />
                                <div class="col-sm-6">
                                    <label for="email_address1">Application Number</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control"

                                                disabled="disabled" value="{{ stripslashes($applicant->app_no) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="email_address1">Surname</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control"

                                                name="surname" required="required"
                                                value="{{ stripslashes($applicant->surname) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label for="email_address1">Firstname</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text"
                                                class="form-control"

                                                name="firstname" required="required"
                                                value="{{ stripslashes($applicant->firstname) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Othernames</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"

                                                        name="othernames"
                                                        value="{{ stripslashes($applicant->othernames) }}">
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
                                            <label for="email_address1">Email</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="email"
                                                        class="form-control"

                                                        name="student_email" required="required"
                                                        value="{{ stripslashes($applicant->student_email) }}">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address1">GSM</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number"
                                                    class="form-control"

                                                    name="student_mobiletel" required="required"
                                                    value="{{ stripslashes($applicant->student_mobiletel) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Contact Adress</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"
                                                        name="contact_address" required="required"
                                                        value="{{ stripslashes($applicant->contact_address) }}">
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

                                                        name="next_of_kin" required="required"
                                                        value="{{ stripslashes($applicant->next_of_kin) }}">

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

                                                    name="nok_tel" required="required"
                                                    value="{{ stripslashes($applicant->nok_tel) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Next of Kin Address</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text"
                                                        class="form-control"

                                                        name="nok_address" required="required"
                                                        value="{{ stripslashes($applicant->nok_address) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address1">Marital Status</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control select2" data-placeholder="Select" name="marital_status" required="required">
                                                    <option value="{{ $applicant->marital_status }}">{{ $applicant->marital_status }}</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>

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
                                                    <option>{{ stripslashes($applicant->gender) }}</option>
                                                    <option>Male</option>
                                                    <option>Female</option>

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

                                                    name="birthdate" required="required"
                                                    value="{{ stripslashes($applicant->birthdate) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">First Choice</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="stdcourse" class="form-control">
                                                        @foreach ($courseOfStudy as $cos)
                                                        <option value="{{ $cos->do_id }}" {{ $applicant->stdcourse == $cos->do_id ? 'selected' : '' }}>
                                                            {{ $cos->programme_option }}
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
                                        <label for="email_address1">Second Choice</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="std_course" class="form-control">
                                                    @foreach ($courseOfStudy as $cos)
                                                    <option value="{{ $cos->do_id }}" {{ $applicant->std_course == $cos->do_id ? 'selected' : '' }}>
                                                        {{ $cos->programme_option }}
                                                    </option>
                                                    @endforeach
                                                </select>

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
                                                    <select class="form-control" disabled>
                                                        @foreach ($programmes as $programme)
                                                        <option value="{{ $programme->programme_id }}" {{ $applicant->stdprogramme_id == $programme->programme_id ? 'selected' : '' }}>
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
                                                    <select class="form-control" name="std_programmetype" required>
                                                        @foreach ($programmeTypes as $programmeType)
                                                        <option value="{{ $programmeType->programmet_id  }}" {{ $applicant->std_programmetype == $programmeType->programmet_id  ? 'selected' : '' }}>
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
                                            <label for="email_address1">State of Origin</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select id="state" name="state_of_origin" class="form-control" required>
                                                        <option value="">Select State</option>
                                                        @foreach ($statesOfOrigin as $state)
                                                        <option value="{{ $state->state_id }}" {{ $applicant->state_of_origin == $state->state_id ? 'selected' : '' }}>
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
                                                        <option value="{{ $applicant->local_gov }}">{{ $lgaName }}</option>
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($isSuperAdmin)
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email_address1">Admission Status</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select class="form-control select2" data-placeholder="Select" name="adm_status" required="required">
                                                        <option value="1" {{ $applicant->adm_status == 1 ? 'selected' : '' }}>Admitted</option>
                                                        <option value="0" {{ $applicant->adm_status == 0 ? 'selected' : '' }}>Not Admitted</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($canAccessBiodata)

                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="btn btn-primary waves-effect m-r-15">Update Applicant Details</button>
                                <a href="{{url('/applicants') }}" class="btn btn-danger waves-effect">Go Back</a>

                            </div>
                            @endif
                        </form>


                    </div>
                    <div class="header">
                        <h2>
                            View Olevel Details
                        </h2>
                        <div class="body">
                            <div class="table-responsive">

                                <table class="table table-hover table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th class="">#</th>

                                            <th class=""> Exam Type </th>
                                            <th class=""> Subject Name </th>
                                            <th class=""> Grade </th>
                                            <th class=""> Date Obtained </th>
                                            <th class=""> CenterNo </th>
                                            <th class=""> ExamNo</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($olevels as $olevel )

                                        <tr class="odd gradeX">
                                            <td class="table-img "> {{$loop->iteration}}</td>
                                            <td class=""> {{ $olevel->certname }}</td>
                                            <td class=""> {{ $olevel->subname }}</td>
                                            <td class=""> {{ $olevel->grade }}</td>
                                            <td class=""> {{ $olevel->emonth }} {{ $olevel->eyear }}</td>
                                            <td class=""> {{ $olevel->centerno }}</td>
                                            <td class=""> {{ $olevel->examno }}</td>

                                        </tr> @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                    @if(!empty($jambdetails) && $jambdetails->isNotEmpty())

                    <div class="header">
                        <h2>
                            View Jamb Details - UTME NO: {{ $jambdetails[0]->jambno}}
                        </h2>

                        <div class="body">
                            <div class="table-responsive">

                                <table class="table table-hover table-bordered " style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th class="">#</th>

                                            <th class=""> Subject </th>
                                            <th class=""> Score </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jambdetails as $jamb )

                                        <tr class="odd gradeX">
                                            <td class="table-img "> {{$loop->iteration}}</td>
                                            <td class=""> {{ $jamb->subjectname }}</td>
                                            <td class=""> {{ $jamb->jscore }}</td>

                                        </tr> @endforeach

                                        <tr>

                                            <td class="" colspan="2">
                                                <div align="right"><strong>TOTAL SCORE</strong></div>
                                            </td>
                                            <td class="">{{$jambdetails->sum('jscore')}}</td>

                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                    @endif
                    @if(!empty($schools) && $schools->isNotEmpty())
                    <div class="header">
                        <h2>
                            View School Details
                        </h2>

                        <div class="body">
                            <div class="table-responsive">

                                <table class="table table-hover table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th class="">#</th>

                                            <th class=""> School Name </th>
                                            <th class=""> ND Matric No </th>
                                            <th class=""> Course of Study </th>
                                            <th class=""> Grade</th>
                                            <th class=""> From </th>
                                            <th class="">To </th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schools as $school )

                                        <tr class="odd gradeX">
                                            <td class="table-img "> {{$loop->iteration}}</td>
                                            <td class=""> {{ $school->pname }}</td>
                                            <td class=""> {{ $school->ndmatno }}</td>
                                            <td class=""> {{ $school->programme_option }}</td>
                                            <td class=""> {{ $school->grade }}</td>
                                            <td class=""> {{ $school->fromdate }}</td>
                                            <td class=""> {{ $school->todate }}</td>
                                        </tr> @endforeach


                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>@endif

                    @if(!empty($certificates) && $certificates->isNotEmpty())
                    <div class="header">
                        <h2>
                            View Certificates
                        </h2>

                        <div class="body">
                            <div class="table-responsive">

                                <table class="table table-hover table-bordered" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th class="">#</th>

                                            <th class=""> Certificate Name </th>
                                            <th class=""> File </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($certificates as $certificate )

                                        <tr class="odd gradeX">
                                            <td class="table-img "> {{$loop->iteration}}</td>
                                            <td class=""> {{ $certificate->docname }}</td>
                                            <td class="">

                                                <iframe src="https://portal.mydspg.edu.ng/admissions/writable/uploads/{{ $certificate->uploadname }}" width="100%" height="600px"></iframe>

                                            </td>
                                        </tr> @endforeach


                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>@else
                    <div class="body">
                        <div class="table-responsive">

                            <table class="table table-hover table-bordered" style="font-size:12px">
                                <thead>
                                    <tr>
                                        <th class=""> Certificate Name </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td class=""> No Certificate Uploaded</td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="body">
                        <div class="table-responsive">

                            <table class="table table-hover table-bordered" style="font-size:12px">
                                <thead>
                                    <tr>
                                        <th colspan="3">Payment Details - PAID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        @php
                                        $acceptanceFee = $transactions->firstWhere('fee_id', 2);
                                        $resultVerificationFee = $transactions->firstWhere('fee_id', 4);
                                        $changeOfCourseFee = $transactions->firstWhere('fee_id', 6);
                                        @endphp


                                        @if($acceptanceFee)
                                        <td class="">
                                            {{ "Acceptance Fee: " . '₦' . number_format($acceptanceFee->fee_amount, 2) }}
                                        </td>
                                        @endif


                                        @if($resultVerificationFee)
                                        <td class="">
                                            {{ "Olevel Result Verification: " . '₦' . number_format($resultVerificationFee->fee_amount, 2) }}
                                        </td>
                                        @endif


                                        @if($changeOfCourseFee)
                                        <td class="">
                                            {{ "Change of Course Fee: " . '₦' . number_format($changeOfCourseFee->fee_amount, 2) }}
                                        </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>

                    <div class="col-lg-12 p-t-20 text-center">
                        @if($applicant->adm_status == 1)
                        <form class="form-signin" method="post" action="{{ route('clearapplicant') }}" autocomplete="off" onsubmit="return confirm('Are you sure you want to clear this applicant?')">
                            @csrf
                            @if($applicant->eclearance == 1)
                            <button type="button" class="btn btn-success waves-effect m-r-15">Applicant Already Cleared</button>
                            @else
                            <button type="submit" class="btn btn-success waves-effect m-r-15">Clear Applicant</button>
                            @endif

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Reject Applicant</button>
                            <input name="appid" type="hidden" value="{{ $applicant->std_id }}" />

                            @if($applicant->eclearance == -1)
                            <br>
                            <br>
                            <div class="alert alert-danger" role="alert">
                                <strong>Application Rejected:</strong> {{$applicant->reject}}
                            </div>
                            @endif
                        </form>
                        <br>

                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="formModal">Enter Rejection Message</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-signin" method="post" action="{{ route('rejectapplicant') }}" autocomplete="off">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" placeholder="Enter Reject Message" name="reject" required="required">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info waves-effect">Reject</button>
                                            <input name="appid" type="hidden" value="{{ $applicant->std_id }}" />
                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>@endif
                        <a href="{{url('/applicants') }}" class="btn btn-warning waves-effect">Go Back</a>



                    </div> <br>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection