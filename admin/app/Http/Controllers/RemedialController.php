<?php

namespace App\Http\Controllers;

use App\Models\Remedial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RemedialController extends Controller
{
    public function index()
    {
        $students = Remedial::get();
        return view('remedial.start', compact('students'));
    }

    public function uploadStudents(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle);

            $snameIndex = array_search('s_name', $headers);
            $fnameIndex = array_search('f_name', $headers);
            $mnameIndex = array_search('m_name', $headers);
            $matnoIndex = array_search('m_number', $headers);
            $pidIndex = array_search('p_id', $headers);
            $certIndex = array_search('cert', $headers);
            $levelIndex = array_search('level', $headers);
            $sessionIndex = array_search('session', $headers);
            if (
                $snameIndex === false || $fnameIndex === false || $mnameIndex === false
                || $matnoIndex === false || $pidIndex === false || $certIndex === false
                || $levelIndex === false || $sessionIndex === false
            ) {
                return redirect()->back()->withErrors('CSV must contain all columns.');
            }

            while (($row = fgetcsv($handle)) !== false) {
                $sname = trim(strtoupper($row[$snameIndex]));
                $fname = trim(strtoupper($row[$fnameIndex]));
                $mname = trim(strtoupper($row[$mnameIndex]));
                $matno = trim(strtoupper($row[$matnoIndex]));
                $pid = trim($row[$pidIndex]);
                $cert = trim($row[$certIndex]);
                $level = trim($row[$levelIndex]);
                $session = trim($row[$sessionIndex]);
                $pwd = strtolower($sname);

                // Skip empty rows
                if ((empty($sname) && empty($fname)) || empty($matno)) {
                    continue;
                }

                DB::table('rprofile')->updateOrInsert(
                    ['matno' => $matno],
                    [
                        'surname' => $sname,
                        'firstname' => $fname,
                        'othername' => $mname,
                        'matno' => $matno,
                        'pid' => $pid,
                        'cert' => $cert,
                        'level' => $level,
                        'sess' => $session,
                        'password' => Hash::make($pwd),
                        'updated_at' => date('Y-m-d h:i:s')
                    ]
                );
            }

            fclose($handle);

            return redirect()->back()->with('success', 'Remedial list uploaded successfully');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }
}
