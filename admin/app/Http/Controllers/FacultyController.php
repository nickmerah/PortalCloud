<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::all();
        return view('faculties.start', compact('faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculties_name' => 'required|string|max:255',
            'fcode' => 'required|string|max:10',
        ], [
            'fcode.max' => 'The faculty code must not be greater than 10 characters.',
        ]);

        $data = array_map('strtoupper', $request->all());

        Faculty::create($data);
        return redirect()->route('faculties.index')
            ->with('success', 'Faculty created successfully.');
    }

    public function show($id)
    {
        $faculty = Faculty::find($id);

        if (is_null($faculty)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $faculty]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'faculties_name' => 'required|string|max:255',
            'fcode' => 'required|string|max:10',
        ]);

        $faculty = Faculty::find($id);
        if (is_null($faculty)) {
            return redirect()->route('faculties.index')
                ->with('error', 'Record not found');
        }
        $faculty->update($request->all());
        return redirect()->route('faculties.index')
            ->with('success', 'Faculty updated successfully.');
    }
}
