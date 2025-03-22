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
                            <h4 class="page-title">Reports</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Application Registration</a>
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



                            &nbsp; &nbsp; <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#searchModal">Search Registration<i class="material-icons">search</i> </button>

                            &nbsp; &nbsp; <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#downloadModal">Download Passport<i class="material-icons">file_download</i> </button>

                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog"
                                aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Search Registration</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" action="" autocomplete="off">
                                                @csrf

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="prog_id" class="form-control">
                                                            <option value="">All</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="progtype_id" class="form-control">
                                                            <option value="">All</option>
                                                            @foreach($programmeTypes as $programmeType)
                                                            <option value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <label for="email_address1">Application No</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text"
                                                            class="form-control"
                                                            name="appno">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Surname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text"
                                                            class="form-control"
                                                            name="surname">
                                                    </div>
                                                </div>
                                                <label for="email_address1">Registration Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="appstatus" class="form-control">
                                                            <option value="">All</option>
                                                            <option value="1">Submitted</option>
                                                            <option value="0">Not Submitted</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Admission Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="admstatus" class="form-control">
                                                            <option value="">All</option>
                                                            <option value="1">Admitted</option>
                                                            <option value="0">Not Admitted</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Clearance Status</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="eclearance" class="form-control">
                                                            <option value="">All</option>
                                                            <option value="1">Cleared</option>
                                                            <option value="0">Not Cleared</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <br>
                                                <button type="submit"
                                                    class="btn btn-info waves-effect">Search Application</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- downloadModal -->

                            <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog"
                                aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Download Passports</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="downloadForm" class="form-signin" method="post" action="{{ route('download-passports') }}" autocomplete="off">
                                                @csrf

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="prog_id" class="form-control" required>
                                                            <option value="">All</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="progtype_id" class="form-control" required>
                                                            <option value="">All</option>
                                                            @foreach($programmeTypes as $programmeType)
                                                            <option value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <br>
                                                <button type="submit" id="downloadBtn" class="btn btn-info waves-effect">Download Passport</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>

                                        <!-- Initially hide the success message -->
                                        <div id="successMessage" class="alert alert-success" style="display: none;">
                                            Passports are being downloaded... Please wait, you will be redirected when it is finished.
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        </p>

                    </div>
                    <!-- Check for the success flash message and display it -->
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="body">
                        <h5 align="center">Showing Applicant Registraion for {{ $currentSession->cs_session }}/{{ $currentSession->cs_session + 1 }} Session</h5>
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example contact_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Applicant No</th>
                                        <th>Fullnames</th>
                                        <th>Programme</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>AdmStatus</th>
                                        <th>ClearanceStatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicants as $applicant)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $applicant->app_no }}</td>
                                        <td>{{ stripslashes($applicant->surname) }} {{ stripslashes($applicant->firstname) }} {{ stripslashes($applicant->othername) }}</td>
                                        <td>{{ $applicant->programme->programme_name ?? 'N/A' }}</td>
                                        <td>{{ $applicant->gender }}</td>
                                        <td>
                                            <b style="color: {{ $applicant->std_custome9 == 1 ? 'green' : 'red' }}">
                                                {{ $applicant->std_custome9 == 1 ? 'Submitted' : 'Not Submitted' }}
                                            </b>
                                        </td>
                                        <td> <b style="color: {{ $applicant->adm_status == 1 ? 'green' : 'red' }}">
                                                {{ $applicant->adm_status == 1 ? 'Admitted' : 'Not Admitted' }}
                                            </b></td>

                                        </td>
                                        <td> <b style="color: {{ $applicant->eclearance == 1 ? 'green' : 'red' }}">
                                                {{ $applicant->eclearance == 1 ? 'Cleared' : 'Not Cleared' }}
                                            </b></td>

                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <a href="{{ route('expappregistration', array_merge(request()->query(), ['export' => 'excel'])) }}" class="btn btn-primary">Export Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection