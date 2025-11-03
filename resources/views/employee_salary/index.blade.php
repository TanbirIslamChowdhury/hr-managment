@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h2>Employee Salaries</h2>
                <a href="{{ route('employee-salary.create') }}" class="btn btn-primary btn-sm">Add Salary</a>
            </div>
            <div class="card-body">
                <table id="salaryTable" class="table table-hover table-product" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Basic Salary</th>
                            <th>Allowances</th>
                            <th>PF Enabled</th>
                            <th>PF %</th>
                            <th>Loan Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $salary)
                            <tr>
                                <td>{{ $salary->id }}</td>
                                <td>{{ $salary->employee->name }} </td>
                                <td>{{ $salary->basic_salary }}</td>
                                <td>{{ $salary->allowances }}</td>
                                <td>{{ $salary->pf_enabled ? 'Yes' : 'No' }}</td>
                                <td>{{ $salary->pf_percentage }}</td>
                                <td>{{ $salary->loan_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('employee-salary.edit', $salary->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employee-salary.destroy', $salary->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this salary?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Salaries Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
