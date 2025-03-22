<?php

namespace App\Http\Controllers;

use App\Models\Portal;
use App\Models\Student;
use App\Models\SchoolFee;
use Illuminate\Http\Request;
use App\Models\CurrentSession;
use App\Models\StdCurrentSession;
use Illuminate\Support\Facades\DB;

class PortalController extends Controller
{
    public function admportal()
    {
        $portals = Portal::with('programmeType')->where('p_name', "Admission")->get();

        return view('settings.portal', compact('portals'));
    }

    public function showportal(string $id)
    {
        $portal = Portal::findOrFail($id);
        if (is_null($portal)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $portal]);
    }

    public function updateportal(Request $request)
    {
        $request->validate([
            'msg' => 'required|string|max:255'
        ], [
            'msg.required' => 'The message is required.',
            'msg.max' => 'The message must not exceed 255 characters.'
        ]);


        $id = $request->do_id;
        $portal = Portal::findOrFail($id);
        if (is_null($portal)) {
            return redirect()->back()
                ->withErrors(['error' => 'Error Updating Portal Setting']);
        }

        $portal->p_message = $request->msg;
        $portal->p_status = $request->status;
        $portal->save();

        return redirect()->route('admportal')
            ->with('success', "Portal Setting was successful updated");
    }

    public function portalsession()
    {
        $session = CurrentSession::get();

        return view('settings.admsession', compact('session'));
    }

    public function stdportalsession()
    {
        $session = StdCurrentSession::where("status", 'current')->get();

        return view('settings.stdsession', compact('session'));
    }

    public function updatesession(string $id)
    {
        $session = CurrentSession::findOrFail($id);
        if (is_null($session)) {
            return redirect()->back()
                ->withErrors(['error' => 'Session not found']);
        }

        //end all previous sessions
        $previousSessions = CurrentSession::where('status', '!=', 'ended')->get();
        foreach ($previousSessions as $sess) {
            $sess->status = 'ended';
            $sess->save();
        }

        $session->status = ($session->status === 'ended') ? 'current' : 'ended';
        $session->save();

        return redirect()->route('admsession')
            ->with('error', "Session Successfully updated to $session->status");
    }

    public function addsession()
    {
        $session = CurrentSession::orderBy('cs_id', 'desc')->first();
        if (is_null($session)) {
            return redirect()->back()
                ->withErrors(['error' => 'Session not found']);
        }


        //end all previous sessions
        $previousSessions = CurrentSession::where('status', '!=', 'ended')->get();
        foreach ($previousSessions as $sess) {
            $sess->status = 'ended';
            $sess->save();
        }


        //add new session
        $newSession = new CurrentSession();
        $newSession->status = 'current';
        $newSession->start_date = now();
        $newSession->cs_session = $session->cs_session + 1;
        $newSession->end_date = now()->addMonths(9);
        $newSession->prog_id = 2;
        $newSession->save();

        return redirect()->route('admsession')
            ->with('success', "Session Successfully added");
    }

    public function stdaddsession()
    {
        $session = StdCurrentSession::orderBy('cs_id', 'desc')->first();
        if (is_null($session)) {
            return redirect()->back()
                ->withErrors(['error' => 'Session not found']);
        }


        //end all previous sessions
        $previousSessions = StdCurrentSession::where('status', '!=', 'ended')->get();
        foreach ($previousSessions as $sess) {
            $sess->status = 'ended';
            $sess->save();
        }

        foreach ([1, 2] as $progId) {
            $this->createNewSession($progId, $session->cs_session);
        }

        // reset student promote
        Student::query()->update(['promote_status' => 0]);

        //clear promotionlist 
        DB::table('stdpromote_list')->truncate();

        // rollover fees
        $this->rollOverSchoolFees($session->cs_session);

        return redirect()->route('stdsession')
            ->with('success', "Session Successfully added");
    }

    private function createNewSession(int $progId, int $currentSession)
    {
        StdCurrentSession::create([
            'status' => 'current',
            'start_date' => now(),
            'cs_session' => $currentSession + 1,
            'cs_sem' => 'First Semester',
            'end_date' => now()->addMonths(9),
            'prog_id' => $progId,
        ]);
    }

    private function rollOverSchoolFees(int $currentSession)
    {
        $newSession = $currentSession + 1;

        DB::transaction(function () use ($currentSession, $newSession) {
            $currentSessionFees = SchoolFee::where('sessionid', $currentSession)->get();

            // Create new records for the new session
            foreach ($currentSessionFees as $fee) {
                $newFeeData = $fee->toArray();
                $newFeeData['sessionid'] = $newSession;
                unset($newFeeData['id']);
                SchoolFee::create($newFeeData);
            }
        });
    }
}
