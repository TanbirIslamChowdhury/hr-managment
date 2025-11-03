<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProvidentFundController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CmpanyController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('shift', ShiftController::class);
Route::apiResource('attendence', AttendanceController::class);
Route::apiResource('eployeeSalary', EmployeeSalaryController::class);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('ProvidentFund', ProvidentFundController::class);
Route::apiResource('Payroll', PayrollController::class);
Route::apiResource('Organization', OrganizationController::class);
Route::apiResource('Loan', LoanController::class);
Route::apiResource('Leave', LeaveController::class);
Route::apiResource('designation', DesignationController::class);
Route::apiResource('department', DepartmentController::class);
Route::apiResource('Bonus', BonusController::class);
Route::apiResource('Branch', BranchController::class);
Route::apiResource('Company',CmpanyController::class);
Route::apiResource('Home',DashboardController::class);
Route::get('check-leave', [AttendanceController::class, 'checkLeave']);














