<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\Programme;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with('programme')->get();
        $programmes = Programme::all();
        return view('levels.start', compact('levels', 'programmes'));
    }


    public function create()
    {
        return view('levels.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'level_name' => 'required|string',
            'programme_id' => 'required|integer'
        ], [
            'level_name.required' => 'The level name is required.',
            'programme_id.required' => 'The programme is required.',
        ]);

        $existingLevel = Level::where('level_name', $request->level_name)
            ->where('programme_id', $request->programme_id)
            ->first();

        if ($existingLevel) {
            return redirect()->back()
                ->withErrors(['level_name' => 'This level already exists for the selected programme.'])
                ->withInput();
        }

        Level::create([
            'level_name' => $request->level_name,
            'programme_id' => $request->programme_id,
        ]);
        return redirect()->route('levels.index')
            ->with('success', 'Level created successfully.');
    }


    public function show(string $id)
    {
        $levels = Level::findOrFail($id);
        if (is_null($levels)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $levels]);
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_name' => 'required|string',
            'programme_id' => 'required|integer'
        ], [
            'level_name.required' => 'The level name is required.',
            'programme_id.required' => 'The programme is required.',
        ]);

        $existingLevel = Level::where('level_name', $request->level_name)
            ->where('programme_id', $request->programme_id)
            ->where('level_id', '<>', $id)
            ->first();

        if ($existingLevel) {
            return redirect()->back()
                ->withErrors(['level_name' => 'This level already exists for the selected programme.'])
                ->withInput();
        }


        Level::where('level_id', $id)->update([
            'level_name' => $request->level_name,
            'programme_id' => $request->programme_id
        ]);
        return redirect()->route('levels.index')
            ->with('success', 'Record updated successfully.');
    }
}
