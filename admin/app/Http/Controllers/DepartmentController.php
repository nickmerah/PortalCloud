<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('faculty')->get();
        $faculties = Faculty::all();

        return view('departments.start', compact('departments', 'faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departments_name' => 'string|required|unique:departments',
            'fac_id' => 'required|integer',
            'departments_code' => 'string|required|unique:departments',
        ]);

        Department::create([
            'departments_name' => strtoupper($request->departments_name),
            'fac_id' => $request->fac_id,
            'departments_code' => strtoupper($request->departments_code),
        ]);
        return redirect()->route('depts.index')
            ->with('success', 'Department created successfully.');
    }


    public function show(string $id)
    {
        $department = Department::with('faculty')->findOrFail($id);
        if (is_null($department)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $department]);
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'departments_name' => 'required|string',
            'fac_id' => 'required|integer',
            'departments_code' => 'required|string'
        ]);

        Department::where('departments_id', $id)->update([
            'departments_name' => strtoupper($request->departments_name),
            'fac_id' => $request->fac_id,
            'departments_code' => strtoupper($request->departments_code)
        ]);

        return redirect()->route('depts.index')
            ->with('success', 'Department updated successfully.');
    }
}
