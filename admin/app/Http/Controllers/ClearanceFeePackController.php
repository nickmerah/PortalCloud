<?php

namespace App\Http\Controllers;

use App\Models\ClearanceFeePack;
use Illuminate\Http\Request;

class ClearanceFeePackController extends Controller
{
    public function index()
    {
        $packs = ClearanceFeePack::get();
        return view('feepacks.packs', compact('packs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pack_name' => 'required|string',
        ], [
            'pack_name.required' => 'The pack name is required.',
        ]);

        $existingPack = ClearanceFeePack::where('pack_name', $request->pack_name)->first();

        if ($existingPack) {
            return redirect()->back()
                ->withErrors(['pack_name' => 'This pack name already exists.'])
                ->withInput();
        }

        ClearanceFeePack::create([
            'pack_name' => strtoupper($request->pack_name),
        ]);
        return redirect()->route('packs.index')
            ->with('success', 'Pack name created successfully.');
    }


    public function show(string $id)
    {
        $packs = ClearanceFeePack::findOrFail($id);
        if (is_null($packs)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $packs]);
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'pack_name' => 'required|string',
        ], [
            'pack_name.required' => 'The pack name is required.',
        ]);


        $existingPack = ClearanceFeePack::where('pack_name', $request->pack_name)
            ->where('pack_id', '<>', $id)
            ->first();

        if ($existingPack) {
            return redirect()->back()
                ->withErrors(['pack_name' => 'This pack name already exists.'])
                ->withInput();
        }


        ClearanceFeePack::where('pack_id', $id)->update([
            'pack_name' => strtoupper($request->pack_name),
        ]);
        return redirect()->route('packs.index')
            ->with('success', 'Pack updated successfully.');
    }
}
