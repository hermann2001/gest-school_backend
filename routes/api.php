<?php

use App\Http\Controllers\Api\AdminGenController;
use App\Http\Controllers\Api\AdminSchoolController;
use App\Http\Controllers\Api\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('connexionAdminGen/connect/{connect}', [AdminGenController::class, 'connect']);
Route::get('deconnexionAdminGen', [AdminGenController::class, 'disconnect']);

Route::get('allSchools', [SchoolController::class, 'getSchools']);
Route::post('createSchool', [SchoolController::class, 'createSchool']);
Route::get('confirmCreateSchool/{id}', [SchoolController::class, 'confirm']);
Route::get('resendLinkConfirm/{id}/{connect}', [SchoolController::class, 'resend_verified_mail']);
Route::get('deleteSchool/{id}/{connect}', [SchoolController::class, 'deleteSchool']);

Route::post('school/connexionAdminSchool', [AdminSchoolController::class, 'connect']);
