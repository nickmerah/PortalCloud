<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Lga;
use App\Models\Users;
use App\Models\Student;
use App\Models\Applicant;
use App\Models\Programme;
use App\Models\Department;
use App\Models\DeptOption;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProgrammeType;
use App\Models\StateOfOrigin;
use App\Models\AppTransaction;
use App\Models\AdmittedApplicants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use Illuminate\Support\Facades\File;

class ApplicantController extends Controller
{
    protected $baseUrl = 'https://portal.mydspg.edu.ng/admissions/writable/thumbs/';

    public function index(Request $request)
    {
        $query = Applicant::with('programme', 'stdcourseOption');

        if ($request->filled('matric_no')) {
            $query->where('app_no', 'like', '%' . $request->matric_no . '%');
        }
        if ($request->filled('surname')) {
            $query->where('surname', 'like', '%' . $request->surname . '%');
        }

        // Filter by current session
        $query->whereHas('currentSession', function ($query) {
            $query->where('status', 'current');
        });

        $userData = session('user_data');
        if ($userData) {
            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
        }
        $clearanceGroupId = UserController::CLEARANCE_GROUP_ID;
        if ($decryptedUserData['uGroup'] === $clearanceGroupId) {
            $query->where('adm_status', 1);

            $userData = Users::where([
                'u_group' => $clearanceGroupId,
                'user_id' => $decryptedUserData['userId']
            ])->first();

            // Check if user data was found
            if ($userData) {
                // Get assigned departments
                $assignedDepts = explode(',', $userData->u_dept ?? '');

                // Get assigned program type
                $assignedProgtype = $userData->u_progtype ?? '';

                // Get assigned programme
                $assignedProg = $userData->u_prog ?? '';

                // Apply filters to the main query
                $query->whereIn('stdcourse', $assignedDepts)
                    ->where('std_programmetype', $assignedProgtype);
                //  ->where('stdprogramme_id', $assignedProg);
            } else {
                throw new \Exception("User data not found for the given criteria.");
            }
        }

        $programmes = Programme::all();

        $applicants = $query->paginate(100);

        return view('applicants.start', compact('applicants', 'programmes'));
    }

    public function show($id)
    {
        $applicant = Applicant::find($id);
        if (is_null($applicant)) {
            return redirect()->route('applicants.index')
                ->with('error', 'Record not found');
        }

        // check if applicant is assigned to the clearance officer 
        $userData = session('user_data');
        if ($userData) {
            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
        }
        $clearanceGroupId = UserController::CLEARANCE_GROUP_ID;
        if ($decryptedUserData['uGroup'] === $clearanceGroupId) {
            $userAssign = Users::where([
                'u_group' => $clearanceGroupId,
                'user_id' => $decryptedUserData['userId'],
                'u_prog' => $applicant->stdprogramme_id,
                'u_progtype' => $applicant->std_programmetype,
            ])
                ->whereRaw("FIND_IN_SET(?, u_dept)", [$applicant->stdcourse])
                ->first();
            if (is_null($userAssign)) {
                return redirect()->route('applicants.index')
                    ->with('error', 'You can only access an applicant information in your assigned department.');
            }
        }

        $statesOfOrigin = StateOfOrigin::all();
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $courseOfStudy = DeptOption::where(["prog_id" => $applicant->stdprogramme_id])->get();
        $olevels  = DB::table('jolevels')->where(["std_id" => $applicant->std_logid])->get();
        $schools = DB::table('jeduhistory')
            ->join('polytechnics', 'jeduhistory.schoolname', '=', 'polytechnics.pid')
            ->join('dept_options', 'jeduhistory.cos', '=', 'dept_options.do_id')
            ->where('jeduhistory.std_id', $applicant->std_logid)->get();
        $jambdetails = DB::table('jamb')->where(["std_id" => $applicant->std_logid])->get();
        $lgaName = LGA::where('lga_id', $applicant->local_gov)->value('lga_name');
        $certificates = DB::table('jcertificates')->where(["stdid" => $applicant->std_logid])->get();
        $transactions = AppTransaction::where(["log_id" => $applicant->std_logid, 'trans_custom1' => 'Paid'])->get();

        return view('applicants.show', compact(
            'applicant',
            'statesOfOrigin',
            'programmes',
            'programmeTypes',
            'courseOfStudy',
            'lgaName',
            'olevels',
            'schools',
            'jambdetails',
            'certificates',
            'transactions',
        ));
    }

