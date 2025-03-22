<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\HostelRoomAllocation;
use App\Models\Student;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::with(['rooms'])->get();
        return view('hostels.start', compact('hostels'));
    }

    public function create()
    {
        return view('deptoptions.create');
    }

    public function show(string $id)
    {
        $hostels = Hostel::findOrFail($id);
        if (is_null($hostels)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $hostels]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'hostel_status' => 'required|integer',
        ]);

        Hostel::where('hid', $id)->update([
            'hostel_status' => $request->hostel_status
        ]);
        return redirect()->route('hostels.index')
            ->with('success', 'Record updated successfully.');
    }

    public function showRooms($hostelId)
    {
        $hostel = Hostel::with('rooms')->findOrFail($hostelId);
        return view('hostels.rooms', compact('hostel'));
    }

    public function showRoom($roomId)
    {
        $room = HostelRoom::findOrFail($roomId);

        if (is_null($room)) {
            return response()->json(['done' => false, 'data' => 'Record not found'], 404);
        }
        return response()->json(['done' => true, 'data' => $room]);
    }

    public function updateRoom(Request $request)
    {

        $request->validate([
            'roomid' => 'required|integer',
        ]);
        $roomId = $request->roomid;
        $hostelId = $request->hostelid;
        HostelRoom::where('roomid', $roomId)->update([
            'room_status' => $request->room_status
        ]);

        return redirect()->route('hostels.rooms', ['hostel' => $hostelId])->with('success', 'Record updated successfully.');
    }

    public function activehostel()
    {
        $hostels = Hostel::with(['rooms'])->get();
        return view('hostels.activehostels', compact('hostels'));
    }

    public function hostelRooms($hostelId)
    {
        $hostel = Hostel::with('rooms')->findOrFail($hostelId);
        return view('hostels.bookrooms', compact('hostel'));
    }

    public function bookRoom(Request $request)
    {

        $request->validate([
            'roomid' => 'required|integer',
            'matno' => 'required|string',
        ]);
        $roomId = $request->roomid;
        $hostelId = $request->hostelid;
        $matno = $request->matno;
        $checkallocation = false;
        $checkreserve = false;

        $findstudent = Student::where('matric_no', $matno)
            ->select('std_logid', 'gender')
            ->first();

        if (!$findstudent) {
            return redirect()->back()->withErrors('Selected student record not found');
        }
        $student = $findstudent->toArray();

        $hostel = Hostel::with('rooms')->findOrFail($hostelId);

        if (strtolower($hostel->gender) !== strtolower($student['gender'])) {
            return redirect()->back()->withErrors('Selected student gender is different from hostel gender');
        }

        $room = HostelRoom::findOrFail($roomId);

        if ($room->allocations()->count() >= $room->capacity) {
            return redirect()->back()->withErrors('Room already filled to capacity');
        }

        $checkallocation = HostelRoomAllocation::where('std_logid', $student['std_logid'])->exists();

        if ($checkallocation) {
            return redirect()->back()->withErrors('Room already allocated to selected student');
        }

        $bookedStudents = json_decode($room->booked, true) ?? [];

        $checkreserve = in_array($student['std_logid'], $bookedStudents);

        if ($checkreserve) {
            return redirect()->back()->withErrors('Room already reserved for selected student');
        }

        if (count($bookedStudents) >= $room->capacity) {
            return redirect()->back()->withErrors('Room reservation already filled to capacity');
        }

        $bookedStudents[] = $student['std_logid'];

        $room->update([
            'booked' => json_encode($bookedStudents)
        ]);

        return redirect()->route('activehostels.rooms', ['hostel' => $hostelId])
            ->with('success', 'Room reserved successfully.');
    }

    public function reservedRooms($roomId)
    {
        $room = HostelRoom::findOrFail($roomId);

        if (is_null($room)) {
            return redirect()->back()->withErrors('Room Not Found');
        }

        $bookedStudentsIds = json_decode($room->booked, true);

        if (!is_array($bookedStudentsIds)) {
            $bookedStudentsIds = [];
        }

        $students = Student::whereIn('std_logid', $bookedStudentsIds)
            ->get(['std_logid', 'matric_no', 'surname', 'firstname', 'gender']);


        foreach ($students as $student) {

            $allocation = HostelRoomAllocation::where('std_logid', $student->std_logid)
                ->where('room_id', $roomId)
                ->exists();


            $student->is_allocated = $allocation;
        }


        return view('hostels.reservedrooms', compact('room', 'students'));
    }
}
