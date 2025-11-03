<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveDetail;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
          $data = Attendance::where('company_id', auth()->user()->company_id)
                            ->groupBy('date')
                            ->get();
        return view('attendance.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        foreach($request->attendance as $key => $att) {
            Attendance::updateOrCreate(
                [
                    'employee_id' => $att['employee_id'],
                    'date' => $request->date,
                ],
                [
                    'company_id' => 6,
                    'status' => $att['status'],
                    'check_in' => $att['check_in'] ?? null,
                    'check_out' => $att['check_out'] ?? null,
                ]
            );
        }
        return redirect()->route('attendance.index')->with('success', 'Attendance created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        $attendances = Attendance::where('date', $attendance->date)
                                ->where('company_id', auth()->user()->company_id)
                                ->with('employee')
                                ->get();
        return view('attendance.show', compact('attendances', 'attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
         //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        Attendance::where('date', $attendance->date)
                    ->where('company_id', auth()->user()->company_id)
                    ->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');
    }

    public function checkLeave(Request $request)
    {
        $employeeId = $request->input('employeeId');
        $date = $request->input('date');

        $Leave = LeaveDetail::where('employee_id', $employeeId)
                                ->where('date', $date)
                                ->first();

        if ($Leave) {
            return response()->json(['status' => $Leave->status, 'leave_type' => $Leave->leave_type]);
        } else {
            return response()->json(['status' => 0, 'leave_type' => null]);
        }
    }

    public function getAttendanceByDate(Request $request)
    {
        $date = $request->input('date');
        $employeeId = $request->input('employeeId');

        $attendanceRecords = Attendance::where('date', $date)
                                        ->where('employee_id', $employeeId)
                                        ->first();

        return response()->json($attendanceRecords);
    }
}
