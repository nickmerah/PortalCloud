<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolInfo;

class SchoolInfoController extends Controller
{
    public function index()
    {
        $schoolInfo = SchoolInfo::find(1);
        if (is_null($schoolInfo)) {
            return redirect()->route('schoolinfo.index')
                ->with('error', 'Record not found');
        }
        return view('schoolinfo.start', compact('schoolInfo'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'schoolname' => 'required|string|max:250',
            'schoolabvname' => 'required|string|max:25',
            'schooladdress' => 'required|string',
            'schoolemail' => 'required|string|email|max:150',
            'endreg_date' => 'required|string|max:50',
            'markuee' => 'required|string',
            'appmarkuee' => 'required|string',
            'appendreg_date' => 'required|string',
        ]);

        $schoolInfo = SchoolInfo::find($id);
        if (is_null($schoolInfo)) {
            return redirect()->route('schoolinfo.index')
                ->with('error', 'Record not found');
        }
        $schoolInfo->update($request->all());
        return redirect()->route('schoolinfo.index')
            ->with('success', 'School info updated successfully.');
    }
}
