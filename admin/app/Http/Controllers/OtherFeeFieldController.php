<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherFeeField;

class OtherFeeFieldController extends Controller
{
    public function index()
    {
        $fields = OtherFeeField::get();
        return view('ofeefields.fields', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ofield_name' => 'required|string',
            'of_amount' => 'required|int',
        ], [
            'ofield_name.required' => 'The field name is required.',
            'of_amount.required' => 'The amount is required.',
        ]);

        $existingField = OtherFeeField::where('ofield_name', $request->ofield_name)->first();

        if ($existingField) {
            return redirect()->back()
                ->withErrors(['ofield_name' => 'This field name already exists.'])
                ->withInput();
        }

        OtherFeeField::create([
            'ofield_name' => strtoupper($request->ofield_name),
            'of_amount' => (int) $request->of_amount,
            'of_prog' => 0,
            'of_status' => 1,
        ]);
        return redirect()->route('otherfees.index')
            ->with('success', 'Field name created successfully.');
    }


    public function show(string $id)
    {
        $fields = OtherFeeField::findOrFail($id);
        if (is_null($fields)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $fields]);
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'of_amount' => 'required|string',
        ], [
            'of_amount.required' => 'The fee amount is required.',
        ]);

        OtherFeeField::where('of_id', $id)->update([
            'of_amount' => $request->of_amount,
        ]);
        return redirect()->route('otherfees.index')
            ->with('success', 'Fee Amount updated successfully.');
    }
}
