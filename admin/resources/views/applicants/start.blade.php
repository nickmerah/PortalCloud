@extends('apphead')

@section('contents')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">All Applicants</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Applicants</a>
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

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">Search Record<i class="material-icons">search</i> </button>

                            @php
                            $userData = session('user_data');
                            if ($userData) {
                            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
                            }
                            @endphp
                            @if ($decryptedUserData['uGroup'] == 1)
                            &nbsp;
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#admissionModal">Upload Admission List<i class="material-icons">file_upload</i> </button>
                            &nbsp;
                            <a href="{{ url('view-admission-list') }}" class="btn btn-success waves-effect">View Admission List<i class="material-icons">visibility</i> </a>
                            @endif
                            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Search Applicants</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="GET" action="{{ route('applicants.index') }}">
                                                <label for="email_address1">Applicant No</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" name="matric_no" value="{{ request('matric_no') }}">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Surname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" name="surname" value="{{ request('surname') }}">
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Search Applicant</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Enable Passport Upload</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" enctype="multipart/form-data" action="{{ route('uploadapplicantphoto') }}">
                                                @csrf

                                                <div class="form-group">

                                                    <div class="alert alert-warning">

                                                        <p>This will enable the applicant to re-upload their passport</p>

                                                    </div>

                                                    <input name="sid" type="hidden" id="sid">


                                                </div>



                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Enable Passport</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="admissionModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Upload Admission List</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" enctype="multipart/form-data" action="{{ route('uploadadmissionlist') }}">
                                                @csrf

                                                <label for="csv_file">Select Admission list file in .csv file</label>

                                                <div class="form-group">

                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="file" name="csv_file" accept=".csv" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Upload List</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ url('/download-admission-csv') }}" class="btn btn-success waves-effect">Download Template</a>
                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>

                        </div>
                        @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

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

                                <table class="table table-hover js-basic-example contact_list" style="font-size:11px">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th class="center"> Application No </th>
                                            <th class="center"> Fullnames </th>
                                            <th class="center">Programme</th>
                                            <th class="center">Dept</th>
                                            <th class="center"> Status </th>
                                            <th class="center"> App Status </th>
                                            <th class="center"> Clearance Status </th>
                                            <th class="center"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applicants as $applicant)
                                        <tr class="odd gradeX">
                                            <td class="table-img center">
                                                <a data-bs-toggle="modal" data-bs-target="#pictureModal" id="submit{{$applicant->std_id}}"> <img src="{{ 'https://portal.mydspg.edu.ng/admissions/writable/thumbs/' . $applicant->std_photo }}" width="100" height="80">
                                                </a>


                                            </td>
                                            <td class="center">{{ $applicant->app_no }}</td>
                                            <td class="center">{{ stripslashes($applicant->surname) }} {{ stripslashes($applicant->firstname) }} {{ stripslashes($applicant->othername) }}</td>
                                            <td class="center">{{ $applicant->programme->programme_name ?? 'N/A' }}

                                                <input id="smode{{$applicant->std_id}}" type="hidden" value="{{ $applicant->std_id }}" />

                                            </td>
                                            <td class="center">{{ $applicant->stdcourseOption->programme_option ?? 'N/A' }} </td>
                                            <td class="center"><b style="color: {{ $applicant->std_custome9 == 1 ? 'green' : 'red' }}">
                                                    {{ $applicant->std_custome9 == 1 ? 'Submitted' : 'Not Submitted' }}
                                                </b> </td>
                                            <td class="center">

                                                <b style="color: {{ $applicant->adm_status == 1 ? 'green' : 'red' }}">
                                                    {{ $applicant->adm_status == 1 ? 'Admitted' : 'Not Admitted' }}
                                                </b>

                                            </td>

                                            <td class="center">

                                                <b style="color: {{ $applicant->eclearance == 1 ? 'green' : 'red' }}">
                                                    {{ $applicant->eclearance == 1 ? 'Cleared' : 'Not Cleared' }}
                                                </b>

                                            </td>
                                            <td class="center">
                                                <a href="{{URL::to('/applicants/'.$applicant->std_id) }}" class="btn btn-tbl-edit">
                                                    <i class="material-icons">create</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <script type="text/javascript">
                                            $("#submit{{$applicant->std_id}}").click(function() {
                                                var text = $("#smode{{$applicant->std_id}}").val();
                                                console.log(text);
                                                $("#modal_body").html(text);
                                                document.getElementById("sid").value = text;
                                            });
                                        </script>

                                        @endforeach


                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>

                            </div>
                            <div>
                                {{ $applicants->appends(request()->query())->links('vendor.pagination.minimal') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection