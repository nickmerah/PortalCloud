<?php

namespace App\Http\Controllers;

use App\Models\UserGroups;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function index()
    {
        $groups = UserGroups::all();
        return view('usergroup.start', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string',
            'group_description' => 'required|string'
        ], [
            'group_name.required' => 'The group name is required.',
            'group_description.required' => 'The group description is required.',
        ]);

        $existingGroup = UserGroups::where('group_name', $request->group_name)
            ->first();

        if ($existingGroup) {
            return redirect()->back()
                ->withErrors(['group_name' => 'This group name already exists.'])
                ->withInput();
        }

        UserGroups::create([
            'group_name' => $request->group_name,
            'group_description' => $request->group_description,
        ]);
        return redirect()->route('usergroup.index')
            ->with('success', 'Group created successfully.');
    }


    public function show(string $id)
    {
        $groups = UserGroups::findOrFail($id);
        if (is_null($groups)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $groups]);
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'group_name' => 'required|string',
            'group_description' => 'required|string'
        ], [
            'group_name.required' => 'The group name is required.',
            'group_description.required' => 'The group description is required.',
        ]);


        $existingGroup = UserGroups::where('group_name', $request->group_name)
            ->where('group_description', $request->group_description)
            ->where('group_id', '<>', $id)
            ->first();

        if ($existingGroup) {
            return redirect()->back()
                ->withErrors(['group_name' => 'This group name already exists.'])
                ->withInput();
        }


        UserGroups::where('group_id', $id)->update([
            'group_name' => $request->group_name,
            'group_description' => $request->group_description
        ]);
        return redirect()->route('usergroup.index')
            ->with('success', 'Record updated successfully.');
    }
}
