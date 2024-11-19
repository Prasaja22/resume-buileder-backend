<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProjecController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api;" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/', [SiteController::class, 'index']);

    Route::post('/auth/login', [AuthController::class, 'login']); //->middleware(['signature']);
    Route::post('/auth/logout', [AuthController::class, 'logout']); //->middleware(['signature']);
    Route::get('/auth/profile', [AuthController::class, 'profile'])->middleware(['auth.api']);

    Route::get('/users', [UserController::class, 'index']); //->middleware(['auth.api', 'role:user.view']);
    Route::get('/users/{id}', [UserController::class, 'show']); //->middleware(['auth.api', 'role:user.view']);
    Route::post('/users', [UserController::class, 'store']); //->middleware(['auth.api', 'role:user.create|roles.view']);
    Route::put('/users/{id}', [UserController::class, 'update']); //->middleware(['auth.api', 'role:user.update||roles.view']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']); //->middleware(['auth.api', 'role:user.delete']);

    Route::get('/roles', [RoleController::class, 'index']); //->middleware(['auth.api', 'role:roles.view']);
    Route::get('/roles/{id}', [RoleController::class, 'show']); //->middleware(['auth.api', 'role:roles.view']);
    Route::post('/roles', [RoleController::class, 'store']); //->middleware(['auth.api', 'role:roles.create']);
    Route::put('/roles', [RoleController::class, 'update']); //->middleware(['auth.api', 'role:roles.update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']); //->middleware(['auth.api', 'role:roles.delete']);

    Route::get('/experiences', [ExperienceController::class, 'index']);
    Route::post('/experience', [ExperienceController::class, 'store']);
    Route::put('/experience/{id}', [ExperienceController::class, 'update']);

    Route::get('/educations', [EducationController::class, 'index']);
    Route::post('/education', [EducationController::class, 'store']);
    Route::get('/education/{id}', [EducationController::class, 'show']);
    Route::put('/education/{id}',[EducationController::class, 'update']);

    Route::get('/projects', [ProjecController::class, 'index']);
    Route::post('/project', [ProjecController::class ,'store']);
    Route::put('/project/{id}', [ProjecController::class ,'update']);
    Route::get('/project/{id}', [ProjecController::class, 'show']);

    Route::get('/summary', [SummaryController::class, 'index']);
    Route::post('/summary', [SummaryController::class, 'store']);
    Route::put('/summary/{id}', [SummaryController::class, 'update']);
});

Route::get('/', function () {
    return response()->failed(['Endpoint yang anda minta tidak tersedia']);
});

/**
 * Jika Frontend meminta request endpoint API yang tidak terdaftar
 * maka akan menampilkan HTTP 404
 */
Route::fallback(function () {
    return response()->failed(['Endpoint yang anda minta tidak tersedia']);
});
