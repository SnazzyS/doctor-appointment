<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorScheduleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('doctors', [DoctorController::class, 'index']);
Route::post('doctors/create', [DoctorController::class, 'store']);
Route::put('doctors/update/{doctor}', [DoctorController::class, 'update']);
Route::delete('doctors/delete/{doctor}', [DoctorController::class, 'destroy']);

Route::get('customers', [CustomerController::class, 'index']);
Route::post('customers/create', [CustomerController::class, 'store']);
Route::post('customers/update/{customer}', [CustomerController::class, 'update']);
Route::delete('customers/delete/{customer}', [CustomerController::class, 'destroy']);


Route::post('doctor_schedule/create', [DoctorScheduleController::class, 'store']);

Route::post('appointments/create', [AppointmentController::class, 'store']);
