<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IbsAreaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IbsDivisionController;
use App\Http\Controllers\IbsEmployeeController;
use App\Http\Controllers\IbsPositionController;
use App\Http\Controllers\IbsDepartmentController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\IbsTroubleTicketController;

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

// Route::get('/dashboard', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', [AuthenticationController::class, 'index'])->middleware('guest');
Route::get('/login', [AuthenticationController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticationController::class, 'authenticate']);
// Route::get('/login', [AuthenticationController::class, 'index'])->name('login')->middleware('guest');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


Route::resource('sys/user_account', UserController::class);
Route::resource('sys/user_permission', UserPermissionController::class);

// Route::put('hrd/employee/{id}/approve', IbsEmployeeController::class)->name('employee.approve');
Route::resource('hrd/employee', IbsEmployeeController::class);
Route::resource('hrd/department', IbsDepartmentController::class);
Route::resource('hrd/division', IbsDivisionController::class);
Route::resource('hrd/position', IbsPositionController::class);
Route::resource('hrd/area', IbsAreaController::class);
Route::resource('it/trouble_ticket', IbsTroubleTicketController::class);
