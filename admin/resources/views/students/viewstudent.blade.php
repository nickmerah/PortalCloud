@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Edit Student</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Student</a>
                        </li>
                        <li class="breadcrumb-item active">Student Details</li>
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



                        <div class="row clearfix">
                            <input name="stdid" type="hidden" value="{{ $student->std_id }}" />
                            <div class="col-sm-6">
                                <label for="email_address1">Matriculation Number</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"
                                            class="form-control"

                                            disabled="disabled" value="{{ stripslashes($student->matric_no) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="email_address1">Surname</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"
                                            class="form-control"

                                            name="surname" disabled="disabled"
                                            value="{{ stripslashes($student->surname) }}">
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

                                            name="firstname" disabled="disabled"
                                            value="{{ stripslashes($student->firstname) }}">
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
                                                    disabled="disabled"
                                                    name="othernames"
                                                    value="{{ stripslashes($student->othernames) }}">
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

                                                    name="student_email" disabled="disabled"
                                                    value="{{ stripslashes($student->student_email) }}">

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

                                                name="student_mobiletel" disabled="disabled"
                                                value="{{ stripslashes($student->student_mobiletel) }}">
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
                                                    name="contact_address" disabled="disabled"
                                                    value="{{ stripslashes($student->contact_address) }}">
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

                                                    name="next_of_kin" disabled="disabled"
                                                    value="{{ stripslashes($student->next_of_kin) }}">

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

                                                name="nok_tel" disabled="disabled"
                                                value="{{ stripslashes($student->nok_tel) }}">
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

                                                    name="nok_address" disabled="disabled"
                                                    value="{{ stripslashes($student->nok_address) }}">
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
                                            <select class="form-control select2" data-placeholder="Select" name="marital_status" disabled="disabled">
                                                <option value="{{ $student->marital_status }}">{{ $student->marital_status }}</option>
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


                                            <select class="form-control select2" data-placeholder="Select" name="gender" disabled="disabled">
                                                <option>{{ stripslashes($student->gender) }}</option>
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

                                                name="birthdate" disabled="disabled"
                                                value="{{ stripslashes($student->birthdate) }}">
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
                                                <select name="stdcourse" class="form-control" disabled>
                                                    @foreach ($courseOfStudy as $cos)
                                                    <option value="{{ $cos->do_id }}" {{ $student->stdcourse == $cos->do_id ? 'selected' : '' }}>
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
                                    <div class="form-line">
                                        <label for="email_address1">Level</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="stdlevel" class="form-control" disabled>
                                                    @foreach ($levels as $level)
                                                    <option value="{{ $level->level_id }}" {{ $student->stdlevel == $level->level_id ? 'selected' : '' }}>
                                                        {{ $level->level_name }}
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

                                        <label for="email_address1">School</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" disabled>
                                                    @foreach ($schools as $school)
                                                    <option value="{{ $school->faculties_id }}" {{ $student->stdfaculty_id == $school->faculties_id ? 'selected' : '' }}>
                                                        {{ $school->faculties_name }}
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

                                        <label for="email_address1">Department</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" disabled>
                                                    @foreach ($depts as $dept)
                                                    <option value="{{ $dept->departments_id }}" {{ $student->stddepartment_id == $dept->departments_id ? 'selected' : '' }}>
                                                        {{ $dept->departments_name }}
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

                                        <label for="email_address1">Programme</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" disabled>
                                                    @foreach ($programmes as $programme)
                                                    <option value="{{ $programme->programme_id }}" {{ $student->stdprogramme_id == $programme->programme_id ? 'selected' : '' }}>
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
                                                <select class="form-control" disabled>
                                                    @foreach ($programmeTypes as $programmeType)
                                                    <option value="{{ $programmeType->programme_id }}" {{ $student->std_programmetype == $programmeType->programmet_id ? 'selected' : '' }}>
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
                                                <select id="state" name="state_of_origin" class="form-control" disabled>
                                                    <option value="">Select State</option>
                                                    @foreach ($statesOfOrigin as $state)
                                                    <option value="{{ $state->state_id }}" {{ $student->state_of_origin == $state->state_id ? 'selected' : '' }}>
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

                                                <select id="lga" name="local_gov" class="form-control" disabled>
                                                    <option value="{{ $student->local_gov }}">{{ $lgaName }}</option>
                                                </select>


                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="header">
                            <h2>
                                <strong>View</strong> Fee Payment
                            </h2>
                            <hr>

                            @if(count($feepayments) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fee Name</th>
                                            <th>RRR</th>
                                            <th>Amount</th>
                                            <th>Session</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($feepayments as $feepayment)
                                        <tr class="odd">
                                            <td class="center">{{$loop->iteration}}</td>
                                            <td>{{ $feepayment->trans_name }}</td>
                                            <td>{{ $feepayment?->rrr }}</td>
                                            <td>{{ number_format($feepayment?->trans_amount) }}</td>
                                            <td>{{ $feepayment?->trans_year }}</td>
                                            <td>{{ \Carbon\Carbon::parse($feepayment?->trans_date)->format('jS F, Y')  }}</td>
                                            </td>
                                        </tr>@endforeach

                                    </tbody>
                                </table>
                            </div>@else
                            No Payment Found
                            @endif

                        </div>


                        <div class="header">
                            <h2>
                                <strong>View</strong> Clearance Payment
                            </h2>
                            <hr>

                            @if(count($clearancepayments) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fee Name</th>
                                            <th>RRR</th>
                                            <th>Amount</th>
                                            <th>Session</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clearancepayments as $clearancepayment)
                                        <tr class="odd">
                                            <td class="center">{{$loop->iteration}}</td>
                                            <td>{{ $clearancepayment->fee_name }}</td>
                                            <td>{{ $clearancepayment?->rrr }}</td>
                                            <td>{{ number_format($clearancepayment?->fee_amount) }}</td>
                                            <td>{{ $clearancepayment?->trans_year }}</td>
                                            <td>{{ \Carbon\Carbon::parse($clearancepayment?->trans_date)->format('jS F, Y')  }}</td>
                                            </td>
                                        </tr>@endforeach

                                    </tbody>
                                </table>
                            </div>@else
                            No Payment Found
                            @endif

                        </div>

                        <div class="header">
                            <h2>
                                <strong>View</strong> Remedial Payment
                            </h2>
                            <hr>

                            @if(count($remedialpayments) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fee Name</th>
                                            <th>RRR</th>
                                            <th>Amount</th>
                                            <th>Session</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($remedialpayments as $remedialpayment)
                                        <tr class="odd">
                                            <td class="center">{{$loop->iteration}}</td>
                                            <td>{{ $remedialpayment->fee_name }}</td>
                                            <td>{{ $remedialpayment?->rrr }}</td>
                                            <td>{{ number_format($remedialpayment?->fee_amount) }}</td>
                                            <td>{{ $remedialpayment?->trans_year }}</td>
                                            <td>{{ \Carbon\Carbon::parse($remedialpayment?->trans_date)->format('jS F, Y')  }}</td>
                                            </td>
                                        </tr>@endforeach

                                    </tbody>
                                </table>
                            </div>@else
                            No Payment Found
                            @endif

                        </div>

                        <div class="header">
                            <h2>
                                <strong>View</strong> Course Registration
                            </h2>
                            <hr>

                            No Courses Registered

                        </div>
                        <div class="col-lg-12 p-t-20 text-center">

                            <a href="{{url('/students') }}" class="btn btn-danger waves-effect">Go Back</a>

                        </div>



                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
@endsection