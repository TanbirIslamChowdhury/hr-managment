
@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h2>Edit Employee Salary</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('employee-salary.update', $salary->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Employee Dropdown --}}
                    <div class="form-group">
                        <label for="employee_id">Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $salary->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Basic Salary --}}
                    <div class="form-group">
                        <label for="basic_salary">Basic Salary</label>
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary"
                               value="{{ $salary->basic_salary }}" required>
                    </div>

                    {{-- Allowances --}}
                    <div class="form-group">
                        <label for="allowances">Allowances</label>
                        <input type="number" class="form-control" id="allowances" name="allowances"
                               value="{{ $salary->allowances }}" required>
                    </div>

                    {{-- PF Enabled --}}
                    <div class="form-group">
                        <label for="pf_enabled">PF Enabled</label>
                        <select class="form-control" id="pf_enabled" name="pf_enabled" required>
                            <option value="">Select</option>
                            <option value="1" {{ $salary->pf_enabled ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$salary->pf_enabled ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    {{-- PF Percentage --}}
                    <div class="form-group">
                        <label for="pf_percentage">PF Percentage</label>
                        <input type="number" class="form-control" id="pf_percentage" name="pf_percentage"
                               value="{{ $salary->pf_percentage }}">
                    </div>

                    {{-- Loan Active --}}
                    <div class="form-group">
                        <label for="loan_active">Loan Active</label>
                        <select class="form-control" id="loan_active" name="loan_active" required>
                            <option value="">Select</option>
                            <option value="1" {{ $salary->loan_active ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$salary->loan_active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Salary</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
