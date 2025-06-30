<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyRefrenceController;
use App\Http\Controllers\InternshipRequestController;
use App\Http\Controllers\WeighingResultController;
use App\Http\Controllers\InternshipScheduleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CriteriaWeightController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'processLogin'])->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // company-refrences
    Route::get('company-refrences', [CompanyRefrenceController::class, 'index'])->name('company-refrences.index');
    Route::post('company-refrences', [CompanyRefrenceController::class, 'show_refrences'])->name('company-refrences.show-refrences');
    Route::get('company-refrences/request-internship', [CompanyRefrenceController::class, 'request_internship'])->name('company-refrences.request-internship');

    // Internship Request
    Route::resource('internship-request', InternshipRequestController::class);
    Route::post('internship-request/upload', [InternshipRequestController::class, 'upload'])->name('internship-request.upload');
    Route::post('internship-request/{id}/form', [InternshipRequestController::class, 'form'])->name('internship-request.form');
    Route::get('internship-request/{id}/download', [InternshipRequestController::class, 'download'])->name('internship-request.download');
    Route::get('internship-request/{id}/delete', [InternshipRequestController::class, 'destroy'])->name('internship-request.delete');

    // Weighing Result
    Route::get('weighing-result', [WeighingResultController::class, 'index'])->name('weighing-result.index');
    Route::get('weighing-result/{id}/download', [WeighingResultController::class, 'download'])->name('weighing-result.download');
    Route::get('weighing-result/process-calculation', [WeighingResultController::class, 'process'])->name('weighing-result.process');
    Route::get('weighing-result/export', [WeighingResultController::class, 'export'])->name('weighing-result.export');

    // Internship Schedule
    Route::resource('internship-schedule', InternshipScheduleController::class)->except('show');

    Route::get('internship-schedule/{id}/download', [InternshipScheduleController::class, 'download'])->name('internship-schedule.download');
    Route::get('internship-schedule/export', [InternshipScheduleController::class, 'export'])->name('internship-schedule.export');

    Route::get('role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');
    Route::get('role-permission/{id}/edit', [RolePermissionController::class, 'edit'])->name('role-permission.edit');
    Route::put('role-permission/{id}', [RolePermissionController::class, 'update'])->name('role-permission.update');
    Route::get('role-permission/{id}/delete', [RolePermissionController::class, 'destroy'])->name('role-permission.delete');

    // User Management
    Route::resource('users-management', UserController::class)->except('show');
    Route::get('users-management/{id}/delete', [UserController::class, 'destroy'])->name('users-management.delete');

    // Student Management
    Route::resource('students-management', StudentController::class)->except('show');
    Route::post('students-management/upload', [StudentController::class, 'upload'])->name('students-management.upload');
    Route::get('students-management/{id}/delete', [StudentController::class, 'destroy'])->name('students-management.delete');

    // Major Management
    Route::resource('majors-management', MajorController::class)->except('show');
    Route::get('majors-management/{id}/delete', [MajorController::class, 'destroy'])->name('majors-management.delete');

    // Companies Management
    Route::resource('companies-management', CompanyController::class)->except('show');
    Route::get('companies-management/{id}/delete', [CompanyController::class, 'destroy'])->name('companies-management.delete');

    // Criteria Weight Management
    Route::resource('criteria-weight-management', CriteriaWeightController::class)->except('show');
    Route::get('criteria-weight-management/{id}/delete', [CriteriaWeightController::class, 'destroy'])->name('criteria-weight-management.delete');
});
