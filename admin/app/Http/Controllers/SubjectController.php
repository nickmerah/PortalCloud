<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::get();
        return view('applicants.subjects', compact('subjects'));
    }

    public function show(string $id)
    {
        $subjects = Subject::findOrFail($id);
        if (is_null($subjects)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $subjects]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subjectcode' => 'required|string',
            'subjectname' => 'required|string'
        ], [
            'subjectcode.required' => 'The subject code is required.',
            'subjectname.required' => 'The subject name is required.',
        ]);

        $existingSubject = Subject::where('subjectname', $request->subjectname)
            ->first();

        if ($existingSubject) {
            return redirect()->back()
                ->withErrors(['level_name' => 'This subject name already exists.'])
                ->withInput();
        }

        Subject::create([
            'subjectname' => strtoupper($request->subjectname),
            'subjectcode' => strtoupper($request->subjectcode),
        ]);
        return redirect()->route('olevelsubjects.index')
            ->with('success', 'Subject created successfully.');
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'subjectcode' => 'required|string',
            'subjectname' => 'required|string'
        ], [
            'subjectcode.required' => 'The subject code is required.',
            'subjectname.required' => 'The subject name is required.',
        ]);


        $existingSubject = Subject::where('subjectname', $request->subjectname)
            ->where('id', '<>', $id)
            ->first();

        if ($existingSubject) {
            return redirect()->back()
                ->withErrors(['level_name' => 'This subject name already exists.'])
                ->withInput();
        }


        Subject::where('id', $id)->update([
            'subjectname' => strtoupper($request->subjectname),
            'subjectcode' => strtoupper($request->subjectcode),
        ]);
        return redirect()->route('olevelsubjects.index')
            ->with('success', 'Subject updated successfully.');
    }
}
