<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shift;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Employee::with('branch','department','designation','shift','salary')->get();
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();
        $shifts = Shift::all();
        return view('employee.create', compact('branches', 'departments', 'designations', 'shifts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $request->validate([
            'branch_id'      => 'required|exists:branches,id',
            'department_id'  => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'shift_id'       => 'required|exists:shifts,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:employees,email',
            'phone'          => 'required|string|max:20',
            'father_name'    => 'nullable|string|max:255',
            'mother_name'    => 'nullable|string|max:255',
            'date_of_birth'  => 'nullable|date',
            'education'      => 'nullable|string|max:255',
            'skill'          => 'nullable|string|max:255',
            'join_date'      => 'nullable|date',
            'status'         => 'required|in:active,inactive',
        ]);
        $request->merge(['company_id' => 6]);

        Employee::create($request->all());
        return response()->json(['message' => 'Employee Created ']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $branches = Branch::all();
        $departments = Department::all();
        $designations = Designation::all();
        $shifts = Shift::all();

        return view('employee.edit', compact('employee', 'branches', 'departments', 'designations', 'shifts'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
           $request->validate([
            'branch_id'      => 'required|exists:branches,id',
            'department_id'  => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'shift_id'       => 'required|exists:shifts,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:employees,email,' . $employee->id,
            'phone'          => 'required|string|max:20',
            'father_name'    => 'nullable|string|max:255',
            'mother_name'    => 'nullable|string|max:255',
            'date_of_birth'  => 'required|date',
            'education'      => 'nullable|string|max:255',
            'skill'          => 'nullable|string|max:255',
            'join_date'      => 'required|date',
            'status'         => 'required|in:active,inactive',
        ]);

        $employee->update($request->all());

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
