<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\SchoolInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    protected $schoolInfo;

    public function __construct()
    {
        $this->schoolInfo = SchoolInfo::first();
    }

    public function welcome()
    {
        return view('welcome', ['schoolName' => $this->schoolInfo->schoolname]);
    }

    public function adminlogin(Request $request)
    {
        $validatedData = $request->validate([
            'uname' => 'required|string|max:50',
            'upass' => 'required|string|max:80',
        ]);

        $uname = htmlspecialchars($validatedData['uname'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($validatedData['upass'], ENT_QUOTES, 'UTF-8');
        // $password = strtolower($password);


        $user = Users::where(['u_username' => $uname, 'u_status' => 1])->first();

        if ($user && (Hash::check($password, $user->u_password))) {

            Log::info('User logged in successfully', ['user_id' => $user->user_id]);

            session()->regenerate();

            $userData = Crypt::encryptString(json_encode([
                'userId' => $user->user_id,
                'uGroup' => $user->u_group,
            ]));

            session(['user_data' => $userData]);

            return redirect()->intended('welcome')->with('success', 'Login successful!');
        }

        Log::warning('Failed login attempt', ['uname' => $uname]);

        return back()->withErrors([
            'uname' => 'Invalid Username / Password',
        ]);
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        session()->regenerate();
        return redirect('/')->with('success', 'You have been logged out.');
    }

    public function forbidden()
    {
        return view('forbidden', ['schoolName' => $this->schoolInfo->schoolname]);
    }
}
