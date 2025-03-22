<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RemedialController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeptOptionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SchoolInfoController;
use App\Http\Controllers\OtherFeeFieldController;
use App\Http\Controllers\ProgrammeTypeController;
use App\Http\Controllers\SchoolFeeFieldController;
use App\Http\Controllers\ClearanceFeePackController;
use App\Http\Controllers\ApplicantFeeFieldController;
use App\Http\Controllers\ClearanceFeeFieldController;


Route::get('/', [LoginController::class, 'welcome']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'adminlogin'])->name('login');


Route::middleware(['checkUserSession', 'audit'])->group(function () {

    Route::get('/welcome', [Controller::class, 'dashboard']);
    Route::get('/forbidden', [LoginController::class, 'forbidden']);

    //SETTINGS
    Route::group(['middleware' => ['check_access:accessSettings']], function () {
        Route::get('schoolinfo', [SchoolInfoController::class, 'index'])->name('schoolinfo.index');
        Route::put('schoolinfo/{id}', [SchoolInfoController::class, 'update'])->name('schoolinfo.update');
        Route::resource('faculties', FacultyController::class);
        Route::resource('depts', DepartmentController::class);
        Route::resource('programmes', ProgrammeController::class);
        Route::resource('programmetypes', ProgrammeTypeController::class);
        Route::resource('cos', DeptOptionController::class);
        Route::get('/dept-options/{programme_id}/{programmetId}', [DeptOptionController::class, 'getOptionsByProgramme']);
        Route::resource('levels', LevelController::class);
        Route::resource('courses', CourseController::class);
        Route::get('get-cos/{id}', [CourseController::class, 'getcourses'])->name('getcourses');
        Route::post('/uploadcourses', [CourseController::class, 'addCourse'])->name('uploadcourses');
        Route::get('/courses-csv', function () {
            $filePath = public_path('course.csv');
            return response()->download($filePath);
        });

        Route::resource('appfees', ApplicantFeeFieldController::class);
        Route::get('getappfee/{id}', [ApplicantFeeFieldController::class, 'getappfees'])
            ->name('getappfee');

        Route::resource('otherfees', OtherFeeFieldController::class);
        Route::resource('schfees', SchoolFeeFieldController::class);
        Route::get('getschfee/{id}', [SchoolFeeFieldController::class, 'getschfees'])
            ->name('getschfee');
        Route::get('schfeesamt/{id}', [SchoolFeeFieldController::class, 'getschfeesamt'])->name('schfeesamt');
        Route::post('updateschfeesamt', [SchoolFeeFieldController::class, 'updateschfeesamt']);


        Route::resource('packs', ClearanceFeePackController::class);

        Route::resource('clearancefees', ClearanceFeeFieldController::class);
        Route::get('clearancefee/{type}/{id}', [ClearanceFeeFieldController::class, 'getclearancefee'])
            ->where('type', '(f|p)')
            ->name('clearancefee');
        Route::get('getclearancefee/{id}', [ClearanceFeeFieldController::class, 'getoneclearancefee'])
            ->name('getclearancefee');

        Route::post('storeclearancefee', [ClearanceFeeFieldController::class, 'storecfee'])->name('storeclearancefee');
        Route::post('updateclearancefee', [ClearanceFeeFieldController::class, 'updatecfee'])->name('updateclearancefee');

        Route::get('/admportal', [PortalController::class, 'admportal'])->name('admportal');
        Route::get('/showportal/{id}', [PortalController::class, 'showportal']);
        Route::post('/showportal', [PortalController::class, 'updateportal'])->name('showportal');


        Route::get('/admsession', [PortalController::class, 'portalsession'])->name('admsession');
        Route::get('/admsession/{id}', [PortalController::class, 'updatesession']);
        Route::get('/admaddsession/00', [PortalController::class, 'addsession'])->name('admaddsession');

        Route::get('/stdsession', [PortalController::class, 'stdportalsession'])->name('stdsession');
        Route::get('/stdaddsession/00', [PortalController::class, 'stdaddsession'])->name('stdaddsession');

        Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    });

    //HOSTEL
    Route::group(['middleware' => ['check_access:accessHostel']], function () {
        Route::resource('hostels', HostelController::class);
        Route::get('/hostels/{hostel}/rooms', [HostelController::class, 'showRooms'])->name('hostels.rooms');
        Route::get('/rooms/{roomid}', [HostelController::class, 'showRoom'])->name('rooms');
        Route::post('/rooms', [HostelController::class, 'updateRoom'])->name('rooms');
        Route::get('activehostels', [HostelController::class, 'activehostel'])->name('activehostels');
        Route::get('/activehostels/{hostel}/rooms', [HostelController::class, 'hostelRooms'])->name('activehostels.rooms');
        Route::post('/manualbooking', [HostelController::class, 'bookRoom'])->name('manualbooking');
        Route::get('/reservations/{roomid}', [HostelController::class, 'reservedRooms'])->name('reservations');
    });

    //USERS
    Route::group(['middleware' => ['check_access:accessUsers']], function () {
        Route::resource('/usergroup', UserGroupController::class);
        Route::resource('/users', UserController::class);
        Route::patch('/updateuserspass/{id}', [UserController::class, 'updateuserpass'])->name('updateuserspass');
        Route::resource('permissions', PermissionController::class);
        Route::get('/clearanceofficers', [UserController::class, 'getclearanceofficers'])->name('clearanceofficers');
        Route::post('/clearanceofficers', [UserController::class, 'saveclearanceofficers'])->name('saveclearanceofficers');

        Route::get('/courseadvisers', [UserController::class, 'getcourseadvisers'])->name('courseadvisers');
        Route::post('/courseadvisers', [UserController::class, 'savecourseadvisers'])->name('savecourseadvisers');
    });

    //BIODATA
    Route::group(['middleware' => ['check_access:accessBiodata']], function () {
        Route::resource('applicants', ApplicantController::class);
        Route::post('/updateapplicant', [ApplicantController::class, 'update'])->name('updateapplicant');
        Route::get('/get-lgas/{id}', [ApplicantController::class, 'getLgas'])->name('get-lgas');

        Route::get('applicantspwd', [ApplicantController::class, 'applicantspwd'])->name('applicantspwd');
        Route::get('resetPass/{id}', [ApplicantController::class, 'applicantspwdreset'])->name('resetPass');
        Route::post('uploadapplicantphoto', [ApplicantController::class, 'applicantphotoupdate'])->name('uploadapplicantphoto');
        Route::resource('olevelsubjects', SubjectController::class);

        Route::post('/download-passports', [ApplicantController::class, 'downloadPassports'])->name('download-passports');
        Route::post('/uploadadmissionlist', [ApplicantController::class, 'admitApplicant'])->name('uploadadmissionlist');
        Route::get('/download-admission-csv', function () {
            $filePath = public_path('admission.csv');
            return response()->download($filePath);
        });
        Route::get('/view-admission-list', [ApplicantController::class, 'admissionlist']);
        Route::post('/admitapplicant', [ApplicantController::class, 'admitapplicants'])->name('admitapplicant');

        Route::get('/remedialstudents', [RemedialController::class, 'index']);
        Route::get('/download-remedial-csv', function () {
            $filePath = public_path('remedial.csv');
            return response()->download($filePath);
        });
        Route::post('/uploadremediallist', [RemedialController::class, 'uploadStudents'])->name('uploadremediallist');
        Route::resource('students', StudentController::class);
        Route::get('studentsview/{id}', [StudentController::class, 'viewStudent'])->name('studentsview');
        Route::post('/updatestudent', [StudentController::class, 'update'])->name('updatestudent');
        Route::get('/addstudent', [StudentController::class, 'studentadd'])->name('addstudent');
        Route::post('/addstudent', [StudentController::class, 'store'])->name('addstudent');
        Route::get('/get-cos/{id}', [StudentController::class, 'getCos'])->name('get-cos');
        Route::get('/get-level/{id}', [StudentController::class, 'getLevels'])->name('get-level');
        Route::get('/exclusion', [StudentController::class, 'getExclusions']);
        Route::post('/uploadexclusionlist', [StudentController::class, 'excludeFees'])->name('uploadexclusionlist');
        Route::get('/download-exclusion-csv', function () {
            $filePath = public_path('exclusion.csv');
            return response()->download($filePath);
        });
        Route::post('/uploadstudentphoto', [StudentController::class, 'savestudentphoto'])->name('uploadstudentphoto');

        Route::get('/promotelist', [StudentController::class, 'getPromotionList']);
        Route::get('/download-promotionlist-csv', function () {
            $filePath = public_path('promotionlist.csv');
            return response()->download($filePath);
        });
        Route::post('/uploadpromotionlist', [StudentController::class, 'promotionList'])->name('uploadpromotionlist');
        Route::get('/matnolist', [StudentController::class, 'getMatricNoList']);
        Route::get('/admittedapplicants', [ApplicantController::class, 'getAdmittedApplicants']);
        Route::post('/uploaddeptchangelist', [ApplicantController::class, 'updateAdmissionDepartment']);
    });
    Route::get('verifystudent', [StudentController::class, 'getStudentdata'])->middleware('check_access:accessViewStudentData')->name('verify.student');

    // COURSE REG
    Route::get('/coursereg', [StudentController::class, 'getcoursereg'])->middleware('check_access:accessCourseRegistration')->name('coursereg');
    Route::get('courseview/{id}', [StudentController::class, 'showCourseReg'])->middleware('check_access:accessCourseRegistration')->name('courseview');
    Route::post('/approvecourseregistration', [StudentController::class, 'approvecoursereg'])->name('approvecourseregistration');
    Route::post('/rejectcourseregistration', [StudentController::class, 'rejectcoursereg'])->name('rejectcourseregistration');

    //CLEARANCE 
    Route::group(['middleware' => ['check_access:accessAdmissionBiodata']], function () {
        Route::resource('applicants', ApplicantController::class);
        Route::post('/clearapplicant', [ApplicantController::class, 'clear'])->name('clearapplicant');
        Route::post('/rejectapplicant', [ApplicantController::class, 'reject'])->name('rejectapplicant');
    });

    //REPORTS
    Route::group(['middleware' => ['check_access:accessReports']], function () {
        Route::get('/appfeepayment', [ReportController::class, 'getapppayment'])->name('appfeepayment');
        Route::post('/appfeepayment', [ReportController::class, 'getapppaymentbysearch'])->name('appfeepayment');
        Route::get('/expappfeepayment', [ReportController::class, 'getapppaymentbysearch'])->name('expappfeepayment');
        Route::get('/clearpayment', [ReportController::class, 'getclearpayment'])->middleware('check_access:accessClearancePayment')->name('clearpayment');
        Route::post('/clearpayment', [ReportController::class, 'getclearancepaymentbysearch'])->name('getclearpayment');
        Route::get('/expclearancefeepayment', [ReportController::class, 'getclearancepaymentbysearch'])->name('expclearancefeepayment');
        Route::get('/remedialpayment', [ReportController::class, 'getremedialpayment'])->middleware('check_access:accessRemedialPayment')->name('remedialpayment');
        Route::post('/remedialpayment', [ReportController::class, 'getremedialpaymentbysearch'])->name('getremedialpayment');
        Route::get('/expremedialfeepayment', [ReportController::class, 'getremedialpaymentbysearch'])->name('expremedialfeepayment');
        Route::get('/studentfeepayment', [ReportController::class, 'getstudentfeepayment'])->middleware('check_access:accessStudentPayment')->name('studentfeepayment');
        Route::post('/studentfeepayment', [ReportController::class, 'getstudentpaymentbysearch'])->name('getstudentfeepayment');
        Route::get('/expstudentfeepayment', [ReportController::class, 'getstudentpaymentbysearch'])->name('expstudentfeepayment');
        Route::get('/hostelpayment', [ReportController::class, 'gethostelpayment'])->name('hostelpayment');
        Route::post('/hostelpayment', [ReportController::class, 'gethostelpaymentbysearch'])->name('gethostelpayment');
        Route::get('/exphostelpayment', [ReportController::class, 'gethostelpaymentbysearch'])->name('exphostelpayment');
        Route::get('/applicantsummary', [ReportController::class, 'getapplicantpaymentsummary'])->name('applicantsummary');
        Route::get('/clearancesummary', [ReportController::class, 'getclearancepaymentsummary'])->middleware('check_access:accessClearanceSummary')->name('clearancesummary');
        Route::get('/remedialsummary', [ReportController::class, 'getremedialpaymentsummary'])->middleware('check_access:accessRemedialSummary')->name('remedialsummary');
        Route::get('/studentsummary', [ReportController::class, 'getstudentpaymentsummary'])->middleware('check_access:accessStudentSummary')->name('studentsummary');
        Route::get('/applicantsummarylist', [ReportController::class, 'getapplicantpaymentlist'])->name('applicantsummarylist');
        Route::get('/studentsummarylist', [ReportController::class, 'getstudentpaymentlist'])->name('studentsummarylist');
        Route::get('/clearancesummarylist', [ReportController::class, 'getclearancepaymentlist'])->name('clearancesummarylist');
        Route::get('/remedialsummarylist', [ReportController::class, 'getremedialpaymentlist'])->name('remedialsummarylist');

        Route::group(['middleware' => ['check_access:accessRegistrationReports']], function () {
            Route::get('/appregistration', [ReportController::class, 'appregistration']);
            Route::post('/appregistration', [ReportController::class, 'getappregistrationbysearch'])->name('getappregistration');
            Route::get('/expappregistration', [ReportController::class, 'getappregistrationbysearch'])->name('expappregistration');
            Route::get('/remedialregistration', [ReportController::class, 'remedialregistration']);
            Route::get('/expremedialregistration', [ReportController::class, 'remedialregistration'])->name('expremedialregistration');
        });
    });
});
