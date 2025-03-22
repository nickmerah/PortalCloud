@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Dashboard</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/dashboard') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>


        @php
        $userData = session('user_data');
        $canSeeDashboard = false;

        if ($userData) {
        $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
        $policy = new \App\Policies\MenuPolicy();
        $canSeeDashboard = $policy->accessDashboard($decryptedUserData);
        }
        @endphp

        @if($canSeeDashboard)
        <h5 class="page-title">VERIFIED STUDENTS - {{$stdyear}}/{{$stdyear + 1}} SESSION</strong></h5>
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-orange">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-user"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Total Students </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    {{number_format($students_verified)}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card l-bg-purple">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Today's Payment</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    @php
                                    $allfeespaidtoday = $feestodaypaid->sum('trans_amount')
                                    + $clearancetodaypaid->sum('fee_amount') + $remedialtodaypaid->sum('fee_amount');

                                    @endphp


                                    &#x20A6;{{number_format($allfeespaidtoday)}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-green">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Total Fees Payment</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    @php
                                    $allfeespaid = $schoolfeespaid->sum('trans_amount') + $otherfeespaid->sum('trans_amount')
                                    + $clearancepaid->sum('fee_amount') + $remedialpaid->sum('fee_amount');

                                    @endphp
                                    &#x20A6;{{number_format($allfeespaid)}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <h5 class="page-title">FEES BREAKDOWN</strong></h5>
        <div class="row">
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-green-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-user"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">School Fees </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#x20A6;{{number_format($schoolfeespaid->sum('trans_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card l-bg-orange-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Other Fees</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#x20A6;{{number_format($otherfeespaid->sum('trans_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-green-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-tasks"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0"> Clearance Fees </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#8358;{{number_format($clearancepaid->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Remedial Payment</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#x20A6;{{number_format($remedialpaid->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <h5 class="page-title">APPLICANTS - {{$appyear}}/{{$appyear + 1}} SESSION</strong></h5>
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-green">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Total Applicants</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    {{number_format($app_count)}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card l-bg-purple">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Total Payment</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#8358;{{number_format($apptotalpaid->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="far fa-window-restore"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Completed Application</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    {{number_format($app_completed)}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>

        <h5 class="page-title">FEES BREAKDOWN</strong></h5>
        <div class="row">
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-orange">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Application</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#8358;{{number_format($appapplicationfeepaid->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card l-bg-green">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Acceptance</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#8358;{{number_format($appacceptancefeepaid->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Result Verification</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#8358;{{number_format($appresultverificationpaid->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-purple-dark">
                    <div class="info-box-5 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-money-check-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="font-20 mb-0">Portal Charge</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h3 class="d-flex align-items-center mb-0">
                                    &#8358;{{number_format($servicecharge->sum('fee_amount'))}}
                                </h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div> @endif

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item m-l-10">
                            <a class="nav-link active" data-bs-toggle="tab" href="#about">About</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane body active" id="about">

                            <p class="text-default">Welcome! <strong>{{ strtoupper($user->u_firstname) }} {{ strtoupper($user->u_lastname) }}</strong> - {{ $userGroup->group_name }}</p>

                            <p class="text-default">Use the left navigation menu to access the functionalities of the system.</p>
                            <small class="text-muted">Help and Support: </small>
                            <p>support@collegeportal.com</p>
                            <hr>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection