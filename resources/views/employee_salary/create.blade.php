

@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h2>Add Employee Salary</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('employee-salary.store') }}" method="POST">
                    @csrf

                    {{-- Employee Dropdown --}}
                    <div class="form-group">
                        <label for="employee_id">Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            @foreach($data as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Basic Salary --}}
                    <div class="form-group">
                        <label for="basic_salary">Basic Salary</label>
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary"
                               placeholder="Enter Basic Salary" required>
                    </div>

                    {{-- Allowances --}}
                    <div class="form-group">
                        <label for="allowances">Allowances</label>
                        <input type="number" class="form-control" id="allowances" name="allowances"
                               placeholder="Enter Allowances" required>
                    </div>

                    {{-- PF Enabled --}}
                    <div class="form-group">
                        <label for="pf_enabled">PF Enabled</label>
                        <select class="form-control" id="pf_enabled" name="pf_enabled" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    {{-- PF Percentage --}}
                    <div class="form-group">
                        <label for="pf_percentage">PF Percentage</label>
                        <input type="number" class="form-control" id="pf_percentage" name="pf_percentage"
                               placeholder="Enter PF Percentage">
                    </div>

                    {{-- Loan Active --}}
                    <div class="form-group">
                        <label for="loan_active">Loan Active</label>
                        <select class="form-control" id="loan_active" name="loan_active" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Salary</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
