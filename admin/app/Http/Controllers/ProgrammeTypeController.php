<?php

namespace App\Http\Controllers;

use App\Models\ProgrammeType;
use Illuminate\Http\Request;

class ProgrammeTypeController extends Controller
{
    public function index()
    {
        $programmetypes = ProgrammeType::all();
        return view('programmetypes.start', compact('programmetypes'));
    }


    public function create()
    {
        return view('programmetypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'programmet_name' => 'required|string|max:50|unique:programme_type',
            'd_status' => 'required|integer|max:1',
        ], [
            'programmet_name.max' => 'The programme type name must not be greater than 50 characters.',
            'd_status.max' => 'The programme type status must not be greater than 1 character.',
            'programmet_name.unique' => 'The programme type name already exist.',
        ]);

        $data = array_map('strtoupper', $request->all());

        ProgrammeType::create($data);

        return redirect()->route('programmetypes.index')
            ->with('success', 'Programme Type created successfully.');
    }


    public function show(string $id)
    {
        $programmetypes = ProgrammeType::findOrFail($id);
        if (is_null($programmetypes)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $programmetypes]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'programmet_name' => 'required|string|max:50',
            'd_status' => 'required|integer|max:1',
        ], [
            'programmet_name.max' => 'The programme type name must not be greater than 50 characters.',
            'd_status.max' => 'The programme type status must not be greater than 1 character.',
        ]);

        $programmetypes = ProgrammeType::findOrFail($id);

        if ($programmetypes->programmet_name !== $request->programmet_name) {
            $check_duplicate = ProgrammeType::where('programmet_name', $request->programmet_name)->first();

            if ($check_duplicate) {
                return redirect()->route('programmetypes.index')
                    ->with('error', 'Programme Type name exists');
            }
        }

        $data = (object) array_map('strtoupper', $request->all());

        // Update the programme with the new data
        $programmetypes->programmet_name = $data->programmet_name;
        $programmetypes->pt_status = $data->d_status;
        $programmetypes->save();

        return redirect()->route('programmetypes.index')
            ->with('success', 'Programme Type updated successfully');
    }
}
