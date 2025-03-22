<?php

namespace App\Http\Controllers;

use App\Models\UserGroups;
use App\Policies\MenuPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        // Fetch all permissions with their respective groups
        $permissions = DB::table('permissions')
            ->join('group_table', 'permissions.group_id', '=', 'group_table.group_id')
            ->select('permissions.*', 'group_table.group_name')
            ->get();

        $policy = new MenuPolicy();
        $menuPermissions = $policy->getAllPermissions();

        $roles = UserGroups::all();
        return view('permissions.start', compact('permissions', 'roles', 'menuPermissions'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'u_group' => 'required|exists:group_table,group_id',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);


        // Retrieve selected group and permissions
        $groupId = $validatedData['u_group'];
        $selectedPermissions = $validatedData['permissions'] ?? [];

        // Save permissions to the database (example using the permissions table)
        foreach ($selectedPermissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['feature' => $permission, 'group_id' => $groupId]
            );
        }

        return redirect()->route('permissions.index')->with('success', 'User and permissions saved successfully.');
    }

    public function show($id)
    {
        $userGroup = DB::table('permissions')
            ->where('permissions.group_id', $id)
            ->select('permissions.group_id', 'permissions.feature')
            ->get();

        if (is_null($userGroup)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $userGroup]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string'
        ]);

        $selectedPermissions = $validatedData['permissions'] ?? [];


        DB::table('permissions')->where('group_id', $id)->delete();

        $insertData = [];
        foreach ($selectedPermissions as $permission) {
            $insertData[] = [
                'feature' => $permission,
                'group_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($insertData)) {
            DB::table('permissions')->insert($insertData);
        }

        return redirect()->route('permissions.index')->with('success', 'Permissions updated successfully.');
    }
}
