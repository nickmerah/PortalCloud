<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use App\Models\Programme;
use App\Models\DeptOption;
use Illuminate\Http\Request;
use App\Models\ProgrammeType;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $levels = Level::all();
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();
        $courseofstudy = DeptOption::all();
        $query = Course::with('programme', 'programmeType', 'level', 'deptOption');

        if ($request->filled('level_id')) {
            $query->where('levels', 'like', '%' . $request->level_id . '%');
        }
        if ($request->filled('programmet_id')) {
            $query->where('prog_type', 'like', '%' . $request->programmet_id . '%');
        }
        if ($request->filled('programme_id')) {
            $query->where('prog', 'like', '%' . $request->programme_id . '%');
        }
        if ($request->filled('cos')) {
            $query->where('stdcourse', 'like', '%' . $request->cos . '%');
        }


        $courses = $query->paginate(100);

        return view('courses.start', compact('courses', 'levels', 'programmes', 'programmeTypes', 'courseofstudy'));
    }


    public function create()
    {
        return view('courses.index');
    }

    public function show(string $id)
    {
        $courses = Course::findOrFail($id);
        if (is_null($courses)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $courses]);
    }

    public function update(Request $request, string $id)
    {

        $request->validate([
            'ctitle' => 'required|string',
            'ccode' => 'required|string',
            'cunit' => 'required|integer',
            'level_id' => 'required|integer',
            'programme_id' => 'required|integer',
            'programmet_id' => 'required|integer',
            'cos' => 'required|integer',
            'semester' => 'required|string',
        ], [
            'ctitle.required' => 'The course title is required.',
            'ccode.required' => 'The course code is required.',
            'cunit.required' => 'The course unit is required.',
            'level_id.required' => 'The level is required.',
            'programme_id.required' => 'The programme is required.',
            'programmet_id.required' => 'The programme type is required.',
            'cos.required' => 'The course of study is required.',
            'semester.required' => 'The semester is required.',
        ]);

        $existingCourse = Course::where('thecourse_code', $request->ccode)
            ->where('prog', $request->programme_id)
            ->where('stdcourse', $request->cos)
            ->where('prog_type', $request->programmet_id)
            ->where('thecourse_id', '<>', $id)
            ->first();

        if ($existingCourse) {
            return redirect()->back()
                ->withErrors(['ccode' => 'This Course Code already exists for the selected programme.'])
                ->withInput();
        }


        Course::where('thecourse_id', $id)->update([
            'thecourse_title' => strtoupper($request->ctitle),
            'thecourse_code' => strtoupper($request->ccode),
            'thecourse_unit' => (int) $request->cunit,
            'prog' => $request->programme_id,
            'prog_type' => $request->programmet_id,
            'levels' => $request->level_id,
            'semester' => $request->semester,
            'stdcourse' => $request->cos,
        ]);
        return redirect()->back()->with('success', 'Course  updated successfully!');
    }

    public function addCourse(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv|max:2048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);
            $ccodeIndex = array_search('code', $headers);
            $ctitleIndex = array_search('title', $headers);
            $cunitIndex = array_search('unit', $headers);
            $csemesterIndex = array_search('semester', $headers);
            if ($ccodeIndex === false || $ctitleIndex === false || $cunitIndex === false || $csemesterIndex === false) {
                return redirect()->back()->withErrors('CSV must contain "code" and "title" and "unit" and "semester" columns.');
            }

            while (($row = fgetcsv($handle)) !== false) {
                $ccode = trim(strtoupper($row[$ccodeIndex]));
                $ctitle = trim($row[$ctitleIndex]);
                $cunit = trim($row[$cunitIndex]);
                $csemester = trim($row[$csemesterIndex]);
                Course::updateOrInsert(
                    [
                        'stdcourse' => $request->cos,
                        'thecourse_code' => strtoupper($ccode)
                    ],
                    [
                        'thecourse_title' => strtoupper($ctitle),
                        'thecourse_unit' => (int) $cunit,
                        'prog' => $request->programme_id,
                        'prog_type' => $request->programmet_id,
                        'csession' => date('Y'),
                        'levels' => $request->level_id,
                        'semester' => ucwords(strtolower($csemester)),
                    ]
                );
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Courses uploaded successfully!');
        }

        return redirect()->back()->withErrors('Course upload failed.');
    }
}
