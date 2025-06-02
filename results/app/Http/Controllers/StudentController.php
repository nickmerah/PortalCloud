<?php

namespace App\Http\Controllers;

use App\Models\Levels;
use App\Models\Student;
use App\Models\Programmes;
use Illuminate\Http\Request;
use App\Models\ProgrammeType;
use App\Models\DepartmentOptions;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::with(['programme', 'programmeType', 'departmentOption', 'level'])->paginate(50);
        $programmes = Programmes::all();
        $programmeTypes = ProgrammeType::all();
        $levels = Levels::all();
        $courseofstudy = DepartmentOptions::all();
        return view('students', compact('students', 'programmes', 'programmeTypes', 'levels', 'courseofstudy'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'csv_file' => 'required|file|mimes:csv|max:4048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);
            $matnoIndex = array_search('matricno', $headers);
            $surnameIndex = array_search('surname', $headers);
            $firstnameIndex = array_search('firstname', $headers);
            $othernamesIndex = array_search('othernames', $headers);
            if ($matnoIndex === false || $surnameIndex === false || $firstnameIndex === false) {
                return redirect()->back()->withErrors('CSV must contain "matricno", "surname" and "firstname" columns.');
            }
            while (($row = fgetcsv($handle)) !== false) {
                $matno = trim($row[$matnoIndex]);
                $surname = trim($row[$surnameIndex]);
                $firstname = trim($row[$firstnameIndex]);
                $othernames = trim($row[$othernamesIndex]);
                Student::updateOrCreate(
                    ['matric_no' => $matno],
                    [
                        'surname' => $surname,
                        'firstname' => $firstname,
                        'othernames' => $othernames,
                        'stdprogramme_id' => $data['prog'] ?? null,
                        'stdprogrammetype_id' => $data['progtype'] ?? null,
                        'stdcourse' => $data['course_of_study'] ?? null,
                        'stdlevel' => $data['level'] ?? null,
                    ]
                );
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Student List Uploaded successfully.');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
