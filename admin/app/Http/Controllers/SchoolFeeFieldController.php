<?php

namespace App\Http\Controllers;

use App\Models\SchoolFee;
use Illuminate\Http\Request;
use App\Models\StudentFeeField;
use App\Models\StdCurrentSession;

class SchoolFeeFieldController extends Controller
{
    public function index()
    {
        $fields = StudentFeeField::get();
        return view('schfeefields.fields', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string',
        ], [
            'field_name.required' => 'The field name is required.',
        ]);

        $existingField = StudentFeeField::where('field_name', $request->field_name)->first();

        if ($existingField) {
            return redirect()->back()
                ->withErrors(['field_name' => 'This field name already exists.'])
                ->withInput();
        }

        StudentFeeField::create([
            'field_name' => strtoupper($request->field_name),
        ]);
        return redirect()->route('schfees.index')
            ->with('success', 'Field name created successfully.');
    }


    public function show(string $id)
    {
        $fields = StudentFeeField::findOrFail($id);
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


        $existingField = StudentFeeField::where('field_name', $request->field_name)
            ->where('field_id', '<>', $id)
            ->first();

        if ($existingField) {
            return redirect()->back()
                ->withErrors(['field_name' => 'This field name already exists.'])
                ->withInput();
        }


        StudentFeeField::where('field_id', $id)->update([
            'field_name' => $request->field_name,
        ]);
        return redirect()->route('schfees.index')
            ->with('success', 'Field updated successfully.');
    }

    public function getschfees(int $id)
    {
        $currentSession = StdCurrentSession::getStdCurrentSession();
        $fees = SchoolFee::with('fees', 'programme', 'level', 'programmeType')->where(['field_id' => $id, 'sessionid' => $currentSession['cs_session']])->get();
        return view('schfeefields.schfees', compact('fees'));
    }

    public function getschfeesamt(string $id)
    {
        $fields = SchoolFee::findOrFail($id);
        if (is_null($fields)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $fields]);
    }

    public function updateschfeesamt(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
        ], [
            'id.required' => 'The id is required.',
            'amount.required' => 'The amount is required.',
        ]);

        SchoolFee::where('id', $request->id)->update([
            'amount' => $request->amount,
        ]);
        return redirect()->route('getschfee', ['id' => $request->field_id])
            ->with('success', 'Fees updated successfully.');
    }
}
