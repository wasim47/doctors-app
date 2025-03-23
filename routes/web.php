<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\CommonController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\SpecialtyController;
use App\Http\Controllers\admin\BranchController;
use App\Http\Controllers\admin\HospitalController;
use App\Http\Controllers\admin\DoctorController;
use App\Http\Controllers\admin\PatientController;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});


Route::prefix('admin')->middleware('auth:administration')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::resource('sepeciality', SpecialtyController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('hospital', HospitalController::class);
    Route::resource('doctor', DoctorController::class);
    Route::resource('patient', PatientController::class);
    Route::resource('user', UserController::class);
    Route::resource('schedule', ScheduleController::class);


    Route::any('permissions', [CommonController::class, 'permissions'])->name('permissions');
    Route::get('update-slug', [CommonController::class, 'updateSlug']);
    Route::any('masterdelete', [CommonController::class, 'deletedata'])->name('masterdelete');
});
