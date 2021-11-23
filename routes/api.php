<?php

use App\Http\Controllers\Api\ApiAdminController;
use App\Http\Controllers\Api\ApiLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [ApiLoginController::class, 'login']);
Route::post('register', [ApiLoginController::class, 'register']);

Route::get('student-list', [ApiAdminController::class, 'studentList']);
Route::get('teacher-list', [ApiAdminController::class, 'teacherList']);
Route::post('approve-student', [ApiAdminController::class, 'approveStudent']);
Route::post('approve-teacher', [ApiAdminController::class, 'approveTeacher']);

Route::group(['middleware' => 'auth:api'], function(){
    
});