    public function edit($id)
    {
        $applicant = Applicant::find($id);
        if (is_null($applicant)) {
            return redirect()->route('applicants.index')
                ->with('error', 'Record not found');
        }
        return view('applicants.edit', compact('applicant'));
    }

    public function update(Request $request)
    {

        $request->validate([
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
            'stdcourse' => 'required|integer',
            'std_course' => 'required|integer',
            'marital_status' => 'required|string|max:10',
            'local_gov' => 'required|integer',
            'state_of_origin' => 'required|integer',
            'std_programmetype' => 'required|integer',
        ], [
            'surname.required' => 'The surname field is required.',
            'surname.string' => 'The surname must be a string.',
            'surname.max' => 'The surname may not be greater than 150 characters.',

            'firstname.required' => 'The firstname field is required.',
            'firstname.string' => 'The firstname must be a string.',
            'firstname.max' => 'The firstname may not be greater than 150 characters.',

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

            'stdcourse.required' => 'The course field is required.',
            'stdcourse.integer' => 'The course must be an integer.',

            'std_course.required' => 'The course field is required.',
            'std_course.integer' => 'The course must be an integer.',

            'marital_status.required' => 'The marital status field is required.',
            'marital_status.string' => 'The marital status must be a string.',
            'marital_status.max' => 'The marital status may not be greater than 10 characters.',

            'local_gov.required' => 'The local government field is required.',
            'local_gov.integer' => 'The local government must be an integer.',

            'std_programmetype.required' => 'The programme type field is required.',
            'std_programmetype.integer' => 'The programme type must be an integer.',

            'state_of_origin.required' => 'The state of origin field is required.',
            'state_of_origin.integer' => 'The state of origin must be an integer.',
        ]);


        $applicant = Applicant::find($request->appid);

        if (is_null($applicant)) {
            return redirect()->route('applicants.index')
                ->with('error', 'Record not found');
        }
        $applicant->update($request->all());

        return redirect()->intended('applicants/' . $request->appid);
    }

    public function getLgas($id)
    {

        $lgas = Lga::where('state_id', $id)->pluck('lga_name', 'lga_id');

        return response()->json($lgas);
    }

    public function applicantspwd(Request $request)
    {
        $query = Applicant::with('programme');

        if ($request->filled('matric_no')) {
            $query->where('app_no', 'like', '%' . $request->matric_no . '%');
        }
        if ($request->filled('surname')) {
            $query->where('surname', 'like', '%' . $request->surname . '%');
        }

        // Filter by current session
        $query->whereHas('currentSession', function ($query) {
            $query->where('status', 'current');
        });

        $applicants = $query->paginate(50);

        foreach ($applicants as $applicant) {
            $applicant->log_status = Applicant::getApplicantLogStatusByLogId($applicant->std_logid)->log_status;
        }

        return view('applicants.pwdchange', compact('applicants'));
    }

    public function applicantspwdreset($id)
    {
        $applicant = Applicant::find($id);

        if (is_null($applicant)) {
            return redirect()->route('applicants.applicantspwdreset')
                ->with('error', 'Record not found');
        }

        $passes = rand(00000, 99999);

        $hashedPassword = password_hash($passes, PASSWORD_BCRYPT);

        DB::table('jlogin')
            ->where('log_id', $id)
            ->update(['log_password' => $hashedPassword, 'log_status' => 1]);

        return redirect()->route('applicantspwd')
            ->with('success', "Password successful change to  $passes");
    }

    public function applicantDisableAccount($id)
    {
        $applicant = Applicant::find($id);

        if (is_null($applicant)) {
            return redirect()->route('applicants.applicantspwdreset')
                ->with('error', 'Record not found');
        }

        DB::table('jlogin')
            ->where('log_id', $id)
            ->update(['log_status' => 0]);

        return redirect()->route('applicantspwd')
            ->with('success', "Account successful Disabled");
    }

    public function subjects()
    {
        $subjects =  DB::table('subjects')->get();
        return view('applicants.subjects', compact('subjects'));
    }

