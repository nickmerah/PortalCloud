<?php

namespace App\Http\Controllers;

use App\Models\SchoolInfo;

class SchoolInfoController extends Controller
{
    public function index()
    {
        $schoolInfo = SchoolInfo::first();

        return view('home', ['schoolName' => $schoolInfo ? $schoolInfo : '']);
    }
}
