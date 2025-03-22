<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\DeptOption;
use App\Models\ClearanceFee;
use Illuminate\Http\Request;
use App\Models\ClearanceFeePack;
use App\Models\ClearanceFeeField;

class ClearanceFeeFieldController extends Controller
{
    public function index()
    {
        $fields = ClearanceFeeField::with(['pack'])->get();
        $packs = ClearanceFeePack::all();
        return view('feepacks.packfields', compact('fields', 'packs'));
    }

    public function show(string $id)
    {
        $fields = ClearanceFeeField::findOrFail($id);
        if (is_null($fields)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $fields]);
    }



    public function getclearancefee(string $p, string $id)
    {
        $criteria = 'item_id';
        if ($p == 'p') {
            $criteria = 'pack_id';
        }
        $fields = ClearanceFee::where($criteria, $id)->with(['pack', 'programme', 'fees'])->get();

        $cfields = ClearanceFeeField::all();
        $packs = ClearanceFeePack::all();
        $programmes = Programme::all();
        return view('feepacks.fieldamount', compact('fields', 'packs', 'programmes', 'cfields'));
    }

    public function getoneclearancefee(string $id)
    {
        $fields = ClearanceFee::findOrFail($id);
        if (is_null($fields)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $fields]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string',
            'pack_name' => 'required|integer',
        ]);

        $request = (object) array_map('strtoupper', $request->all());

        ClearanceFeeField::create([
            'field_name' => $request->field_name,
            'pack_id' => $request->pack_name
        ]);

        return redirect()->route('clearancefees.index')
            ->with('success', 'Fee created successfully.');
    }

    public function storecfee(Request $request)
    {
        $request->validate([
            'field_name' => 'required|integer',
            'prog_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);

        $pack_id = ClearanceFeeField::where('field_id', $request->field_name)->pluck('pack_id')->first();

        ClearanceFee::create([
            'item_id' => $request->field_name,
            'prog_id' => $request->prog_id,
            'pack_id' => $pack_id,
            'amount' => $request->amount
        ]);

        return redirect()->route('clearancefees.index')
            ->with('success', 'Fee created successfully.');
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'field_name' => 'required|string',
            'pack_name' => 'required|integer',
        ]);

        ClearanceFeeField::where('field_id', $id)->update([
            'field_name' => $request->field_name,
            'pack_id' => $request->pack_name
        ]);
        return redirect()->route('clearancefees.index')
            ->with('success', 'Record updated successfully.');
    }

    public function updatecfee(Request $request)
    {
        $request->validate([
            'prog_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);
        $id = $request->efield_id;
        ClearanceFee::where('fee_id', $id)->update([
            'prog_id' => $request->prog_id,
            'amount' => $request->amount
        ]);

        return redirect()->route('clearancefees.index')
            ->with('success', 'Fee updated successfully.');
    }
}
