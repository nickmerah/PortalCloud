<?php

namespace App\Http\Controllers;

use App\Models\CourseRegistration;
use App\Models\Lga;
use App\Models\Level;
use App\Models\Users;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Programme;
use App\Models\Department;
use App\Models\DeptOption;
use App\Models\CTransaction;
use App\Models\RTransaction;
use Illuminate\Http\Request;
use App\Models\ProgrammeType;
use App\Models\StateOfOrigin;
use App\Models\StdCurrentSession;
use App\Models\StdTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    protected $baseUrl = 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/';


    public function index(Request $request)
    {
        $query = Student::with('programme');

        if ($request->filled('matric_no')) {
            $query->where('matric_no', 'like', '%' . $request->matric_no . '%');
        }
        if ($request->filled('surname')) {
            $query->where('surname', 'like', '%' . $request->surname . '%');
        }

        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $levels = Level::all();

        $students = $query->paginate(50);

        return view('students.start', compact('students', 'programmes', 'programmeTypes', 'levels'));
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return redirect()->route('students.index')
                ->with('error', 'Record not found');
        }

        $statesOfOrigin = StateOfOrigin::all();
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $courseOfStudy = DeptOption::where(["prog_id" => $student->stdprogramme_id])->get();
        $lgaName = LGA::where('lga_id', $student->local_gov)->value('lga_name');
        $schools = Faculty::all();
        $depts = Department::all();
        $levels = Level::where(["programme_id" => $student->stdprogramme_id])->get();

        return view('students.show', compact(
            'student',
            'statesOfOrigin',
            'programmes',
            'programmeTypes',
            'courseOfStudy',
            'lgaName',
            'schools',
            'depts',
            'levels'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'matric_no' => 'required|string|max:25',
            'surname' => 'required|string|max:150',
            'firstname' => 'required|string|max:150',
            'student_email' => 'required|string|email|max:250',
            'student_mobiletel' => 'required|string|max:25',
            'contact_address' => 'required|string|max:255',
            'next_of_kin' => 'required|string|max:150',
            'nok_address' => 'required|string|max:250',
            'nok_tel' => 'required|string|max:25',
            'gender' => 'required|string|max:6',
            'birthdate' => 'required|date',
            'stdlevel' => 'required|integer',
            'marital_status' => 'required|string|max:10',
            'local_gov' => 'required|integer',
            'state_of_origin' => 'required|integer',
            'stdcourse' => 'required|integer',
            'stdprogrammetype_id' => 'required|integer',
        ], [
            'matric_no.required' => 'The Matriculation No field is required.',
            'matric_no.string' => 'The Matriculation No must be a string.',
            'matric_no.max' => 'The Matriculation No may not be greater than 25 characters.',
            
            'surname.required' => 'The surname field is required.',
            'surname.string' => 'The surname must be a string.',
            'surname.max' => 'The surname may not be greater than 150 characters.',

            'firstname.required' => 'The firstname field is required.',
            'firstname.string' => 'The firstname must be a string.',
            'firstname.max' => 'The firstname may not be greater than 150 characters.',

            'stdprogrammetype_id.required' => 'The programme type field is required.',
            'stdprogrammetype_id.integer' => 'The programme type must be an integer.',

            'stdcourse.required' => 'The course of study field is required.',
            'stdcourse.integer' => 'The course of study must be an integer.',

            'student_email.required' => 'The email field is required.',
            'student_email.string' => 'The email must be a string.',
            'student_email.email' => 'The email must be a valid email address.',
            'student_email.max' => 'The email may not be greater than 250 characters.',

            'student_mobiletel.required' => 'The mobile telephone field is required.',
            'student_mobiletel.string' => 'The mobile telephone must be a string.',
            'student_mobiletel.max' => 'The mobile telephone may not be greater than 25 characters.',

            'contact_address.required' => 'The contact address field is required.',
            'contact_address.string' => 'The contact address must be a string.',
            'contact_address.max' => 'The contact address may not be greater than 255 characters.',

            'next_of_kin.required' => 'The next of kin field is required.',
            'next_of_kin.string' => 'The next of kin must be a string.',
            'next_of_kin.max' => 'The next of kin may not be greater than 150 characters.',

            'nok_address.required' => 'The next of kin address field is required.',
            'nok_address.string' => 'The next of kin address must be a string.',
            'nok_address.max' => 'The next of kin address may not be greater than 250 characters.',

            'nok_tel.required' => 'The next of kin telephone field is required.',
            'nok_tel.string' => 'The next of kin telephone must be a string.',
            'nok_tel.max' => 'The next of kin telephone may not be greater than 25 characters.',

            'gender.required' => 'The gender field is required.',
            'gender.string' => 'The gender must be a string.',
            'gender.max' => 'The gender may not be greater than 6 characters.',

            'birthdate.required' => 'The birthdate field is required.',
            'birthdate.date' => 'The birthdate must be a valid date.',

            'stdlevel.required' => 'The level field is required.',
            'stdlevel.integer' => 'The level must be an integer.',

            'marital_status.required' => 'The marital status field is required.',
            'marital_status.string' => 'The marital status must be a string.',
            'marital_status.max' => 'The marital status may not be greater than 10 characters.',

            'local_gov.required' => 'The local government field is required.',
            'local_gov.integer' => 'The local government must be an integer.',

            'state_of_origin.required' => 'The state of origin field is required.',
            'state_of_origin.integer' => 'The state of origin must be an integer.',
        ]);


        $student = Student::find($request->stdid);

        if (is_null($student)) {
            return redirect()->route('students.index')
                ->with('error', 'Record not found');
        }

        if ($request->stdcourse && $request->stdcourse != $student->stdcourse) {
            $stdcourseDetails = DeptOption::select('dept_options.dept_id', 'departments.fac_id')
                ->join('departments', 'departments.departments_id', '=', 'dept_options.dept_id')
                ->where('dept_options.do_id', $request->stdcourse)
                ->first();

            if ($stdcourseDetails) {
                $student->stddepartment_id = $stdcourseDetails->dept_id;
                $student->stdfaculty_id = $stdcourseDetails->fac_id;
            }
        }
        $student->fill($request->all());
        $student->update();

        return redirect()->intended('students/' . $request->stdid);
    }

    public function getLgas($id)
    {

        $lgas = Lga::where('state_id', $id)->pluck('lga_name', 'lga_id');

        return response()->json($lgas);
    }

    public function getCos($id)
    {
        $cos = DeptOption::where('prog_id', $id)
            ->orderBy('programme_option', 'asc')
            ->pluck('programme_option', 'do_id');

        return response()->json($cos);
    }

    public function getLevels($id)
    {
        $levels = Level::where('programme_id', $id)
            ->orderBy('level_name', 'asc')
            ->pluck('level_name', 'level_id');

        return response()->json($levels);
    }

    public function getExclusions()
    {
        $exclusions =  DB::table('exclusion')->get();
        return view('students.exclusions', compact('exclusions'));
    }


    public function getPromotionList()
    {
        $stdpromote_list =  DB::table('stdpromote_list')->get();
        return view('students.promote_list', compact('stdpromote_list'));
    }


    public function excludeFees(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);
            $matnoIndex = array_search('matno', $headers);
            $amountIndex = array_search('amount', $headers);
            if ($matnoIndex === false || $amountIndex === false) {
                return redirect()->back()->withErrors('CSV must contain "matno" and "amount" columns.');
            }
            while (($row = fgetcsv($handle)) !== false) {
                $matno = trim(strtoupper($row[$matnoIndex]));
                $amount = (int) trim($row[$amountIndex]);
                DB::table('exclusion')->updateOrInsert(
                    ['matno' => $matno],
                    [
                        'balance' => $amount,
                    ]
                );
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Exclusion list uploaded successfully');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }

    public function studentadd()
    {
        $statesOfOrigin = StateOfOrigin::all();
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $schools = Faculty::all();
        $depts = Department::all();
        $levels = Level::all();

        return view('students.add', compact(
            'statesOfOrigin',
            'programmes',
            'programmeTypes',
            'schools',
            'depts',
            'levels'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'matno' => 'required|string|max:150',
            'surname' => 'required|string|max:150',
            'stdno' => 'required|string|max:100',
            'firstname' => 'required|string|max:150',
            'othername' => 'required|string|max:150',
            'student_email' => 'required|string|email|max:250',
            'student_mobiletel' => 'required|string|max:25',
            'contact_address' => 'required|string|max:255',
            'next_of_kin' => 'required|string|max:150',
            'nok_address' => 'required|string|max:250',
            'nok_tel' => 'required|string|max:25',
            'gender' => 'required|string|max:6',
            'birthdate' => 'required|date',
            'prog' => 'required|integer',
            'progtype' => 'required|integer',
            'stdcourse' => 'required|integer',
            'stdlevel' => 'required|integer',
            'local_gov' => 'required|integer',
            'state_of_origin' => 'required|integer',
        ], [
            'matno.required' => 'The Matriculation No field is required.',
            'stdno.string' => 'The Matriculation No must be a string.',
            'stdno.max' => 'The Matriculation No may not be greater than 150 characters.',

            'stdno.required' => 'The Student No field is required.',
            'stdno.string' => 'The Student No must be a string.',
            'stdno.max' => 'The Student No may not be greater than 150 characters.',

            'surname.required' => 'The surname field is required.',
            'surname.string' => 'The surname must be a string.',
            'surname.max' => 'The surname may not be greater than 150 characters.',

            'firstname.required' => 'The firstname field is required.',
            'firstname.string' => 'The firstname must be a string.',
            'firstname.max' => 'The firstname may not be greater than 150 characters.',

            'othername.required' => 'The othernames field is required.',
            'othername.string' => 'The othernames must be a string.',
            'othername.max' => 'The othernames may not be greater than 150 characters.',

            'student_email.required' => 'The email field is required.',
            'student_email.string' => 'The email must be a string.',
            'student_email.email' => 'The email must be a valid email address.',
            'student_email.max' => 'The email may not be greater than 250 characters.',

            'student_mobiletel.required' => 'The mobile telephone field is required.',
            'student_mobiletel.string' => 'The mobile telephone must be a string.',
            'student_mobiletel.max' => 'The mobile telephone may not be greater than 25 characters.',

            'contact_address.required' => 'The contact address field is required.',
            'contact_address.string' => 'The contact address must be a string.',
            'contact_address.max' => 'The contact address may not be greater than 255 characters.',

            'next_of_kin.required' => 'The next of kin field is required.',
            'next_of_kin.string' => 'The next of kin must be a string.',
            'next_of_kin.max' => 'The next of kin may not be greater than 150 characters.',

            'nok_address.required' => 'The next of kin address field is required.',
            'nok_address.string' => 'The next of kin address must be a string.',
            'nok_address.max' => 'The next of kin address may not be greater than 250 characters.',

            'nok_tel.required' => 'The next of kin telephone field is required.',
            'nok_tel.string' => 'The next of kin telephone must be a string.',
            'nok_tel.max' => 'The next of kin telephone may not be greater than 25 characters.',

            'gender.required' => 'The gender field is required.',
            'gender.string' => 'The gender must be a string.',
            'gender.max' => 'The gender may not be greater than 6 characters.',

            'birthdate.required' => 'The birthdate field is required.',
            'birthdate.date' => 'The birthdate must be a valid date.',

            'stdlevel.required' => 'The level field is required.',
            'stdlevel.integer' => 'The level must be an integer.',



            'local_gov.required' => 'The local government field is required.',
            'local_gov.integer' => 'The local government must be an integer.',

            'state_of_origin.required' => 'The state of origin field is required.',
            'state_of_origin.integer' => 'The state of origin must be an integer.',

            'stdcourse.required' => 'The course of study field is required.',
            'stdcourse.integer' => 'The course of study must be an integer.',

            'prog.required' => 'The Programme field is required.',
            'prog.integer' => 'The Programme must be an integer.',

            'progtype.required' => 'The Programme Type field is required.',
            'progtype.integer' => 'The Programme Type must be an integer.',
        ]);


        $student = DB::table('stdaccess')->where('matno', $request->matno)->exists();

        if ($student) {
            return redirect()->route('students.index')
                ->with('error', 'Student Record already exist, advise student to verify');
        }

        // Insert the validated data into the stdaccess table
        DB::table('stdaccess')->insert([
            'matno' => strtoupper($validatedData['matno']),
            'stdno' => strtoupper($validatedData['stdno']),
            'surname' => strtoupper($validatedData['surname']),
            'firstname' => strtoupper($validatedData['firstname']),
            'othername' => strtoupper($validatedData['othername']),
            'email' => strtolower($validatedData['student_email']),
            'gsm' => $validatedData['student_mobiletel'],
            'homeAddress' => strtoupper($validatedData['contact_address']),
            'nok' => strtoupper($validatedData['next_of_kin']),
            'nokadd' => strtoupper($validatedData['nok_address']),
            'nokgsm' => $validatedData['nok_tel'],
            'gender' => $validatedData['gender'],
            'birthdate' => $validatedData['birthdate'],
            'prog' => $validatedData['prog'],
            'progtype' => $validatedData['progtype'],
            'do_id' => $validatedData['stdcourse'],
            'level' => $validatedData['stdlevel'],
            'lga' => $validatedData['local_gov'],
            'stateor' => $validatedData['state_of_origin'],
            'nationality' => "NIGERIA",
            'admyear' => "2022",
            'stdstatus' => "Undgergraduate",
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student record added!, advise to verify record');
    }

    public function getStudentByMatricNumber(Request $request)
    {
        $matno = $request->query('matno');  // Get the matno from query parameters

        // Fetch student by matriculation number
        $student = Student::where('matric_no', $matno)->first();

        // Return JSON response
        if ($student) {
            return response()->json([
                'success' => true,
                'student' => [
                    'surname' => $student->surname,
                    'firstname' => $student->firstname,
                    'gender' => $student->gender,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ]);
        }
    }

    public function savestudentphoto(Request $request)
    {
        $request->validate([
            'passport' => 'required|image|mimes:jpeg,jpg|max:100', // Max size is 100 KB
        ]);

        $student = Student::find($request->sid);

        if (is_null($student)) {
            return redirect()->route('students.index')
                ->with('error', 'Record not found');
        }

        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $fileName = DATE("dmyHis") . '.' . $file->getClientOriginalExtension();
            $storagePath = '/home/prtald/public_html/eportal/storage/app/public/passport/';

            $file->move($storagePath, $fileName);

            // Update the student's photo path in the database
            // echo $publicUrl = 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/' . $fileName;
            $student->std_photo = $fileName;
            $student->save();
            return back()->with('success', 'Passport updated successfully.');
        }

        return back()->with('error', 'Failed to upload passport.');
    }

    public function viewStudent($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return redirect()->route('students.index')
                ->with('error', 'Record not found');
        }

        $statesOfOrigin = StateOfOrigin::all();
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $courseOfStudy = DeptOption::where(["prog_id" => $student->stdprogramme_id])->get();
        $lgaName = LGA::where('lga_id', $student->local_gov)->value('lga_name');
        $schools = Faculty::all();
        $depts = Department::all();
        $levels = Level::where(["programme_id" => $student->stdprogramme_id])->get();
        $feepayments = StdTransaction::where(['log_id' => $student->std_logid, 'pay_status' => 'Paid'])->get();
        $clearancepayments = CTransaction::where(['matno' => $student->matric_no, 'trans_custom1' => 'Paid'])->get();
        $remedialpayments = RTransaction::where(['matno' => $student->matric_no, 'trans_custom1' => 'Paid'])->get();

        return view('students.viewstudent', compact(
            'student',
            'statesOfOrigin',
            'programmes',
            'programmeTypes',
            'courseOfStudy',
            'lgaName',
            'schools',
            'depts',
            'levels',
            'feepayments',
            'clearancepayments',
            'remedialpayments',
        ));
    }

    public function promotionList(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);
            $matnoIndex = array_search('matno', $headers);
            $levelIndex = array_search('level', $headers);
            if ($matnoIndex === false || $levelIndex === false) {
                return redirect()->back()->withErrors('CSV must contain "matno" and "level" columns.');
            }
            while (($row = fgetcsv($handle)) !== false) {
                $matno = trim(strtoupper($row[$matnoIndex]));
                $level = (int) trim($row[$levelIndex]);
                DB::table('stdpromote_list')->updateOrInsert(
                    ['matno' => $matno],
                    [
                        'level' => $level,
                    ]
                );
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Promotion list uploaded successfully');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }

    public function getcoursereg(Request $request)
    {

        $query = Student::with('programme')->whereHas('courseRegs');

        if ($request->filled('matric_no')) {
            $query->where('matric_no', 'like', '%' . $request->matric_no . '%');
        }
        if ($request->filled('surname')) {
            $query->where('surname', 'like', '%' . $request->surname . '%');
        }

        $userData = session('user_data');
        if ($userData) {
            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
        }
        $cAGroupId = UserController::COURSE_ADVISER_GROUP_ID;
        if ($decryptedUserData['uGroup'] === $cAGroupId) {

            $userData = Users::where([
                'u_group' => $cAGroupId,
                'user_id' => $decryptedUserData['userId']
            ])->first();

            // Check if user data was found
            if ($userData) {
                // Get assigned departments
                $assignedDepts = explode(',', $userData->u_cos ?? '');
                
                $assignedLevels = explode(',', $userData->u_level ?? '');

                // Apply filters to the main query
                $query->whereIn('stddepartment_id', $assignedDepts)
                       ->whereIn('stdlevel', $assignedLevels);
                    
            } else {
                throw new \Exception("User data not found for the given criteria.");
            }
        }

        $programmes = Programme::all();

        $students = $query->paginate(50);

        return view('students.coursereg', compact('students', 'programmes'));
    }

    public function showCourseReg($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return redirect()->route('coursereg')
                ->with('error', 'Record not found');
        }

        // check if student is assigned to the course adviser 
        $userData = session('user_data');
        if ($userData) {
            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
        }
        $cAGroupId = UserController::COURSE_ADVISER_GROUP_ID;
        if ($decryptedUserData['uGroup'] === $cAGroupId) {
            $userAssign = Users::where([
                'u_group' => $cAGroupId,
                'user_id' => $decryptedUserData['userId'],
            ])
                ->whereRaw("FIND_IN_SET(?, u_cos)", [$student->stddepartment_id])
                ->whereRaw("FIND_IN_SET(?, u_level)", [$student->stdlevel])
                ->first();
            if (is_null($userAssign)) {
                return redirect()->route('coursereg')
                    ->with('error', 'You can only access an student information in your assigned department.');
            }
        }
        $currentSession = StdCurrentSession::getStdCurrentSession($student->stdprogramme_id);

        $courseReg = CourseRegistration::where(["log_id" => $student->std_logid, "cyearsession" => $currentSession['cs_session']])->get();

        $firstSemesterCourses = $courseReg->filter(function ($course) {
            return $course->csemester === 'First Semester';
        });

        $secondSemesterCourses = $courseReg->filter(function ($course) {
            return $course->csemester === 'Second Semester';
        });

        return view('students.showcoursereg', compact(
            'student',
            'courseReg',
            'currentSession',
            'firstSemesterCourses',
            'secondSemesterCourses',
        ));
    }

    public function approvecoursereg(Request $request)
    {
        $student = Student::find($request->stdid);

        if (is_null($student)) {
            return redirect()->route('coursereg')
                ->with('error', 'Record not found');
        }

        $currentSession = StdCurrentSession::getStdCurrentSession($student->stdprogramme_id);

        $courseReg = CourseRegistration::where(["log_id" => $student->std_logid, "cyearsession" => $currentSession['cs_session']])->get();

        if ($courseReg->isEmpty()) {
            return redirect()->route('coursereg')
                ->with('error', 'Courses not registered for the session yet');
        }

        CourseRegistration::where([
            "log_id" => $student->std_logid,
            "cyearsession" => $currentSession['cs_session'],
            "csemester" => $request->semester,
        ])->update(['status' => "Approved", 'remark' => 'Courses Approved']);

        return redirect()->back()->with('success', 'Courses for the student approved successfully.');
    }

    public function rejectcoursereg(Request $request)
    {

        $student = Student::find($request->stdid);

        if (is_null($student)) {
            return redirect()->route('coursereg')
                ->with('error', 'Record not found');
        }

        $currentSession = StdCurrentSession::getStdCurrentSession($student->stdprogramme_id);

        $courseReg = CourseRegistration::where(["log_id" => $student->std_logid, "cyearsession" => $currentSession['cs_session']])->get();

        // Check if any courses are found
        if ($courseReg->isEmpty()) {
            return redirect()->route('coursereg')
                ->with('error', 'No courses found for the student in the current session.');
        }

        $request->validate([
            'reject' => 'required|string'
        ]);

        $rejectMsg = ucwords($request->reject);

        CourseRegistration::where([
            "log_id" => $student->std_logid,
            "cyearsession" => $currentSession['cs_session'],
            "csemester" => $request->semester,
        ])->update(['status' => "Rejected", 'remark' => $rejectMsg]);


        return back()->with('error', 'Courses for the student rejected.');
    }

    public function getMatricNoList()
    {
        $stdmatno_list =  DB::table('matcode')->get();
        return view('students.matno_list', compact('stdmatno_list'));
    }

    public function getstudentdata(Request $request)
    {

        $matno = $request->query('matno');

        $student = null;
        $searched = false;

        if ($matno) {
            $searched = true;
            $student = Student::where('matric_no', $matno)->first();
        }

        return view('students.verifystudent', compact('matno', 'student', 'searched'));
    }

    public function downloadPassports(Request $request)
    {
        $baseUrl = 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/';

        try {
            // Set execution time limit
            set_time_limit(120); // 2 minutes, adjust as needed

            // Fetch only the photo field to minimize memory usage
            $students = Student::select('std_photo')
                ->whereNotNull('std_photo') // Skip null photos
                ->get();

            if ($students->isEmpty()) {
                return redirect()->back()->with('error', 'No student photos found.');
            }

            // Define storage paths
            $tempDir = 'temp/passports_' . time(); // Unique temp directory
            Storage::makeDirectory($tempDir);

            $downloadedFiles = [];
            $httpClient = Http::timeout(15); // 15-second timeout per request

            // Process students in chunks of 50
            $students->chunk(50)->each(function ($chunk) use ($httpClient, $baseUrl, $tempDir, &$downloadedFiles) {
                foreach ($chunk as $student) {
                    $fileName = basename($student->std_photo); // Sanitize filename
                    $fileUrl = $baseUrl . $fileName;
                    $filePath = storage_path("app/{$tempDir}/{$fileName}");

                    try {
                        // Download only if not already cached
                        if (!Storage::exists("{$tempDir}/{$fileName}")) {
                            $response = $httpClient->get($fileUrl);

                            if ($response->successful()) {
                                Storage::put("{$tempDir}/{$fileName}", $response->body());
                                $downloadedFiles[] = $filePath;
                            } else {
                                \Log::warning("Failed to download: {$fileName}, Status: {$response->status()}");
                            }
                        } else {
                            $downloadedFiles[] = $filePath;
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error downloading {$fileName}: " . $e->getMessage());
                    }
                }
            });

            // Create ZIP file
            $zipFileName = 'student_passports_' . date('Ymd_His') . '.zip';
            $zipFilePath = storage_path("app/{$tempDir}/{$zipFileName}");

            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('Failed to create ZIP file.');
            }

            foreach ($downloadedFiles as $file) {
                if (file_exists($file)) {
                    $zip->addFile($file, basename($file));
                }
            }

            $zip->close();

            if (!file_exists($zipFilePath)) {
                throw new \Exception('ZIP file was not created.');
            }

            // Return the ZIP file for download and clean up
            return response()->download($zipFilePath, $zipFileName, [
                'Content-Type' => 'application/zip',
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {

            Storage::deleteDirectory($tempDir); // Clean up on failure

            return redirect()->back()
                ->with('error', 'Failed to download passports: ' . $e->getMessage());
        } finally {
            // Clean up temp directory if not deleted after send
            if (Storage::exists($tempDir)) {
                Storage::deleteDirectory($tempDir);
            }
        }
    }

    public function getStudentList(Request $request)
    {
        $prog_id = $request->prog_id;
        $progtype_id = $request->progtype_id;
        $level_id = $request->level_id;
        if ($prog_id == null || $progtype_id == null || $level_id == null) {
            return redirect()->route('students.index')
                ->with('error', 'Please select all fields');
        }
        $request->validate([
            'prog_id' => 'required|integer',
            'progtype_id' => 'required|integer',
            'level_id' => 'required|integer',
        ], [
            'prog_id.required' => 'The Programme field is required.',
            'progtype_id.required' => 'The Programme Type field is required.',
            'level_id.required' => 'The Level field is required.',
        ]);
        $std_lists = Student::where(
            [
                'stdprogramme_id' => $prog_id,
                'stdprogrammetype_id' => $progtype_id,
                'stdlevel' => $level_id,
            ]
        )->orderBy('matric_no', 'asc')
            ->orderBy('stdcourse', 'asc')
            ->get();
        return view('students.std_list', compact('std_lists', 'prog_id', 'progtype_id', 'level_id'));
    }
}
