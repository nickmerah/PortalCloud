<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\ApplicantFee;
use Illuminate\Http\Request;
use App\Models\ApplicantFeeField;

class ApplicantFeeFieldController extends Controller
{
    public function index()
    {
        $fields = ApplicantFeeField::get();
        return view('feefields.fields', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string',
        ], [
            'field_name.required' => 'The field name is required.',
        ]);

        $existingField = ApplicantFeeField::where('field_name', $request->field_name)->first();

        if ($existingField) {
            return redirect()->back()
                ->withErrors(['field_name' => 'This field name already exists.'])
                ->withInput();
        }

        ApplicantFeeField::create([
            'field_name' => strtoupper($request->field_name),
        ]);
        return redirect()->route('appfees.index')
            ->with('success', 'Field name created successfully.');
    }


    public function show(string $id)
    {
        $fields = ApplicantFeeField::findOrFail($id);
        if (is_null($fields)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $fields]);
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'field_name' => 'required|string',
        ], [
            'field_name.required' => 'The field name is required.',
        ]);


        $existingField = ApplicantFeeField::where('field_name', $request->field_name)
            ->where('field_id', '<>', $id)
            ->first();

        if ($existingField) {
            return redirect()->back()
                ->withErrors(['field_name' => 'This field name already exists.'])
                ->withInput();
        }


        ApplicantFeeField::where('field_id', $id)->update([
            'field_name' => $request->field_name,
        ]);
        return redirect()->route('appfees.index')
            ->with('success', 'Field updated successfully.');
    }

    public function getappfees(int $id)
    {

        $fees = ApplicantFee::with('fees', 'programme', 'programmeType')->where(['item_id' => $id])->get();
        return view('feefields.appfees', compact('fees'));
    }
}
