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

                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="email_address1">Course of Study</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text"
                                                    class="form-control"
                                                    name="contact_address" disabled="disabled"
                                                    value="{{ stripslashes($student->stdcourseOption->programme_option) }}">
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
                                                <input type="text"
                                                    class="form-control"
                                                    name="contact_address" disabled="disabled"
                                                    value="{{ stripslashes($student->programme->programme_aname) }} {{ stripslashes($student->level->level_name) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>





                    </div>




                    <div class="header">
                        <h2>
                            <strong>View</strong> Course Registration - {{ $currentSession['cs_session']}} / {{ $currentSession['cs_session'] + 1}}
                        </h2>
                        <hr>

                        @if(count($firstSemesterCourses) > 0)
                        <h5>First Semester</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Title</th>
                                        <th>Unit</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($firstSemesterCourses as $fcreg)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $fcreg?->c_code }}</td>
                                        <td>{{ $fcreg?->c_title }}</td>
                                        <td>{{ $fcreg?->c_unit }}</td>
                                        <td>{{ $fcreg?->csemester }}</td>
                                        <td>{{ $fcreg?->status }}</td>
                                        <td>{{ \Carbon\Carbon::parse($fcreg?->cdate_reg)->format('jS F, Y')  }}</td>
                                        </td>
                                    </tr>@endforeach
                                    <tr class="even">
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td>Total Unit</td>
                                        <td>{{ $firstSemesterCourses->sum('c_unit') }}</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <form class="form-signin" method="post" action="{{ route('approvecourseregistration') }}" autocomplete="off" onsubmit="return confirm('Are you sure you want to approve this course registration?')">
                                @csrf
                                @if($fcreg->status == 'Approved')
                                <button type="button" class="btn btn-success waves-effect m-r-15">Courses Already Approved</button>
                                @else
                                <button type="submit" class="btn btn-success waves-effect m-r-15">Approve Courses</button>
                                @endif

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Reject Course Registration</button>
                                <input name="stdid" type="hidden" value="{{ $student->std_id }}" />
                                <input name="semester" type="hidden" value="First Semester" />

                                @if($fcreg->status == "Rejected")
                                <br>
                                <br>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Course Registration Rejected:</strong> {{$fcreg->remark}}
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
                                            <form class="form-signin" method="post" action="{{ route('rejectcourseregistration') }}" autocomplete="off">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Reject Message" name="reject" required="required">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-info waves-effect">Reject</button>
                                                <input name="stdid" type="hidden" value="{{ $student->std_id }}" />
                                                <input name="semester" type="hidden" value="First Semester" />
                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>@else
                        No Course Registered for this Semester
                        @endif
                        <br>
                        <hr>

                        @if(count($secondSemesterCourses) > 0)
                        <h5>Second Semester</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Title</th>
                                        <th>Unit</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($secondSemesterCourses as $screg)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $screg?->c_code }}</td>
                                        <td>{{ $screg?->c_title }}</td>
                                        <td>{{ $screg?->c_unit }}</td>
                                        <td>{{ $screg?->csemester }}</td>
                                        <td>{{ $screg?->status }}</td>
                                        <td>{{ \Carbon\Carbon::parse($screg?->cdate_reg)->format('jS F, Y')  }}</td>
                                        </td>
                                    </tr>@endforeach
                                    <tr class="even">
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td>Total Unit</td>
                                        <td>{{ $secondSemesterCourses->sum('c_unit') }}</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <form class="form-signin" method="post" action="{{ route('approvecourseregistration') }}" autocomplete="off" onsubmit="return confirm('Are you sure you want to approve this course registration?')">
                                @csrf
                                @if($screg->status == 'Approved')
                                <button type="button" class="btn btn-success waves-effect m-r-15">Courses Already Approved</button>
                                @else
                                <button type="submit" class="btn btn-success waves-effect m-r-15">Approve Courses</button>
                                @endif

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModals">Reject Course Registration</button>
                                <input name="stdid" type="hidden" value="{{ $student->std_id }}" />
                                <input name="semester" type="hidden" value="Second Semester" />

                                @if($screg->status == "Rejected")
                                <br>
                                <br>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Course Registration Rejected:</strong> {{$screg->remark}}
                                </div>
                                @endif
                            </form>

                            <br>

                            <div class="modal fade" id="exampleModals" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Enter Rejection Message</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" action="{{ route('rejectcourseregistration') }}" autocomplete="off">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Enter Reject Message" name="reject" required="required">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-info waves-effect">Reject</button>
                                                <input name="stdid" type="hidden" value="{{ $student->std_id }}" />
                                                <input name="semester" type="hidden" value="Second Semester" />
                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>@else
                        No Course Registered for this Semester
                        @endif

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