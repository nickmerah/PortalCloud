<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $pageTitle ?? 'Support Portal' }} </title>

    <!-- Plugins Core Css -->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- You can choose a theme from css/styles instead of get all themes -->
    <link href="{{ asset('css/styles/all-themes.css') }}" rel="stylesheet" />
</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('images/loading.png') }}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" onClick="return false;" class="navbar-toggle collapsed" data-bs-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="#" onClick="return false;" class="bars"></a>
                <a class="navbar-brand" href="{{URL::to('/welcome') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="" />
                    <span class="logo-name">{{$schoolAbvName}}</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="pull-left">
                    <li>
                        <a href="#" onClick="return false;" class="sidemenu-collapse">
                            <i data-feather="menu"></i>
                        </a>
                    </li>
                    <li>
                        <strong style="font-size:25px">{{$schoolName}}</strong>
                    </li>
                </ul>
                <ul class="pull-right">
                    <li>
                        <strong style="font-size:15px">Admin Panel</strong> - {{ $userGroup->group_name }}&nbsp;&nbsp;&nbsp;</strong>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <div>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <div class="menu">
                <ul class="list">
                    <li class="sidebar-user-panel active">
                        <div class="profile-usertitle">
                            <div class="sidebar-userpic-name">{{ strtoupper($user->u_firstname) }} {{ strtoupper($user->u_lastname) }}</div>
                            <div class="profile-usertitle-job">{{ $userGroup->group_name }}</div>
                        </div>
                    </li>
                    <li class="header">-- Menu</li>

                    <!-- Dashboard -->
                    <li class="active">
                        <a href="{{URL::to('/welcome') }}">
                            <i data-feather="monitor"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    @php
                    $userData = session('user_data');
                    $canAccessSettings = false;
                    $canAccessUsers = false;
                    $canAccessBiodata = false;
                    $canAccessReports = false;
                    $canAccessRegistrationReports = false;
                    $canAccessAdmissionBiodata = false;
                    $canAccessHostel = false;
                    $canAccessStudentPayment = false;
                    $canAccessClearancePayment = false;
                    $canAccessRemedialPayment = false;
                    $canAccessStudentSummary = false;
                    $canAccessClearanceSummary = false;
                    $canAccessRemedialSummary = false;
                    $canAccessCourseRegistration = false;
                    $canAccessViewStudentData = false;

                    if ($userData) {
                    $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
                    $policy = new \App\Policies\MenuPolicy();
                    $canAccessSettings = $policy->accessSettings($decryptedUserData);
                    $canAccessUsers = $policy->accessUsers($decryptedUserData);
                    $canAccessBiodata = $policy->accessBiodata($decryptedUserData);
                    $canAccessReports = $policy->accessReports($decryptedUserData);
                    $canAccessRegistrationReports = $policy->accessRegistrationReports($decryptedUserData);
                    $canAccessAdmissionBiodata = $policy->accessAdmissionBiodata($decryptedUserData);
                    $canAccessHostel = $policy->accessHostel($decryptedUserData);

                    $canAccessStudentPayment = $policy->accessStudentPayment($decryptedUserData);
                    $canAccessClearancePayment = $policy->accessClearancePayment($decryptedUserData);
                    $canAccessRemedialPayment = $policy->accessRemedialPayment($decryptedUserData);
                    $canAccessStudentSummary = $policy->accessStudentSummary($decryptedUserData);
                    $canAccessClearanceSummary = $policy->accessClearanceSummary($decryptedUserData);
                    $canAccessRemedialSummary = $policy->accessRemedialSummary($decryptedUserData);
                    $canAccessCourseRegistration = $policy->accessCourseRegistration($decryptedUserData);
                    $canAccessViewStudentData = $policy->accessViewStudentData($decryptedUserData);
                    }
                    @endphp
                    @if($canAccessSettings || $canAccessHostel)
                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="settings"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="ml-menu">
                            @if($canAccessSettings)
                            <h6 class="dropdown-header">SET UP</h6>
                            <li><a href="{{ URL::to('/schoolinfo') }}">Institution Info</a></li>
                            <li><a href="{{ URL::to('/faculties') }}">School</a></li>
                            <li><a href="{{ URL::to('/depts') }}">Department</a></li>
                            <li><a href="{{ URL::to('/programmes') }}">Programme</a></li>
                            <li><a href="{{ URL::to('/programmetypes') }}">Programme Type</a></li>
                            <li><a href="{{ URL::to('/cos') }}">Course of Study</a></li>
                            <li><a href="{{ URL::to('/levels') }}">Level</a></li>
                            <li><a href="{{ URL::to('/courses') }}">Courses</a></li>

                            <h6 class="dropdown-header">FEES</h6>

                            <li>
                                <a href="{{URL::to('/appfees') }}">Applicant Fees</a>
                            </li>
                            <li>
                                <a href="{{URL::to('/packs') }}">Clearance Pack/Fees</a>
                            </li>
                            <li>
                                <a href="{{URL::to('/otherfees') }}">Other Fees</a>
                            </li>
                            <li>
                                <a href="{{URL::to('/schfees') }}">School Fees</a>
                            </li>

                            <h6 class="dropdown-header">SESSION</h6>

                            <li>
                                <a href="{{URL::to('/admsession') }}">Applicant</a>
                            </li>
                            <li>
                                <a href="{{URL::to('/stdsession') }}">Portal</a>
                            </li>

                            <h6 class="dropdown-header"> PORTAL</h6>
                            <li>
                                <a href="{{URL::to('/admportal') }}">Applicant</a>
                            </li>
                            @endif
                            @if($canAccessHostel)
                            <h6 class="dropdown-header"> HOSTEL</h6>
                            <li><a href="{{ URL::to('/hostels') }}">Hostel</a></li>
                            <li><a href="{{ URL::to('/activehostels') }}">Reserve Rooms</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    <!-- Courses Section -->
                    @if($canAccessCourseRegistration)
                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="book-open"></i>
                            <span>Course Registration</span>
                        </a>
                        <ul class="ml-menu">
                            <li><a href="{{ URL::to('/coursereg') }}">View</a></li>

                        </ul>
                    </li>
                    @endif

                    <!-- Users Section -->
                    @if($canAccessUsers)
                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="user-check"></i>
                            <span>Users</span>
                        </a>
                        <ul class="ml-menu">
                            <li><a href="{{ URL::to('/users') }}">Users</a></li>
                            <li><a href="{{ URL::to('/usergroup') }}">Groups</a></li>
                            <li><a href="{{ URL::to('/permissions') }}">Permissions</a></li>
                            <li><a href="{{ URL::to('/clearanceofficers') }}">Clearance Officers</a></li>
                            <li><a href="{{ URL::to('/courseadvisers') }}">Course Advisers</a></li>
                        </ul>
                    </li>
                    @endif

                    <!-- Biodata Section -->
                    @if($canAccessBiodata || $canAccessAdmissionBiodata)
                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="users"></i>
                            <span>Biodata</span>
                        </a>
                        <ul class="ml-menu">
                            <!-- Show Admission Biodata Section Only if canAccessAdmissionBiodata is True -->
                            @if($canAccessAdmissionBiodata)
                            <h6 class="dropdown-header">APPLICANT</h6>
                            <li><a href="{{ URL::to('/applicants') }}">View / Edit</a></li>
                            <li><a href="{{ URL::to('/admittedapplicants') }}">View Admitted</a></li>
                            <li><a href="{{ URL::to('/applicantspwd') }}">Get Password</a></li>
                            <li><a href="{{ URL::to('/olevelsubjects') }}">Subjects</a></li>
                            @endif

                            <!-- Show Student Section Only if canAccessBiodata is True -->
                            @if($canAccessBiodata)
                            <h6 class="dropdown-header">STUDENTS</h6>
                            <li><a href="{{ URL::to('/students') }}">View / Edit</a></li>
                            <li><a href="{{ URL::to('/exclusion') }}">Fee Exclusion</a></li>
                            <li><a href="{{ URL::to('/promotelist') }}">Promotion List</a></li>

                            <h6 class="dropdown-header">REMEDIAL</h6>
                            <li><a href="{{ URL::to('/remedialstudents') }}">View</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif


                    <!-- Reports Section -->
                    @if($canAccessReports)
                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="server"></i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <h6 class="dropdown-header">APPLICANT</h6>
                            <li><a href="{{ URL::to('/appfeepayment') }}">Payment</a></li>
                            <li><a href="{{ URL::to('/applicantsummary') }}">Summary</a></li>
                            @if($canAccessRegistrationReports)
                            <li><a href="{{ URL::to('/appregistration') }}">Registration</a></li>
                            @endif

                            <h6 class="dropdown-header">STUDENT</h6>
                            @if($canAccessStudentPayment)
                            <li><a href="{{ URL::to('/studentfeepayment') }}">Payment</a></li>
                            @endif

                            @if($canAccessStudentSummary)
                            <li><a href="{{ URL::to('/studentsummary') }}">Summary</a></li>
                            @endif

                            <h6 class="dropdown-header">CLEARANCE</h6>
                            @if($canAccessClearancePayment)
                            <li><a href="{{ URL::to('/clearpayment') }}">Payment</a></li>
                            @endif

                            @if($canAccessClearanceSummary)
                            <li><a href="{{ URL::to('/clearancesummary') }}">Summary</a></li>
                            @endif

                            <h6 class="dropdown-header">REMEDIAL</h6>
                            @if($canAccessRemedialPayment)
                            <li><a href="{{ URL::to('/remedialpayment') }}">Payment</a></li>
                            @endif

                            @if($canAccessRemedialSummary)
                            <li><a href="{{ URL::to('/remedialsummary') }}">Summary</a></li>
                            @endif

                            @if($canAccessRegistrationReports)
                            <li><a href="{{ URL::to('/remedialregistration') }}">Registration</a></li>
                            @endif


                            <h6 class="dropdown-header">HOSTEL</h6>
                            <li><a href="{{ URL::to('/hostelpayment') }}">Payment</a></li>

                            @if($canAccessRegistrationReports)
                            <li><a href="#">Reservation</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if($canAccessViewStudentData)
                    <li class="active">
                        <a href="{{ URL::to('/verifystudent') }}">
                            <i data-feather="user"></i>
                            <span>Verified Student </span>
                        </a>
                    </li>
                    @endif

                    <!-- Logout -->
                    <li class="active">
                        <a href="{{ URL::to('/logout') }}">
                            <i data-feather="log-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>


    </div>
    @yield('contents')
    <script src="{{ asset('js/app.min.js') }}"></script>


    <script src="{{ asset('js/table.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js') }}"></script>

    <script src="{{ asset('js/pages/index.js') }}"></script>
    <script src="{{ asset('js/pages/todo/todo.js') }}"></script>

    <script src="{{ asset('js/pages/tables/jquery-datatable.js') }}"></script>
</body>


</html>