    public function applicantphotoupdate(Request $request)
    {
        $request->validate([
            'sid' => 'required|string'
        ]);

        $applicant = Applicant::find($request->sid);

        if ($applicant->std_photo == 'avatar.jpg') {
            return redirect()->route('applicants.index')
                ->with('error', "Applicant have no passport uploaded.");
        }


        $applicant->std_photo = 'avatar.jpg';
        $applicant->save();


        return redirect()->route('applicants.index')
            ->with('success', "Applicant Upload Request successful.");
    }

    public function downloadPassports(Request $request)
    {
        // Set a reasonable time limit
        set_time_limit(0);  // Increase this limit if needed

        $applicants = Applicant::where(
            [
                'std_custome9' => 1,
                'stdprogramme_id' => $request->prog_id,
                'std_programmetype' => $request->progtype_id
            ]
        )->get();

        $saveDir = 'passports/';
        $publicPath = public_path($saveDir);

        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        $downloadedFiles = [];
        $batchSize = 100;  // Number of images to process per batch
        $applicantChunks = $applicants->chunk($batchSize);  // Split applicants into batches

        foreach ($applicantChunks as $applicantBatch) {
            foreach ($applicantBatch as $applicant) {
                $fileName = $applicant->std_photo;
                $fileUrl = $this->baseUrl . $fileName;

                $response = Http::get($fileUrl);

                if ($response->successful()) {
                    $filePath = $publicPath . $fileName;
                    file_put_contents($filePath, $response->body());
                    $downloadedFiles[] = $filePath;
                } else {
                    echo "Failed to download: $fileName\n";
                }
            }
        }

        $tempDir = public_path('tmp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $zipFileName = 'passports.zip';
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($downloadedFiles as $file) {
                if (file_exists($file)) {
                    $fileNameInZip = basename($file);
                    $zip->addFile($file, $fileNameInZip);
                } else {
                    echo "File does not exist: $file\n";
                }
            }
            $zip->close();
        } else {
            return response()->json(['message' => 'Could not create ZIP file'], 500);
        }

        if (!file_exists($zipFilePath)) {
            return response()->json(['message' => 'ZIP file was not created'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);

        return redirect()->route('applicants.index')
            ->with('success', "Passport Downloaded successful.");
    }

    public function admitApplicant(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);
            $appnoIndex = array_search('appno', $headers);
            $courseIndex = array_search('course', $headers);
            if ($appnoIndex === false || $courseIndex === false) {
                return redirect()->back()->withErrors('CSV must contain "appno" and "course" columns.');
            }
            DB::table('admittedapplicants')->delete();
            while (($row = fgetcsv($handle)) !== false) {
                $appno = trim(strtoupper($row[$appnoIndex]));
                $course = trim($row[$courseIndex]);
                DB::table('admittedapplicants')->updateOrInsert(
                    ['appno' => $appno],
                    [
                        'course' => $course,
                        'status' => 0
                    ]
                );
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Admission list uploaded successfully, View the list to Admit!');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }

    public function admissionlist()
    {
        $admitted = AdmittedApplicants::with(['applicant.deptOption'])
            ->whereHas('applicant', function ($query) {
                $query->where('adm_status', 0);
            })
            ->get();
        $courses = DeptOption::all();
        return view('applicants.admissionlist', compact('admitted', 'courses'));
    }

    public function admitapplicants(Request $request)
    {
        $action = $request->input('action');

        if ($action === 'admit') {

            if ($request->has('hidden_field') && $request->has('cosId')) {
                $successfulUpdates = [];

                foreach ($request->input('hidden_field') as $appno) {
                    $courseId = $request->input('cosId')[$appno];
                    $updateStatus = Applicant::where(['app_no' => $appno, 'std_custome9' => 1])
                        ->update(['adm_status' => 1, 'stdcourse' => $courseId]);


                    if ($updateStatus) {
                        $successfulUpdates[] = $appno;
                    }
                }



                if (!empty($successfulUpdates)) {
                    AdmittedApplicants::whereIn('appno', $successfulUpdates)
                        ->update(['status' => 1]);
                }

                return redirect()->back()->with('success', 'Applicants and Admitted Applicants updated successfully!');
            }
        } elseif ($action === 'resolve_errors') {

            if ($request->has('appno') && $request->has('cosId') && $request->has('cos')) {
                $updatedCourses = [];

                foreach ($request->input('appno') as $appno) {
                    $courseId = $request->input('cosId')[$appno];
                    $course = $request->input('cos')[$appno];
                    $updateStatus = Applicant::where('app_no', $appno)
                        ->update(['stdcourse' => $courseId]);

                    AdmittedApplicants::where('appno', $appno)
                        ->update(['course' => $course]);

                    if ($updateStatus) {
                        $updatedCourses[] = $appno;
                    }
                }
                if (!empty($updatedCourses)) {
                    return redirect()->back()->with('success', 'Successfully resolved errors and updated courses for applicants.');
                } else {
                    return redirect()->back()->withErrors('No courses were updated.');
                }
            }
        }

        return redirect()->back()->withErrors('No applicants to update.');
    }

    public function clear(Request $request)
    {

        $applicant = Applicant::find($request->appid);

        if (is_null($applicant)) {
            return redirect()->route('applicants.index')
                ->with('error', 'Record not found');
        }

        if (is_null($applicant->adm_status != 1)) {
            return redirect()->route('applicants.index')
                ->with('error', 'Applicant not yet Admitted');
        }

        // get the last record of student id
        $lastStudentId = Applicant::whereNotNull('student_id')
            ->whereRaw("student_id REGEXP '^P[0-9]+$'")
            ->orderByRaw("CAST(SUBSTRING(student_id, 2) AS UNSIGNED) DESC")
            ->first();

        if ($lastStudentId) {
            // Extract numeric part, increment, and format back with prefix
            $numericPart = (int) substr($lastStudentId->student_id, 1); // Remove 'P'
            $newStudentId = 'P' . str_pad($numericPart + 1, 7, '0', STR_PAD_LEFT);
        }

        if ($lastStudentId) {
            // Extract numeric part, increment, and format with prefix
            $numericPart = (int) substr($lastStudentId->student_id, 1); // Remove 'P'
            $newStudentId = 'P' . str_pad($numericPart + 1, 7, '0', STR_PAD_LEFT);

            // Ensure the generated student_id is unique
            while (Applicant::where('student_id', $newStudentId)->exists()) {
                $numericPart++; // Increment if it already exists
                $newStudentId = 'P' . str_pad($numericPart, 7, '0', STR_PAD_LEFT);
            }
        }

        if (!self::migrateApplicant($applicant->app_no, $newStudentId)) {
            //since we cannot migrate, don't clear applicant
            return redirect()->back()->with('error', 'Error Clearing and Migrating Applicant');
        }

        // Update the applicant record
        $applicant->update(['eclearance' => 1, 'student_id' => $newStudentId]);

        return redirect()->back()->with('success', 'Applicant migrated successfully.');
    }

    public function reject(Request $request)
    {

        $applicant = Applicant::find($request->appid);

        if (is_null($applicant)) {
            return redirect()->route('applicants.index')
                ->with('error', 'Record not found');
        }

        $studentLogin = DB::table('stdlogin')->where(['log_username' => $applicant->app_no])->first();

        if ($studentLogin) {
            return redirect()->route('applicants.index')
                ->with('error', 'Applcant already migrated, can no longer be rejected');
        }

        $request->validate([
            'reject' => 'required|string'
        ]);
        $rejectMsg = ucwords($request->reject);

        $applicant->update(['eclearance' => -1, 'reject' => $rejectMsg]);

        return redirect()->back()->with('success', 'Applicant status updated successfully.');
    }

    public function migrateApplicant(string $matno, string $newStudentId): bool
    {
        $matricNo = $matno;

        $applicantProfile = Applicant::where(['app_no' => $matricNo, 'adm_status' => 1])->first();

        if (!$applicantProfile) {
            return false;
        }

        $studentProfile = Student::where(['matric_no' => $matricNo])->first();

        if ($studentProfile) {
            return true;
        }

        $applicantLogin = DB::table('jlogin')->where(['log_username' => $matricNo])->first();

        try {

            $loginData = [
                'log_surname' => $applicantLogin->log_surname,
                'log_firstname' => $applicantLogin->log_firstname,
                'log_othernames' => $applicantLogin->log_othernames,
                'log_username' => $applicantLogin->log_username,
                'log_email' => $applicantLogin->log_email,
                'log_password' => $applicantLogin->log_password,
                'log_spassword' => Hash::make(strtolower($applicantLogin->log_surname)),
                'token' => Str::random(60),
                'token_expires_at' => now()->addHour(),
            ];


            $loginId = DB::table('stdlogin')->insertGetId($loginData);

            $nullable = '';
            $deptId = DeptOption::where('do_id', $applicantProfile->stdcourse)->value('dept_id') ?? 0;
            $facId = Department::where('departments_id', $deptId)->value('fac_id') ?? 0;

            $studentData = [

                'std_logid' => $loginId,
                'matric_no' => $applicantProfile->app_no,
                'surname'  => $applicantProfile->surname,
                'firstname' => $applicantProfile->firstname,
                'othernames' => $applicantProfile->othernames,
                'gender' => $applicantProfile->gender,
                'marital_status' => $applicantProfile->marital_status,
                'birthdate' => $this->isValidDate($applicantProfile->birthdate) ? $applicantProfile->birthdate : null,
                'matset' => $nullable,
                'local_gov' => $this->isValidInteger($applicantProfile->local_gov) ? $applicantProfile->local_gov : 0,
                'state_of_origin' => $this->isValidInteger($applicantProfile->state_of_origin) ? $applicantProfile->state_of_origin : 0,
                'religion' => $nullable,
                'nationality' => $applicantProfile->nationality ?? $nullable,
                'contact_address' => $applicantProfile->contact_address ?? $nullable,
                'student_email' => $applicantProfile->student_email ?? $nullable,
                'student_homeaddress' => $applicantProfile->student_homeaddress ?? $nullable,
                'student_mobiletel' => $applicantProfile->student_mobiletel ?? $nullable,
                'std_genotype' => $nullable,
                'std_bloodgrp' => $nullable,
                'std_pc' => $nullable,
                'next_of_kin' => $applicantProfile->next_of_kin ?? $nullable,
                'nok_address' => $applicantProfile->nok_address ?? $nullable,
                'nok_tel' => $applicantProfile->nok_tel ?? $nullable,
                'stdprogramme_id' => $applicantProfile->stdprogramme_id ?? 0,
                'stdprogrammetype_id' => $applicantProfile->std_programmetype ?? 0,
                'stdfaculty_id' => $facId ?? 0,
                'stddepartment_id' => $deptId ?? 0,
                'stdcourse' => $applicantProfile->stdcourse ?? 0,
                'stdlevel' => $applicantProfile->stdprogramme_id == 1 ? 1 : 3,
                'std_admyear' => $applicantProfile->appyear ?? date('Y'),
                'std_photo' => $applicantProfile->std_photo,
                'std_status' => 'New',
                'cs_status' => $newStudentId,
                'student_status' => 'Undgergraduate',
                'promote_status' => 0
            ];

            Student::create($studentData);

            //Attempt to copy image 
            self::copyImageToStorage($applicantProfile->std_photo);

            return true;
        } catch (\Exception $e) {

            return false;
        }
    }

    private function isValidDate($date, $format = 'Y-m-d')
    {
        // Check if the date is empty or not a valid date
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    private function isValidInteger($value)
    {
        // Check if the value is a valid integer
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    private function copyImageToStorage(string $fileName): void
    {
        $sourcePath = "/home/prtald/public_html/admissions/writable/thumbs/$fileName";

        $destinationPath = "/home/prtald/public_html/eportal/storage/app/public/passport/$fileName";
        if (File::exists($sourcePath)) {
            File::copy($sourcePath, $destinationPath);
        }
    }

    public function getAdmittedApplicants()
    {
        $admitted = Applicant::with('deptOption')
            ->where('adm_status', 1)
            ->get();

        $programmes = Programme::all();
        $courseofstudy = DeptOption::all();
        return view('applicants.admittedlist', compact('admitted', 'programmes', 'courseofstudy'));
    }

    public function updateAdmissionDepartment(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);
            $appnoIndex = array_search('appno', $headers);
            if ($appnoIndex === false) {
                return redirect()->back()->withErrors('CSV must contain "appno" column.');
            }
            DB::table('admittedapplicants')->delete();
            while (($row = fgetcsv($handle)) !== false) {
                $appno = trim(strtoupper($row[$appnoIndex]));
                $course = $request->cos;
                Applicant::where([
                    "app_no" => $appno,
                    "adm_status" => 1,
                ])->update(['stdcourse' => $course]);
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Applicants Course of Study Updated successfully.');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }
}
