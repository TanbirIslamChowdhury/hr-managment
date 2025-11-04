<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Payroll::with('employee')->get();
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($data, 200);
        }
        return view('payroll.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $employees = Employee::get();
        return view('payroll.create', compact('employees'));
    }

    public function get_employee_absent(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        if ($employee) {
            $absentCount = $employee->attendances()
                ->where('date', '>=', "{$request->year}-{$request->month}-01")
                ->where('date', '<=', "{$request->year}-{$request->month}-31")
                ->where('status', '1')
                ->count();
            return response()->json(['absent_days' => $absentCount]);
        }
        return response()->json(['absent_days' => 0]);
    }

    public function monthly_loan_deduction(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        if ($employee) {
            $loan=$employee->loans()
            ->where('start_date','<=',"{$request->year}-{$request->month}-01")
            ->where('finish_date','>=',"{$request->year}-{$request->month}-31")
            ->where('status','Active')->first();
           
            if($loan){
                // Ensure we don't deduct more than the remaining balance
                $deduction = min($loan->monthly_installment, $loan->remaining_balance);
                return response()->json(['loan_deduction' => $deduction]);
            }
            return response()->json(['loan_deduction' => 0]);
        }
        return response()->json(['loan_deduction' => 0]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();
        $employees = Employee::all();
        
        foreach ($employees as $employee) {
            Payroll::create([
                'employee_id' => $employee->id,
                'month' => $request->month,
                'year' => $request->year,
                'basic_salary' => $request->input("basic_salary_{$employee->id}"),
                'total_absent' => $request->input("total_absent_{$employee->id}"),
                'deduction_for_absent' => $request->input("deduction_for_absent_{$employee->id}"),
                'loan_deduction' => $request->input("loan_deduction_{$employee->id}"),
                'allowances' => $request->input("allowances_{$employee->id}"),
                'deductions' => $request->input("deductions_{$employee->id}"),
                'bonuses' => $request->input("bonuses_{$employee->id}"),
                'net_salary' => $request->input("net_salary_{$employee->id}"),
                'payment_status' => $request->input("payment_status_{$employee->id}"),
                'status' => $request->input("status_{$employee->id}"),
                'remarks' => $request->input("remarks_{$employee->id}"),
            ]);
        }

        return response()->json(['message' => 'Payroll Created ']);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $Payroll, Request $request)
    {
        $Payroll->load('employee');
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($Payroll, 200);
        }
        return view('payroll.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll, Request $request)
    {
        $payroll->load('employee');
        $employees = Employee::all();
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'payroll' => $payroll,
                'employees' => $employees
            ], 200);
        }
        return view('payroll.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $Payroll)
    {

        $Payroll->update([
            'employee_id'  => $request->employee_id,
            'month'        => $request->month,
            'year'         => $request->year,
            'basic_salary' => $request->basic_salary,
            'allowances'   => $request->allowances,
            'deductions'   => $request->deductions,
            'bonuses'      => $request->bonuses,
            'net_salary'   => $request->net_salary,
            'generated_at' => $request->generated_at,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Payroll updated successfully.', 'payroll' => $Payroll], 200);
        }
        return redirect()->route('payroll.index')->with('success', 'Payroll updated successfully.');
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll, Request $request)
    {
        $payroll->delete();
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Payroll deleted successfully.'], 200);
        }
        return redirect()->route('payroll.index')->with('success', 'Payroll deleted successfully.');
    }
}
