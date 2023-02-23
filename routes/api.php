<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UpdatePatientController;
use App\Http\Controllers\StoreSubmissionController;

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


Route::post('/signup', RegisterUserController::class)->name('signup');
Route::post('/login', LoginController::class)->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/logout', LogoutController::class)->name('logout');


    Route::get('/submissions', GetSubmissionsController::class)->name('patient.submissions.index');
    Route::post('/submission', StoreSubmissionController::class)->name('submission');
    Route::put('/update', UpdatePatientController::class)->name('patient.update');
});
