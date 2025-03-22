<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DeptOption;
use Illuminate\Http\Request;
use App\Models\Programme;

class DeptOptionController extends Controller
{
    public function index()
    {
        $dept_options = DeptOption::with(['department', 'programme'])->get();
        $departments = Department::all();
        $programmes = Programme::all();
        return view('deptoptions.start', compact('dept_options', 'departments', 'programmes'));
    }

    public function create()
    {
        return view('deptoptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dept_id' => 'required|integer',
            'programme_option' => 'required|string|unique:dept_options,programme_option',
            'prog_id' => 'required|integer',
            'deptcode' => 'required|string',
        ]);

        $request = (object) array_map('strtoupper', $request->all());

        DeptOption::create([
            'dept_id' => $request->dept_id,
            'programme_option' => $request->programme_option,
            'duration' => 2,
            'prog_id' => $request->prog_id,
            'deptcode' => $request->deptcode,
            'dept_code' => $request->deptcode,
            'd_status' => 0,
            'd_status_pt' => 0,
        ]);

        return redirect()->route('cos.index')
            ->with('success', 'Department option created successfully.');
    }

    public function show(string $id)
    {
        $dept_option = DeptOption::findOrFail($id);
        if (is_null($dept_option)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $dept_option]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'dept_id' => 'required|integer',
            'programme_option' => 'required|string',
            'prog_id' => 'required|integer',
            'deptcode' => 'required|string',
        ]);

        DeptOption::where('do_id', $id)->update([
            'dept_id' => $request->dept_id,
            'programme_option' => $request->programme_option,
            'duration' => 2,
            'prog_id' => $request->prog_id,
            'deptcode' => $request->deptcode,
            'dept_code' => $request->deptcode,
            'exam_date' => $request->exam_date,
            'exam_time' => $request->exam_time,
            'admletter_date' => $request->admletter_date,
            'd_status' => $request->d_status,
            'd_status_pt' => $request->d_status_pt,
            'prog_option' => $request->prog_option,
        ]);
        return redirect()->route('cos.index')
            ->with('success', 'Record updated successfully.');
    }

    public function getOptionsByProgramme($programme_id, $programmet_id)
    {
        $query = DeptOption::where('prog_id', $programme_id)
            ->select('do_id', 'programme_option');

        // filter PT courses
        if ($programmet_id == 2) {
            $query->where('prog_option', 0);
        }
        $options = $query->get();

        return response()->json(['options' => $options]);
    }
}
