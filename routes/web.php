<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\IbsAreaController;
use App\Http\Controllers\HR\IbsDivisionController;
use App\Http\Controllers\HR\IbsEmployeeController;
use App\Http\Controllers\HR\IbsPositionController;
use App\Http\Controllers\HR\IbsDepartmentController;
use App\Http\Controllers\HR\IbsSuperiorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\IT\IbsTroubleTicketController;
use App\Http\Controllers\SYS\UserPermissionController;
use App\Http\Controllers\SYS\IbsVendorController;
use App\Http\Controllers\SYS\UserController;
use App\Http\Controllers\SYS\IbsInformationController;
use App\Http\Middleware\Cek_access;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [AuthenticationController::class, 'index'])->middleware('guest');
Route::get('/login', [AuthenticationController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticationController::class, 'authenticate']);
// Route::get('/login', [AuthenticationController::class, 'index'])->name('login')->middleware('guest');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// SYS 
Route::resource('sys/user_account', UserController::class);
Route::resource('sys/user_permission', UserPermissionController::class);
Route::resource('sys/vendor', IbsVendorController::class);
Route::resource('sys/information', IbsInformationController::class);

// Route::put('hrd/employee/{id}/approve', IbsEmployeeController::class)->name('employee.approve');
// HR

Route::post('hrd/employee/upload', [IbsEmployeeController::class, 'upload']);
Route::resource('hrd/employee', IbsEmployeeController::class);
Route::resource('hrd/department', IbsDepartmentController::class);
Route::resource('hrd/division', IbsDivisionController::class);
Route::resource('hrd/position', IbsPositionController::class);
Route::resource('hrd/area', IbsAreaController::class);
Route::resource('hrd/superior', IbsSuperiorController::class);

// IT
Route::resource('it/trouble_ticket', IbsTroubleTicketController::class);
Route::resource('it/trouble_ticket', IbsTroubleTicketController::class);
