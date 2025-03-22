<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Programme;
use App\Models\ProgrammeType;
use App\Models\UserGroups;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public const CLEARANCE_GROUP_ID = 8;
    public const COURSE_ADVISER_GROUP_ID = 10;

    public function index()
    {
        $users = Users::all();
        $roles = UserGroups::all();

        return view('users.start', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'u_username' => 'required|string',
            'u_password' => 'required|string',
            'u_surname' => 'required|string',
            'u_firstname' => 'required|string',
            'u_email' => 'required|string|email',
            'u_group' => 'required|integer',
        ], [
            'u_username.required' => 'The username is required.',
            'u_password.required' => 'The password is required.',
            'u_surname.required' => 'The Surname is required.',
            'u_firstname.required' => 'The Firstname is required.',
            'u_email.required' => 'The Email is required.',
            'u_email.email' => 'The email enter is not valid.',
            'u_group.required' => 'The role is required.',
        ]);

        $existingUser = Users::where('u_username', $request->u_username)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['u_username' => 'This username already exists.'])
                ->withInput();
        }

        Users::create([
            'u_username' => $request->u_username,
            'u_password' => $request->u_password,
            'u_surname' => $request->u_surname,
            'u_firstname' => $request->u_firstname,
            'u_email' => $request->u_email,
            'u_group' => $request->u_group,
        ]);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }


    public function show(string $id)
    {
        $users = Users::findOrFail($id);
        if (is_null($users)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $users]);
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'u_username' => 'required|string',
            'u_surname' => 'required|string',
            'u_firstname' => 'required|string',
            'u_email' => 'required|string|email',
            'u_group' => 'required|integer',
            'u_status' => 'required|integer',
        ], [
            'u_username.required' => 'The Username is required.',
            'u_surname.required' => 'The Surname is required.',
            'u_firstname.required' => 'The Firstname is required.',
            'u_email.required' => 'The Email is required.',
            'u_email.email' => 'The email enter is not valid.',
            'u_group.required' => 'The role is required.',
            'u_status.required' => 'The Status is required.',
        ]);

        $existingUser = Users::where('u_username', $request->u_username)
            ->where('user_id', '<>', $id)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['u_username' => 'This username already exists.'])
                ->withInput();
        }


        Users::where('user_id', $id)->update([
            'u_username' => $request->u_username,
            'u_surname' => $request->u_surname,
            'u_firstname' => $request->u_firstname,
            'u_email' => $request->u_email,
            'u_status' => $request->u_status,
            'u_group' => $request->u_group,
        ]);
        return redirect()->route('users.index')
            ->with('success', 'Record updated successfully.');
    }

    function updateuserpass(Request $request, string $id)
    {
        $request->validate([
            'u_username' => 'required|string',
            'u_password' => 'required|string',
        ], [
            'u_username.required' => 'The Username is required.',
            'u_password.required' => 'The Password is required.',
        ]);

        $existingUser = Users::where('u_username', $request->u_username)
            ->where('user_id', '<>', $id)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['u_username' => 'This username already exists.'])
                ->withInput();
        }

        $user = Users::find($id);
        $user->u_username = $request->u_username;
        $user->u_password = $request->u_password;
        $user->save();


        return redirect()->route('users.index')
            ->with('success', 'Password updated successfully.');
    }

    function getclearanceofficers()
    {
        $clearanceGroupId = self::CLEARANCE_GROUP_ID;

        $users = Users::where('u_group', $clearanceGroupId)->get(); //clearance
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();

        return view('users.assigndepts', compact('users', 'programmes', 'programmeTypes'));
    }

    function saveclearanceofficers(Request $request)
    {
        $user = Users::findOrFail($request->user_id);

        $user->u_progtype = $request->input('progtype');

        $user->u_prog = $request->input('prog');

        $selectedCourses = $request->input('cos', []);

        if ($request->input('updatettype') == 1) {
            // Ensure existing courses are properly retrieved, avoiding issues with null values
            $existingCourses = !empty($user->u_dept) ? explode(',', $user->u_dept) : [];

            // Merge and remove duplicates
            $selectedCourses = array_unique(array_merge($existingCourses, $selectedCourses));
        }

        $user->u_dept = implode(',', $selectedCourses);

        if ($user->save()) {

            return redirect()->route('clearanceofficers')->with('success', 'User department courses updated successfully.');
        } else {

            return redirect()->route('clearanceofficers')->with('error', 'Failed to update user department courses.');
        }
    }

    function getcourseadvisers()
    {
        $courseadviserGroupId = self::COURSE_ADVISER_GROUP_ID;

        $users = Users::where('u_group', $courseadviserGroupId)->get();
        $programmes = Programme::all();
        $programmeTypes = ProgrammeType::all();

        return view('users.assigndeptscourse', compact('users', 'programmes', 'programmeTypes'));
    }

    function savecourseadvisers(Request $request)
    {
        $user = Users::findOrFail($request->user_id);

        $user->u_progtype = $request->input('progtype');

        $user->u_prog = $request->input('prog');

        $selectedCourses = $request->input('cos', []);

        if ($request->input('updatettype') == 1) {
            // Ensure existing courses are properly retrieved, avoiding issues with null values
            $existingCourses = !empty($user->u_cos) ? explode(',', $user->u_cos) : [];

            // Merge and remove duplicates
            $selectedCourses = array_unique(array_merge($existingCourses, $selectedCourses));
        }


        $user->u_cos = implode(',', $selectedCourses);

        if ($user->save()) {

            return redirect()->route('courseadvisers')->with('success', 'User department courses updated successfully.');
        } else {

            return redirect()->route('courseadvisers')->with('error', 'Failed to update user department courses.');
        }
    }
}
