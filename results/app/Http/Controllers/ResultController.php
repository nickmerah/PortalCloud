<?php

namespace App\Http\Controllers;

use App\Models\Levels;
use App\Models\Courses;
use App\Models\Results;
use App\Models\Students;
use App\Models\Sessions;
use Illuminate\Http\Request;
use App\Imports\ResultsImport;
use App\Models\DepartmentOptions;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    public const EXAM_TYPE_MAIN = 'main';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function resultupload()
    {
        $courses = Courses::select('thecourse_code', 'thecourse_id')->orderBy('thecourse_code', 'asc')->get();
        $sess =  Sessions::select('cs_session')->get();
        $levels =  Levels::select('level_id', 'level_name')->orderBy('level_id', 'asc')->get();
        $courseofstudy = DepartmentOptions::select('do_id', 'programme_option', 'prog_id')
            ->orderBy('programme_option', 'asc')
            ->get();

        return view('uploadresults', ['courses' => $courses, 'sess' => $sess[0]->cs_session, 'levels' => $levels, 'courseofstudy' => $courseofstudy]);
    }

    public function getCourseData(Request $request)
    {
        $request->validate([
            'level_id' => 'required|integer',
            'semester' => 'required',
            'cos_id' => 'required|integer',
        ]);

        $courses = Courses::where('levels', $request->level_id)
            ->where('semester', $request->semester)
            ->where('stdcourse', $request->cos_id)
            ->orderBy('thecourse_code', 'asc')
            ->get(['thecourse_id', 'thecourse_code']);
        return response()->json($courses);
    }

    public function getCourseofStudyData(Request $request)
    {
        $levelId = $request->level_id;
        $level = Levels::find($levelId);
        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }
        $progId = $level->programme_id;
        $courseofstudy = DepartmentOptions::where('prog_id', $progId)
            ->orderBy('programme_option', 'asc')
            ->get(['do_id', 'programme_option']);

        return response()->json($courseofstudy);
    }

    public function importResult(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls',
        ], [
            'file.mimes' => 'The file must be a .xls Excel file.',
        ]);

        $data = $request->input();
        $cc = Courses::where('thecourse_id', $data['courses'])->select('thecourse_code', 'thecourse_title', 'thecourse_unit', 'semester', 'levels')->get();

        self::registerOrUpdateCourseRegLog($cc, $request);

        try {
            Excel::import(new ResultsImport, $request->file('file'));
            return back()->with('success', 'Results Imported Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    public function uploadedresult()
    {
        $resulttable = (new Results)->getTable();
        $coursetable = (new Courses)->getTable();
        $sess =  Sessions::select('cs_session')->get();
        $results = Results::where('cyearsession', $sess[0]->cs_session)
            ->select(
                "$resulttable.stdcourse_id",
                "$resulttable.course_code",
                "$resulttable.course_title",
                "$resulttable.semester",
                "$resulttable.cyearsession",
                "$resulttable.level_id",
                "$resulttable.cos",
                DB::raw('COUNT(*) as total_students')
            )
            ->join($coursetable, "$coursetable.thecourse_id", '=', "$resulttable.stdcourse_id")
            ->groupBy(
                "$resulttable.stdcourse_id",
                "$resulttable.course_code",
                "$resulttable.course_title",
                "$resulttable.semester",
                "$resulttable.cyearsession",
                "$resulttable.level_id",
                "$resulttable.cos",
            )
            ->get();

        return view('uploadedresults', ['results' => $results])->with('success', 'Results Fetched Successfully');
    }

    public function viewCourseResult($cid, $level, $session, $semester)
    {
        $sem = $semester == 1 ? 'First Semester' : 'Second Semester';
        $resulttable = (new Results)->getTable();
        $coursetable = (new Courses)->getTable();
        $results = Results::where('cyearsession', $session)
            ->where("$resulttable.stdcourse_id", $cid)
            ->where("$resulttable.level_id", $level)
            ->where("$resulttable.semester", $sem)
            ->select(
                "$resulttable.matric_no",
                "$resulttable.std_mark",
                "$resulttable.std_rstatus",
                "$resulttable.cat",
                "$resulttable.exam",
                "$resulttable.course_code",
                "$resulttable.course_title",
                "$resulttable.course_unit",
            )
            ->join($coursetable, "$coursetable.thecourse_id", '=', "$resulttable.stdcourse_id")
            ->orderBy("$resulttable.matric_no", 'asc')
            ->get();

        return view('viewcourse_result', [
            'results' => $results,
            'coursetitle' => $cid,
            'level' => (new Levels)->getLevelName($level),
            'session' => $session,
            'semester' => $sem,
            'success' => 'Results Fetched Successfully'
        ]);
    }

    public function deleteCourseResult($cid, $level, $session, $semester)
    {
        $sem = $semester == 1 ? 'First Semester' : 'Second Semester';
        Results::where('cyearsession', $session)
            ->where("stdcourse_id", $cid)
            ->where("level_id", $level)
            ->where("semester", $sem)
            ->delete();

        return redirect()->route('uploadedresult')->with('success', 'Results Deleted Successfully');
    }

    public function manualupload()
    {
        $courses = Courses::select('thecourse_code', 'thecourse_id')->orderBy('thecourse_code', 'asc')->get();
        $sess =  Sessions::select('cs_session')->get();
        $levels =  Levels::select('level_id', 'level_name')->orderBy('level_id', 'asc')->get();
        $courseofstudy = DepartmentOptions::select('do_id', 'programme_option', 'prog_id')
            ->orderBy('programme_option', 'asc')
            ->get();

        return view('manualupload', ['courses' => $courses, 'sess' => $sess[0]->cs_session, 'levels' => $levels, 'courseofstudy' => $courseofstudy]);
    }

    public function prepareResult(Request $request)
    {
        $request->validate([
            'sess' => 'required|numeric',
            'clevel' => 'required|numeric',
            'semester' => 'required|string',
            'courses' => 'required|numeric',
            'courseofstudy' => 'required|numeric',
        ]);

        $sem = $request->semester == 'First Semester' ? 1 : 2;

        return redirect()->route('enterResult', [
            'cid' => $request->courses,
            'level' => $request->clevel,
            'session' => $request->sess,
            'semester' => $sem,
            'cos' => $request->courseofstudy,
        ]);
    }

    public function enterCourseResult($cid, $level, $session, $semester, $cos)
    {
        $sem = $semester == 1 ? 'First Semester' : 'Second Semester';
        $course = Courses::find($cid);
        if (!$course) {
            return back()->withErrors(['courses' => 'Course not found']);
        }

        if ($level == '' || $session == '' || $semester == '' || $cos == '') {
            return back()->withErrors(['level' => 'Please select a level, session, semester, and course of study']);
        }

        $students = Students::where('stdlevel', $level)
            ->where('stdcourse', $cos)
            ->distinct()
            ->pluck('matric_no');

        $existingResults = Results::where('stdcourse_id', $cid)
            ->where('level_id', $level)
            ->where('cyearsession', $session)
            ->where('semester', $sem)
            ->whereIn('matric_no', $students)
            ->get(['matric_no', 'std_mark', 'cat', 'exam', 'std_rstatus'])
            ->keyBy('matric_no');


        return view('enter_course_result', [
            'students' => $students,
            'course' => $course,
            'level' => (new Levels)->getLevelName($level),
            'session' => $session,
            'semester' => $sem,
            'courseofstudy' => $cos,
            'levelid' => $level,
            'existingResults' => $existingResults,
        ]);
    }

    public function saveCourseResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat' => 'required|array',
            'cat.*' => 'required|numeric',
            'exam' => 'required|array',
            'exam.*' => 'required|numeric',
            'courses' => 'required',
            'sem' => 'required|string',
            'sess' => 'required|numeric',
            'levelid' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $course = json_decode($request->courses, true);

        self::registerOrUpdateCourseRegLog($course, $request);

        foreach ($request->cat as $matricNo => $catScore) {
            $examScore = $request->exam[$matricNo] ?? 0; // fallback in case exam score is missing
            $score = $catScore + $examScore;
            Results::updateOrCreate(
                [
                    'matric_no' => $matricNo,
                    'level_id' => $request->levelid,
                    'stdcourse_id' => $course['thecourse_id'],
                    'cyearsession' => $request->sess,
                    'semester' => $request->sem,
                    'cos' => $request->courseofstudy,
                ],
                [
                    'std_mark' => $score,
                    'std_rstatus' => Results::getGradeAndPoint($score)['grade'],
                    'cat' => $catScore,
                    'exam' => $examScore,
                    'course_code' => $course['thecourse_code'],
                    'course_title' => $course['thecourse_title'],
                    'course_unit' => $course['thecourse_unit'],
                ]
            );
        }

        return redirect()->to(url()->previous())->with('success', 'Results Saved Successfully');
    }

    public function resultssummary()
    {
        $sess =  Sessions::select('cs_session')->get();
        $levels =  Levels::select('level_id', 'level_name')->orderBy('level_id', 'asc')->get();
        $courseofstudy = DepartmentOptions::select('do_id', 'programme_option', 'prog_id')
            ->orderBy('programme_option', 'asc')
            ->get();

        return view('resultssummary', ['sess' => $sess[0]->cs_session, 'levels' => $levels, 'courseofstudy' => $courseofstudy]);
    }

    public function viewResult(Request $request)
    {
        $request->validate([
            'sess' => 'required|numeric',
            'clevel' => 'required|numeric',
            'semester' => 'required|string',
            'courseofstudy' => 'required|numeric',
        ]);

        $sem = $request->semester == 'First Semester' ? 1 : 2;

        return redirect()->route('resultSummary', [
            'level' => $request->clevel,
            'session' => $request->sess,
            'semester' => $sem,
            'cos' => $request->courseofstudy,
        ]);
    }

    public function viewResultSummary($level, $session, $semester, $cos, $mode = 'view')
    {
        $sem = $semester == 1 ? 'First Semester' : 'Second Semester';
        $resulttable = (new Results)->getTable();
        $studenttable = (new Students)->getTable();

        $courseofstudy = DepartmentOptions::with(['programme', 'department.faculty'])
            ->where('do_id', $cos)
            ->select('do_id', 'programme_option', 'prog_id', 'dept_id')
            ->orderBy('programme_option', 'asc')
            ->get();

        $results = Results::distinct()
            ->where('cyearsession', $session)
            ->where("$resulttable.level_id", $level)
            ->where("$resulttable.semester", $sem)
            ->where("$resulttable.cos", $cos)
            ->select(
                "$resulttable.matric_no",
                "$resulttable.level_id",
                DB::raw("CONCAT($studenttable.surname, ' ', $studenttable.firstname, ' ', $studenttable.othernames) AS fullnames")
            )
            ->join($studenttable, "$studenttable.matric_no", '=', "$resulttable.matric_no")
            ->orderBy("$resulttable.matric_no", 'asc')
            ->get();

        $courselogs = DB::table('course_reg_log')
            ->where('clevel_id', $level)
            ->where('cyearsession', $session)
            ->select('coursecode', 'coursetitle', 'courseunit', 'course_id', 'clevel_id', 'cyearsession')
            ->get();

        $courses = $courselogs->sortBy('course_id')->values();

        if ($courses->isEmpty()) {
            return redirect("resultsummary")->withErrors("Oops! Result for {$level}00 Level, {$session}/" . ($session + 1) . " Session for {$sem} examination is not uploaded");
        }

        $results = $this->computeResultsWithMarks($results, $courses, $session);

        $colspan = count($courses) + 8;

        $view = ($mode === 'print') ?  'printsummary_result' : 'viewsummary_result';

        return view($view, [
            'results' => $results,
            'level' => (new Levels)->getLevelName($level),
            'session' => $session,
            'semester' => $sem,
            'courseofstudy' => $courseofstudy,
            'courses' => $courses,
            'colspan' => $colspan,
            'success' => 'Results Fetched Successfully'
        ]);
    }



    private static function registerOrUpdateCourseRegLog(array $course, $request)
    {
        $dataToInsert = [
            'course_id'       => $course['thecourse_id'],
            'coursecode'      => $course['thecourse_code'],
            'coursetitle'     => $course['thecourse_title'],
            'courseunit'      => $course['thecourse_unit'],
            'clevel_id'       => $request->levelid,
            'csemester'       => $request->sem,
            'cyearsession'    => $request->sess,
            'course_category' => 'core',
            'cdate_reg'       => date('d-M-Y h:i:s'),
            'status'          => 1,
        ];

        DB::table('course_reg_log')->updateOrInsert(
            [
                'course_id'    => $course['thecourse_id'],
                'coursecode'   => $course['thecourse_code'],
                'clevel_id'    => $request->levelid,
                'csemester'    => $request->sem,
                'cyearsession' => $request->sess,
            ],
            $dataToInsert
        );
    }

    private function computeResultsWithMarks($results, $courses, $session)
    {
        return $results->transform(function ($result) use ($courses, $session) {
            $marks = [];
            $totalUnit = 0;
            $tgp = 0;
            $countFail = 0;

            foreach ($courses as $course) {
                $data = Results::getMarkAndGrade($session, $result->matric_no, $result->level_id, $course->course_id);
                $marks[$course->course_id] = $data;

                if ($data) {
                    $unit = (int) $course->courseunit;
                    $totalUnit += $unit;

                    $gp = Results::getGradeAndPoint($data->std_mark ?? 0);
                    $tgp += $gp['point'] * $unit;

                    if (($data->std_rstatus ?? '') === 'F') {
                        $countFail++;
                    }
                }
            }

            $gpa = $totalUnit > 0 ? round($tgp / $totalUnit, 2) : 0;
            $status = $countFail === 0 ? 'Pass' : $countFail . 'F';

            $result->course_marks = $marks;
            $result->total_unit = $totalUnit;
            $result->tgp = $tgp;
            $result->gpa = $gpa;
            $result->status = $status;

            return $result;
        });
    }
}
