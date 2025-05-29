<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    public function index()
    {
        $programmes = Programme::all();
        return view('programmes.start', compact('programmes'));
    }


    public function create()
    {
        return view('programmes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'programme_name' => 'required|string|max:150|unique:programme',
            'aprogramme_name' => 'required|string|max:4|unique:programme',
        ], [
            'programme_name.max' => 'The programme name code must not be greater than 150 characters.',
            'aprogramme_name.max' => 'The programme abbreviation must not be greater than 4 characters.',
        ]);

        $data = array_map('strtoupper', $request->all());

        Programme::create($data);

        return redirect()->route('programmes.index')
            ->with('success', 'Programme created successfully.');
    }


    public function show(string $id)
    {
        $programme = Programme::findOrFail($id);
        if (is_null($programme)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $programme]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'programme_name' => 'required|string|max:150',
            'aprogramme_name' => 'required|string|max:4',
            'd_status' => 'required|integer|max:1',
        ], [
            'programme_name.max' => 'The programme name code must not be greater than 150 characters.',
            'aprogramme_name.max' => 'The programme abbreviation must not be greater than 4 characters.',
            'd_status.max' => 'The programme type status must not be greater than 1 character.',
        ]);

        $programme = Programme::findOrFail($id);

        if ($programme->programme_name !== $request->programme_name) {
            $check_duplicate = Programme::where('programme_name', $request->programme_name)->first();

            if ($check_duplicate) {
                return redirect()->route('programmes.index')
                    ->with('error', 'Programme name exists');
            }
        }



        $data = (object) array_map('strtoupper', $request->all());

        // Update the programme with the new data
        $programme->programme_name = $data->programme_name;
        $programme->aprogramme_name = $data->aprogramme_name;
        $programme->p_status = $data->d_status;
        $programme->save();

        return redirect()->route('programmes.index')
            ->with('success', 'Programme updated successfully');
    }
}
