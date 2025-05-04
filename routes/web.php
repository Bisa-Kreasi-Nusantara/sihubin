<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

    
    Route::get('/', [DashboardController::class, 'index']);

    // User Management
    Route::resource('users-management', UserController::class);
    Route::get('users-management/{id}/delete', [UserController::class, 'destroy'])->name('users-management.delete');

    // Student Management
    Route::resource('students-management', StudentController::class);
    Route::get('students-management/{id}/delete', [StudentController::class, 'destroy'])->name('students-management.delete');
    
    // Major Management
    Route::resource('majors-management', MajorController::class);
    Route::get('majors-management/{id}/delete', [MajorController::class, 'destroy'])->name('majors-management.delete');
    
    // Companies Management
    Route::resource('companies-management', CompanyController::class);
    Route::get('companies-management/{id}/delete', [CompanyController::class, 'destroy'])->name('companies-management.delete');
    
    // Criteria Weight Management
    Route::resource('criteria-weight-management', CriteriaWeightController::class);
    Route::get('criteria-weight-management/{id}/delete', [CriteriaWeightController::class, 'destroy'])->name('criteria-weight-management.delete');
});