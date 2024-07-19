<?php

use App\Http\Controllers\Api\AdminGenController;
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

Route::apiResource('schools', SchoolController::class);
