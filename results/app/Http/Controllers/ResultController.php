<?php

namespace App\Http\Controllers;

use App\Models\Levels;
use App\Models\Courses;
use App\Models\Results;
use App\Models\Student;
use App\Models\Sessions;
use Illuminate\Http\Request;
use App\Imports\ResultsImport;
use App\Models\DepartmentOptions;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $dataToInsert = [
            'course_id' => $data['courses'],
            'coursecode' => $cc[0]->thecourse_code,
            'coursetitle' => $cc[0]->thecourse_title,
            'courseunit' => $cc[0]->thecourse_unit,
            'clevel_id' => $cc[0]->levels,
            'csemester' => $cc[0]->semester,
            'cyearsession' => $data['sess'],
            'course_category' => 'core',
            'cdate_reg' => date('d-M-Y h:i:s'),
            'status' => 1
        ];

        DB::table('course_reg_log')->updateOrInsert(
            [
                'course_id' => $data['courses'],
                'coursecode' => $cc[0]->thecourse_code,
                'clevel_id' => $cc[0]->levels,
                'csemester' => $cc[0]->semester,
                'cyearsession' => $data['sess'],
            ],
            $dataToInsert
        );
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
                DB::raw('COUNT(*) as total_students')
            )
            ->join($coursetable, "$coursetable.thecourse_id", '=', "$resulttable.stdcourse_id")
            ->groupBy(
                "$resulttable.stdcourse_id",
                "$resulttable.course_code",
                "$resulttable.course_title",
                "$resulttable.semester",
                "$resulttable.cyearsession",
                "$resulttable.level_id"
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
                "$resulttable.course_unit"
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

    public function enterCourseResult(Request $request)
    {
        $request->validate([
            'courses' => 'required|integer',
            'clevel' => 'required|integer',
            'courseofstudy' => 'required|integer',
            'semester' => 'required',
            'sess' => 'required|string',
        ]);

        $course = Courses::find($request->courses);
        if (!$course) {
            return back()->withErrors(['courses' => 'Course not found']);
        }

        $students = Student::where('stdlevel', $request->clevel)
            ->where('stdcourse', $request->courseofstudy)
            ->distinct()
            ->pluck('matric_no');

        return view('enter_course_result', [
            'students' => $students,
            'course' => $course,
            'level' => (new Levels)->getLevelName($request->clevel),
            'session' => $request->sess,
            'semester' => $request->semester,
            'courseofstudy' => $request->courseofstudy,
        ]);
    }
}
