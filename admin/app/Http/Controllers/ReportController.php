<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Applicant;
use App\Models\Programme;
use App\Models\CTransaction;
use App\Models\RTransaction;
use Illuminate\Http\Request;
use App\Models\ProgrammeType;
use App\Models\AppTransaction;
use App\Models\CurrentSession;
use App\Models\StdTransaction;
use App\Models\RemedialSession;
use Illuminate\Support\Facades\DB;
use App\Models\RemedialRegistration;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RemedialSummaryExport;
use App\Exports\StudentsSummaryExport;
use App\Exports\AppPaymentReportExport;
use App\Exports\ClearanceSummaryExport;
use App\Exports\StdPaymentReportExport;
use Illuminate\Support\Facades\Session;
use App\Exports\ApplicantsSummaryExport;
use App\Exports\RemedialPaymentReportExport;
use App\Exports\ClearancePaymentReportExport;
use App\Exports\RemedialRegistrationReportExport;
use App\Exports\ApplicantRegistrationReportExport;
use App\Exports\ApplicantPaymentListExport;
use App\Exports\StudentPaymentListExport;
use App\Exports\ClearancePaymentListExport;
use App\Exports\RemedialPaymentListExport;

class ReportController extends Controller
{
    protected const STATUS_PAID = 'Paid';

    public function getapppayment()
    {

        $fromdate = Carbon::today()->toDateString();
        $todate = $fromdate;
        $appPaymentReport = AppTransaction::select(
            'rrr',
            'fullnames',
            'appno',
            DB::raw('GROUP_CONCAT(fee_name SEPARATOR ", ") as fee_name'),
            DB::raw('SUM(fee_amount) as fee_amount')
        )
            ->where('trans_custom1', self::STATUS_PAID)
            ->whereDate('t_date', $fromdate)
            ->groupBy('rrr', 'fullnames', 'appno')
            ->get();

        return view('reports.apppayment', compact('appPaymentReport', 'fromdate', 'todate'));
    }

