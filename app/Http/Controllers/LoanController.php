<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Employee;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Loan::with('employee')->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id'         => 'required|exists:employees,id',
            'loan_amount'         => 'required|numeric|min:0',
            'monthly_installment' => 'required|numeric|min:0',
            'start_date'          => 'required|date',
            'status'              => 'required',
        ]);

        Loan::create([
            'employee_id'         => $request->employee_id,
            'loan_amount'         => $request->loan_amount,
            'monthly_installment' => $request->monthly_installment,
            'remaining_balance'   => $request->loan_amount,
            'start_date'          => $request->start_date,
            'finish_date'         => $request->finish_date,
            'number_of_installment'=> $request->number_of_installment,
            'status'              => $request->status,
        ]);
        
        return response()->json(['message' => 'Loan Created ']);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
         $request->validate([
            'employee_id'         => 'required|exists:employees,id',
            'loan_amount'         => 'required|numeric|min:0',
            'monthly_installment' => 'required|numeric|min:0',
            'remaining_balance'   => 'required|numeric|min:0',
            'start_date'          => 'required|date',
            'status'              => 'required',
        ]);

        $loan->update([
            'employee_id'         => $request->employee_id,
            'loan_amount'         => $request->loan_amount,
            'monthly_installment' => $request->monthly_installment,
            'remaining_balance'   => $request->remaining_balance,
            'start_date'          => $request->start_date,
            'finish_date'         => $request->finish_date,
            'number_of_installment'=> $request->number_of_installment,
            'actual_finish_date'  => $request->actual_finish_date,
            'status'              => $request->status,
        ]);

        return redirect()->route('loan.index')->with('success', 'Loan updated successfully.');
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loan.index')->with('success', 'Loan deleted successfully.');
   
    }
}