    public function getapppaymentbysearch(Request $request)
    {
        // Validation rules
        $request->validate([
            'todate' => 'nullable|date',
            'fromdate' => 'nullable|date',
            'surname' => 'nullable|string',
            'rrr' => 'nullable|string',
            'appno' => 'nullable|string',
        ]);

        // If it's a POST request, store the search criteria in the session
        if ($request->isMethod('post')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'surname', 'rrr', 'appno']));
        }

        // Retrieve search criteria from the session
        $criteria = Session::get('search_criteria', [
            'fromdate' => Carbon::today()->toDateString(),
            'todate' => Carbon::today()->toDateString(),
            'surname' => null,
            'rrr' => null,
            'appno' => null,
        ]);

        // Build the query using the search criteria
        $query = AppTransaction::query()
            ->with(['applicant.stdcourseOption', 'applicant.std_courseOption', 'applicant.programme']);

        $fromdate = $criteria['fromdate'];
        $todate = $criteria['todate'];

        if (!empty($fromdate) && !empty($todate)) {
            $query->whereBetween('t_date', [$fromdate, $todate]);
        }

        if (!empty($criteria['surname'])) {
            $query->whereHas('applicant', function ($q) use ($criteria) {
                $q->where('fullnames', 'like', '%' . $criteria['surname'] . '%');
            });
        }

        if (!empty($criteria['rrr'])) {
            $query->where('rrr', $criteria['rrr']);
        }

        if (!empty($criteria['appno'])) {
            $query->where('appno', $criteria['appno']);
        }

        $query->where('trans_custom1', self::STATUS_PAID);

        // Get filtered results
        $appPaymentReport = $query->get();

        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {
            // Export the filtered data to Excel
            $export = Excel::download(new AppPaymentReportExport($appPaymentReport, $fromdate, $todate), 'app_payment_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        // Return the view with filtered data
        return view('reports.apppayment', compact('appPaymentReport', 'fromdate', 'todate'));
    }


    public function getclearpayment()
    {

        $fromdate = Carbon::today()->toDateString();
        $todate = $fromdate;
        $clearancePaymentReport = CTransaction::select('rrr', 'fee_name', 't_date', 'matno', 'fullnames',  DB::raw('SUM(fee_amount) as total_amount'), DB::raw('COUNT(*) as total_transactions'))
            ->where('trans_custom1', self::STATUS_PAID)
            ->whereDate('t_date', $fromdate)
            ->groupBy('rrr', 'matno', 'fullnames', 'fee_name', 't_date')
            ->get();


        return view('reports.clearancepayment', compact('clearancePaymentReport', 'fromdate', 'todate'));
    }

    public function getclearancepaymentbysearch(Request $request)
    {
        // Validation rules
        $request->validate([
            'todate' => 'nullable|date',
            'fromdate' => 'nullable|date',
            'surname' => 'nullable|string',
            'rrr' => 'nullable|string',
            'matno' => 'nullable|string',
        ]);

        // If it's a POST request, store the search criteria in the session
        if ($request->isMethod('post')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'surname', 'rrr', 'matno']));
        }

        // Retrieve search criteria from the session
        $criteria = Session::get('search_criteria', [
            'fromdate' => Carbon::today()->toDateString(),
            'todate' => Carbon::today()->toDateString(),
            'surname' => null,
            'rrr' => null,
            'matno' => null,
        ]);

        // Build the query using the search criteria
        $query = CTransaction::query()
            ->with(['clearanceStudents.clearanceDept', 'clearanceStudents.clearanceLevel', 'clearanceStudents.programme']);

        $fromdate = $criteria['fromdate'];
        $todate = $criteria['todate'];

        if (!empty($fromdate) && !empty($todate)) {
            $query->whereBetween('t_date', [$fromdate, $todate]);
        }

        if (!empty($criteria['surname'])) {
            $query->whereHas('clearanceStudents', function ($q) use ($criteria) {
                $q->where('fullnames', 'like', '%' . $criteria['surname'] . '%');
            });
        }

        if (!empty($criteria['rrr'])) {
            $query->where('rrr', $criteria['rrr']);
        }

        if (!empty($criteria['matno'])) {
            $query->where('matno', $criteria['matno']);
        }

        $query->where('trans_custom1', self::STATUS_PAID)->select('log_id', 'rrr', 'matno', 't_date', 'fee_name', 'fullnames', DB::raw('COUNT(*) as total_transactions'), DB::raw('SUM(fee_amount) as total_amount')) // Add aggregates as needed
            ->groupBy('log_id', 'rrr', 'matno', 'fullnames', 'fee_name', 't_date');

        // Get filtered results
        $clearancePaymentReport = $query->get();

        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {
            // Export the filtered data to Excel
            $export = Excel::download(new ClearancePaymentReportExport($clearancePaymentReport, $fromdate, $todate), 'clearance_payment_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        // Return the view with filtered data
        return view('reports.clearancepayment', compact('clearancePaymentReport', 'fromdate', 'todate'));
    }

    public function appregistration()
    {
        $applicants = Applicant::with('programme')
            ->whereHas('currentSession', function ($query) {
                $query->where('status', 'current');
            })
            ->get();

        $currentSession = CurrentSession::where('status', 'current')->first();
        $programmes = Programme::get();
        $programmeTypes = ProgrammeType::get();

        return view('reports.appregistration', compact('applicants', 'currentSession', 'programmes', 'programmeTypes'));
    }

    public function getappregistrationbysearch(Request $request)
    {
        // Validation rules
        $request->validate([
            'surname' => 'nullable|string',
            'appno' => 'nullable|string',
            'prog_id' => 'nullable|integer',
            'progtype_id' => 'nullable|integer',
            'appstatus' => 'nullable|integer',
            'admstatus' => 'nullable|integer',
            'eclearance' => 'nullable|integer',
        ]);

        // If it's a POST request, store the search criteria in the session
        if ($request->isMethod('post')) {
            Session::put('search_criteria', $request->only(['surname', 'appno', 'prog_id', 'progtype_id', 'appstatus', 'admstatus', 'eclearance']));
        }

        // Retrieve search criteria from the session
        $criteria = Session::get('search_criteria', [
            'surname' => null,
            'appno' => null,
            'prog_id' => null,
            'progtype_id' => null,
            'appstatus' => null,
            'admstatus' => null,
            'eclearance' => null,
        ]);

        // Build the query using the search criteria
        $query = Applicant::query()
            ->with([
                'programme',
                'stdcourseOption',
                'std_courseOption',
                'stateor',
                'lga',
                'jamb',
                'eduhistory',
            ]);


        if (!empty($criteria['prog_id'])) {
            $query->where('stdprogramme_id', $criteria['prog_id']);
        }

        if (!empty($criteria['progtype_id'])) {
            $query->where('std_programmetype', $criteria['progtype_id']);
        }

        if (!empty($criteria['surname'])) {
            $query->where('surname', 'like', '%' . $criteria['surname'] . '%');
        }

        if (!empty($criteria['appno'])) {
            $query->where('app_no', $criteria['appno']);
        }

        if (!empty($criteria['appstatus'])) {
            $query->where('std_custome9', $criteria['appstatus']);
        }

        if (!empty($criteria['admstatus'])) {
            $query->where('adm_status', $criteria['admstatus']);
        }

        if (!empty($criteria['eclearance'])) {
            $query->where('eclearance', $criteria['eclearance']);
        }

        // Get filtered results
        $applicants = $query->get();

        //  print_r($applicants->toArray());


        $currentSession = CurrentSession::where('status', 'current')->first();
        $programmes = Programme::get();
        $programmeTypes = ProgrammeType::get();

        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {

            $export = Excel::download(new ApplicantRegistrationReportExport($applicants, $currentSession->cs_session), 'applicant_registration_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }


        // Return the view with filtered data
        return view('reports.appregistration', compact('applicants', 'currentSession', 'programmes', 'programmeTypes'));
    }

    public function getremedialpayment()
    {

        $fromdate = Carbon::today()->toDateString();
        $todate = $fromdate;
        $remedialPaymentReport = RTransaction::select('rrr', 'matno', 'fullnames',  DB::raw('SUM(fee_amount) as total_amount'), DB::raw('COUNT(*) as total_transactions'))
            ->where('trans_custom1', self::STATUS_PAID)
            ->whereDate('t_date', $fromdate)
            ->groupBy('rrr', 'matno', 'fullnames')
            ->get();

        return view('reports.remedialpayment', compact('remedialPaymentReport', 'fromdate', 'todate'));
    }

    public function getremedialpaymentbysearch(Request $request)
    {
        // Validation rules
        $request->validate([
            'todate' => 'nullable|date',
            'fromdate' => 'nullable|date',
            'surname' => 'nullable|string',
            'rrr' => 'nullable|string',
            'matno' => 'nullable|string',
        ]);

        // If it's a POST request, store the search criteria in the session
        if ($request->isMethod('post')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'surname', 'rrr', 'matno']));
        }

        // Retrieve search criteria from the session
        $criteria = Session::get('search_criteria', [
            'fromdate' => Carbon::today()->toDateString(),
            'todate' => Carbon::today()->toDateString(),
            'surname' => null,
            'rrr' => null,
            'matno' => null,
        ]);

        // Build the query using the search criteria
        $query = RTransaction::query();

        $fromdate = $criteria['fromdate'];
        $todate = $criteria['todate'];

        if (!empty($fromdate) && !empty($todate)) {
            $query->whereBetween('t_date', [$fromdate, $todate]);
        }

        if (!empty($criteria['rrr'])) {
            $query->where('rrr', $criteria['rrr']);
        }

        if (!empty($criteria['rrr'])) {
            $query->where('rrr', $criteria['rrr']);
        }

        if (!empty($criteria['matno'])) {
            $query->where('matno', $criteria['matno']);
        }

        $query->where('trans_custom1', self::STATUS_PAID)->select('log_id', 'rrr', 'matno', 't_date', 'course', 'trans_year', 'fullnames', DB::raw('COUNT(*) as total_transactions'), DB::raw('SUM(fee_amount) as total_amount')) // Add aggregates as needed
            ->groupBy('log_id', 'rrr', 'matno', 'fullnames', 'course', 'trans_year', 't_date',);

        // Get filtered results
        $remedialPaymentReport = $query->get();


        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {
            // Export the filtered data to Excel
            $export = Excel::download(new RemedialPaymentReportExport($remedialPaymentReport, $fromdate, $todate), 'remedial_payment_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        // Return the view with filtered data
        return view('reports.remedialpayment', compact('remedialPaymentReport', 'fromdate', 'todate'));
    }


    public function remedialregistration(Request $request)
    {
        $remedialReg = RemedialRegistration::whereHas('currentSession', function ($query) {
            $query->where('status', 'current');
        })
            ->with(['remedial' => function ($query) {
                $query->select('id', 'matno', 'surname', 'firstname', 'othername', 'level');
            }])
            ->get()
            ->groupBy('std_id')
            ->map(function ($group) {
                $remedialInfo = $group->first()->remedial;

                return [
                    'matno' => $remedialInfo->matno,
                    'surname' => $remedialInfo->surname,
                    'firstname' => $remedialInfo->firstname,
                    'othername' => $remedialInfo->othername,
                    'level' => $remedialInfo->level,
                    'course_codes' => $group->pluck('c_code'),
                    'date_reg' => $remedialInfo->cdate_reg,
                ];
            });

        $currentSession = RemedialSession::where('status', 'current')->first();


        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {

            $export = Excel::download(new RemedialRegistrationReportExport($remedialReg, $currentSession), 'remedial_registration_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }


        return view('reports.remedialregistration', compact('remedialReg', 'currentSession'));
    }

    public function getstudentfeepayment()
    {

        $fromdate = Carbon::today()->toDateString();
        $todate = $fromdate;
        $getPaymentSessions = StdTransaction::getStdTransactionSessions();
        $stdPaymentReport = StdTransaction::select(
            'rrr',
            'fullnames',
            'appno',
            DB::raw('GROUP_CONCAT(trans_name SEPARATOR ", ") as trans_name'),
            DB::raw('SUM(trans_amount) as trans_amount')
        )
            ->where('pay_status', self::STATUS_PAID)
            ->whereDate('t_date', $fromdate)
            ->groupBy('rrr', 'fullnames', 'appno')
            ->get();

        return view('reports.stdpayment', compact('stdPaymentReport', 'fromdate', 'todate', 'getPaymentSessions'));
    }

    public function getstudentpaymentbysearch(Request $request)
    {
        // Validation rules
        $request->validate([
            'todate' => 'nullable|date',
            'fromdate' => 'nullable|date',
            'surname' => 'nullable|string',
            'rrr' => 'nullable|string',
            'appno' => 'nullable|string',
            'sess' => 'nullable|string',
        ]);

        // If it's a POST request, store the search criteria in the session
        if ($request->isMethod('post')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'surname', 'rrr', 'appno', 'sess']));
        }

        // Retrieve search criteria from the session
        $criteria = Session::get('search_criteria', [
            'fromdate' => Carbon::today()->toDateString(),
            'todate' => Carbon::today()->toDateString(),
            'surname' => null,
            'rrr' => null,
            'appno' => null,
            'sess' => null,
        ]);

        // Build the query using the search criteria
        $query = StdTransaction::query()
            ->with(['student.stdcourseOption', 'student.programme']);

        $fromdate = $criteria['fromdate'];
        $todate = $criteria['todate'];
        $sess = $criteria['sess'];

        if (!empty($fromdate) && !empty($todate)) {
            $query->whereBetween('t_date', [$fromdate, $todate]);
        }

        if (!empty($criteria['surname'])) {
            $query->whereHas('student', function ($q) use ($criteria) {
                $q->where('fullnames', 'like', '%' . $criteria['surname'] . '%');
            });
        }

        if (!empty($criteria['rrr'])) {
            $query->where('rrr', $criteria['rrr']);
        }

        if (!empty($criteria['appno'])) {
            $query->where('appno', $criteria['appno']);
        }

        if (!empty($criteria['sess'])) {
            $query->where('trans_year', $criteria['sess']);
        }

        $query->where('pay_status', self::STATUS_PAID);

        // Get filtered results
        $stdPaymentReport = $query->get();
        $count = $stdPaymentReport->count();

        if ($count > 20000) {
            return redirect()->back()->withErrors('The search results have a large dataset, kindly add more search criteria.');
        }

        $getPaymentSessions = StdTransaction::getStdTransactionSessions();
        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {
            // Export the filtered data to Excel
            $export = Excel::download(new StdPaymentReportExport($stdPaymentReport, $fromdate, $todate, $sess), 'std_payment_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        // Return the view with filtered data
        return view('reports.stdpayment', compact('stdPaymentReport', 'fromdate', 'todate', 'getPaymentSessions'));
    }


    public function gethostelpayment()
    {

        $fromdate = Carbon::today()->toDateString();
        $todate = $fromdate;
        $hostelPaymentReport = StdTransaction::select(
            'rrr',
            'fullnames',
            'appno',
            DB::raw('GROUP_CONCAT(trans_name SEPARATOR ", ") as fee_names'),
            DB::raw('SUM(trans_amount) as total_amount')
        )
            ->where('pay_status', self::STATUS_PAID)
            ->whereDate('t_date', $fromdate)
            ->where('fee_type', 'ofees')
            ->whereIn('fee_id', [6, 7]) // hostel payment
            ->groupBy('rrr', 'fullnames', 'appno')
            ->get();

        return view('reports.hostelpayment', compact('hostelPaymentReport', 'fromdate', 'todate'));
    }

    public function gethostelpaymentbysearch(Request $request)
    {
        $request->validate([
            'todate' => 'nullable|date',
            'fromdate' => 'nullable|date',
            'surname' => 'nullable|string',
            'rrr' => 'nullable|string',
            'appno' => 'nullable|string',
        ]);

        if ($request->isMethod('post')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'surname', 'rrr', 'appno']));
        }

        $criteria = Session::get('search_criteria', [
            'fromdate' => Carbon::today()->toDateString(),
            'todate' => Carbon::today()->toDateString(),
            'surname' => null,
            'rrr' => null,
            'appno' => null,
        ]);

        $query = StdTransaction::query()
            ->with(['student.stdcourseOption', 'student.programme']);

        $fromdate = $criteria['fromdate'];
        $todate = $criteria['todate'];

        if (!empty($fromdate) && !empty($todate)) {
            $query->whereBetween('t_date', [$fromdate, $todate]);
        }

        if (!empty($criteria['surname'])) {
            $query->whereHas('student', function ($q) use ($criteria) {
                $q->where('fullnames', 'like', '%' . $criteria['surname'] . '%');
            });
        }

        if (!empty($criteria['rrr'])) {
            $query->where('rrr', $criteria['rrr']);
        }

        if (!empty($criteria['appno'])) {
            $query->where('appno', $criteria['appno']);
        }

        $query->where('pay_status', self::STATUS_PAID)
            ->where('fee_type', 'ofees')
            ->whereIn('fee_id', [6, 7]);

        // Get filtered results
        $hostelPaymentReport = $query->get();


        // Check if the request is for export to Excel
        if ($request->query('export') === 'excel') {
            // Export the filtered data to Excel
            $export = Excel::download(new StdPaymentReportExport($hostelPaymentReport, $fromdate, $todate), 'std_payment_report.xls');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        // Return the view with filtered data
        return view('reports.hostelpayment', compact('hostelPaymentReport', 'fromdate', 'todate'));
    }

    public function getapplicantpaymentsummary(Request $request)
    {
        $prog = "";
        $progtype = "";

        $validated = $request->validate([
            'fromdate' => 'nullable|date',
            'todate' => 'nullable|date',
            'prog' => 'nullable|integer',
            'progtype' => 'nullable|integer',
            'export' => 'nullable|string',
        ]);

        if ($request->isMethod('get')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'prog', 'progtype']));
        }

        $frommonth = Carbon::parse($validated['fromdate'] ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($validated['todate'] ?? Carbon::today()->endOfMonth());
        $criteria = Session::get('search_criteria', [
            'fromdate' => $frommonth->toDateString(),
            'todate' => $tomonth->toDateString(),
            'prog' => null,
            'progtype' => null,
        ]);

        // Fetch additional data for the view
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();

        // Initialize the query
        $query = AppTransaction::query();

        // Apply filters based on the criteria
        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        if (!empty($criteria['prog'])) {
            $prog = $criteria['prog'] == 1 ? 'ND' : 'HND';
            $query->where('appno', 'like',  $prog . '%');
        }

        if (!empty($criteria['progtype'])) {
            $progtype = $criteria['progtype'] == 1 ? 'FT' : 'PT';
            $query->where('appno', 'like', '%' . $progtype . '%');
        }

        // Fetch payment summary
        $paymentReport = $query->select(
            'fee_name',
            'fee_id',
            DB::raw('SUM(fee_amount) as total_amount')
        )
            ->where(['trans_custom1' => self::STATUS_PAID])
            ->groupBy('fee_name', 'fee_id')
            ->orderBy('fee_name')
            ->get();

        $totalSum = $paymentReport->sum('total_amount') ?? 0;
        /*$sql = $query->toSql();
         $bindings = $query->getBindings();
         $queryWithValues = vsprintf(str_replace('?', '%s', $sql), $bindings);
         dd($queryWithValues);*/

        // Check if the request is for export to Excel

        if ($request->query('export') === 'excel') {

            // Export the filtered data to Excel
            $export = Excel::download(new ApplicantsSummaryExport($paymentReport, $prog, $progtype, $frommonth, $tomonth, $totalSum), 'applicantsPayment_summary.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        return view('reports.applicationsummarypayment', array_merge(
            compact('paymentReport', 'programmes', 'programmeTypes', 'frommonth', 'tomonth', 'totalSum'),
            array_filter([
                'prog' => $prog ?? null,
                'progtype' => $progtype ?? null,
            ])
        ));
    }

    public function getclearancepaymentsummary(Request $request)
    {
        $validated = $request->validate([
            'fromdate' => 'nullable|date',
            'todate' => 'nullable|date',
            'export' => 'nullable|string',
        ]);

        if ($request->isMethod('get')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate']));
        }

        $frommonth = Carbon::parse($validated['fromdate'] ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($validated['todate'] ?? Carbon::today()->endOfMonth());
        $criteria = Session::get('search_criteria', [
            'fromdate' => $frommonth->toDateString(),
            'todate' => $tomonth->toDateString(),
        ]);

        $query = CTransaction::query();

        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        $paymentReport = $query->select(
            'fee_name',
            DB::raw('SUM(fee_amount) as total_amount')
        )
            ->where(['trans_custom1' => self::STATUS_PAID])
            ->groupBy('fee_name')
            ->orderBy('fee_name')
            ->get();

        $totalSum = $paymentReport->sum('total_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            $export = Excel::download(new ClearanceSummaryExport($paymentReport, $frommonth, $tomonth, $totalSum), 'clearancePayment_summary.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        return view('reports.clearancesummarypayment', compact('paymentReport', 'frommonth', 'tomonth', 'totalSum'));
    }

    public function getremedialpaymentsummary(Request $request)
    {
        $validated = $request->validate([
            'fromdate' => 'nullable|date',
            'todate' => 'nullable|date',
            'export' => 'nullable|string',
        ]);

        if ($request->isMethod('get')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate']));
        }

        $frommonth = Carbon::parse($validated['fromdate'] ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($validated['todate'] ?? Carbon::today()->endOfMonth());
        $criteria = Session::get('search_criteria', [
            'fromdate' => $frommonth->toDateString(),
            'todate' => $tomonth->toDateString(),
        ]);

        $query = RTransaction::query();

        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        $paymentReport = $query->select(
            'fee_name',
            DB::raw('SUM(fee_amount) as total_amount')
        )
            ->where(['trans_custom1' => self::STATUS_PAID])
            ->groupBy('fee_name')
            ->orderBy('fee_name')
            ->get();

        $totalSum = $paymentReport->sum('total_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            $export = Excel::download(new RemedialSummaryExport($paymentReport, $frommonth, $tomonth, $totalSum), 'remedialPayment_summary.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        return view('reports.remedialsummarypayment', compact('paymentReport', 'frommonth', 'tomonth', 'totalSum'));
    }

    public function getstudentpaymentsummary(Request $request)
    {
        $prog = "";
        $progtype = "";
        $sess = "";

        $validated = $request->validate([
            'fromdate' => 'nullable|date',
            'todate' => 'nullable|date',
            'prog' => 'nullable|integer',
            'progtype' => 'nullable|integer',
            'export' => 'nullable|string',
            'sess' => 'nullable|string',
        ]);

        if ($request->isMethod('get')) {
            Session::put('search_criteria', $request->only(['fromdate', 'todate', 'prog', 'progtype', 'sess']));
        }

        $frommonth = Carbon::parse($validated['fromdate'] ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($validated['todate'] ?? Carbon::today()->endOfMonth());
        $criteria = Session::get('search_criteria', [
            'fromdate' => $frommonth->toDateString(),
            'todate' => $tomonth->toDateString(),
            'prog' => null,
            'progtype' => null,
        ]);

        // Fetch additional data for the view
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $getPaymentSessions = StdTransaction::getStdTransactionSessions();

        // Initialize the query
        $query = StdTransaction::query();

        // Apply filters based on the criteria
        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        if (!empty($criteria['prog'])) {
            $prog = $criteria['prog'] == 1 ? 'ND' : 'HND';
            $query->where('prog_id', $criteria['prog']);
        }

        if (!empty($criteria['progtype'])) {
            $progtype = $criteria['progtype'] == 1 ? 'FT' : 'PT';
            $query->where('prog_type', $criteria['progtype']);
        }

        if (!empty($criteria['sess'])) {
            $query->where('trans_year', $criteria['sess']);
            $sess = $criteria['sess'];
        }

        // Fetch payment summary
        $paymentReport = $query->select(
            'trans_name',
            'fee_id',
            'fee_type',
            DB::raw('SUM(trans_amount) as total_amount')
        )
            ->where(['pay_status' => self::STATUS_PAID])
            ->groupBy('trans_name', 'fee_id', 'fee_type')
            ->orderBy('trans_name')
            ->get();

        $totalSum = $paymentReport->sum('total_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            // Export the filtered data to Excel
            $export = Excel::download(new StudentsSummaryExport($paymentReport,  $prog, $progtype, $frommonth, $tomonth, $totalSum, $sess), 'studentsPayment_summary.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }

        return view('reports.studentsummarypayment', array_merge(
            compact('paymentReport', 'programmes', 'programmeTypes', 'frommonth', 'tomonth', 'totalSum', 'getPaymentSessions', 'sess'),
            array_filter([
                'prog' => $prog ?? null,
                'progtype' => $progtype ?? null,
            ])
        ));
    }

    public function getapplicantpaymentlist(Request $request)
    {
        $query = $request->query();

        $frommonth = $request->query('fromdate');
        $tomonth = $request->query('todate');
        $prog = $request->query('prog');
        $progtype = $request->query('progtype');
        $fid = $request->query('fid');


        $frommonth = Carbon::parse($frommonth ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($tomonth ?? Carbon::today()->endOfMonth());

        // Initialize the query
        $query = AppTransaction::query();

        // Apply filters based on the criteria
        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        if (!empty($prog)) {
            $prog = $prog == 1 ? 'ND' : 'HND';
            $query->where('appno', 'like', $prog . '%');
        }

        if (!empty($progtype)) {
            $progtype = $progtype == 1 ? 'FT' : 'PT';
            $query->where('appno', 'like', '%' . $progtype . '%');
        }

        if (!empty($fid)) {
            $query->where('fee_id', $fid);
        }


        // Fetch payment summary
        $paymentReport = $query->select(
            'appno',
            'fullnames',
            'fee_name',
            't_date',
            'fee_amount',
            'rrr',
        )
            ->where(['trans_custom1' => self::STATUS_PAID])
            ->orderBy('t_date')
            ->get();

        $totalSum = $paymentReport->sum('fee_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            // Export the filtered data to Excel
            $export = Excel::download(new ApplicantPaymentListExport($paymentReport,  $prog, $progtype, $frommonth, $tomonth, $totalSum), 'applicantsPayment_list.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }


        return view('reports.applicantpaymentlist', compact('paymentReport', 'frommonth', 'prog', 'progtype', 'tomonth', 'totalSum'));
    }

    public function getstudentpaymentlist(Request $request)
    {
        $prog = "";
        $progtype = "";
        $sess = "";

        $query = $request->query();

        $frommonth = $request->query('fromdate');
        $tomonth = $request->query('todate');
        $progs = $request->query('prog');
        $progtypes = $request->query('progtype');
        $fid = $request->query('fid');
        $ft = $request->query('ft');
        $sess = $request->query('sess');


        $frommonth = Carbon::parse($frommonth ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($tomonth ?? Carbon::today()->endOfMonth());

        // Initialize the query
        $query = StdTransaction::query();

        // Apply filters based on the criteria
        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        if (!empty($progs)) {
            $prog = $progs == 1 ? 'ND' : 'HND';
            $query->where('prog_id', $progs);
        }

        if (!empty($progtypes)) {
            $progtype = $progtypes == 1 ? 'FT' : 'PT';
            $query->where('prog_type',  $progtypes);
        }

        if (!empty($fid)) {
            $query->where('fee_id', $fid);
        }

        if (!empty($ft)) {
            $query->where('fee_type', $ft);
        }


        if (!empty($sess)) {
            $query->where('trans_year', $sess);
        }


        // Fetch payment summary
        $paymentReport = $query->select(
            'appno',
            'fullnames',
            'log_id',
            'appsor',
            'trans_name',
            'fee_type',
            't_date',
            'trans_amount',
            'rrr',
        )
            ->where(['pay_status' => self::STATUS_PAID])
            ->orderBy('t_date')
            ->get();

        $totalSum = $paymentReport->sum('trans_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            // Export the filtered data to Excel
            $export = Excel::download(new StudentPaymentListExport($paymentReport,  $prog, $progtype, $frommonth, $tomonth, $totalSum, $sess), 'studentsPayment_list.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }


        return view('reports.studentpaymentlist', compact('paymentReport', 'frommonth', 'prog', 'progtype', 'tomonth', 'totalSum', 'sess'));
    }


    public function getclearancepaymentlist(Request $request)
    {
        $query = $request->query();

        $frommonth = $request->query('fromdate');
        $tomonth = $request->query('todate');
        $fname = $request->query('fname');

        $frommonth = Carbon::parse($frommonth ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($tomonth ?? Carbon::today()->endOfMonth());

        // Initialize the query
        $query = CTransaction::query();

        // Apply filters based on the criteria
        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        // Fetch payment summary
        $paymentReport = $query->select(
            'matno',
            'fullnames',
            'fee_name',
            't_date',
            'fee_amount',
            'rrr',
        )
            ->where(['trans_custom1' => self::STATUS_PAID, 'fee_name' => $fname,])
            ->orderBy('t_date')
            ->get();

        $totalSum = $paymentReport->sum('fee_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            // Export the filtered data to Excel
            $export = Excel::download(new ClearancePaymentListExport($paymentReport,   $frommonth, $tomonth, $totalSum), 'clearancePayment_list.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }


        return view('reports.clearancepaymentlist', compact('paymentReport', 'frommonth',   'tomonth', 'totalSum'));
    }

    public function getremedialpaymentlist(Request $request)
    {
        $query = $request->query();

        $frommonth = $request->query('fromdate');
        $tomonth = $request->query('todate');
        $fname = $request->query('fname');

        $frommonth = Carbon::parse($frommonth ?? Carbon::today()->startOfMonth());
        $tomonth = Carbon::parse($tomonth ?? Carbon::today()->endOfMonth());

        // Initialize the query
        $query = RTransaction::query();

        // Apply filters based on the criteria
        if (!empty($frommonth) && !empty($tomonth)) {
            $query->whereBetween('t_date', [$frommonth, $tomonth]);
        }

        // Fetch payment summary
        $paymentReport = $query->select(
            'matno',
            'fullnames',
            'fee_name',
            't_date',
            'fee_amount',
            'rrr',
        )
            ->where(['trans_custom1' => self::STATUS_PAID, 'fee_name' => $fname,])
            ->orderBy('t_date')
            ->get();

        $totalSum = $paymentReport->sum('fee_amount') ?? 0;

        if ($request->query('export') === 'excel') {

            // Export the filtered data to Excel
            $export = Excel::download(new RemedialPaymentListExport($paymentReport,   $frommonth, $tomonth, $totalSum), 'remedialPayment_list.xlsx');

            Session::flash('success', 'The payment report has been successfully exported!');

            return $export;
        }


        return view('reports.remedialpaymentlist', compact('paymentReport', 'frommonth',   'tomonth', 'totalSum'));
    }
}
