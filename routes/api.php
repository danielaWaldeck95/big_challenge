<?php

use App\Enums\UserTypes;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UpdatePatientController;
use App\Http\Controllers\StoreSubmissionController;
use App\Http\Controllers\GetSubmissionsController;
use App\Http\Controllers\GetOneSubmissionController;
use App\Http\Controllers\FinishSubmissionController;
use App\Http\Controllers\AcceptSubmissionController;
use App\Http\Controllers\UploadPrescriptionController;

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
    Route::name('submissions.')->prefix('/submissions')->group(function () {
        Route::post('/', StoreSubmissionController::class)->name('store');
        Route::get('/', GetSubmissionsController::class)->name('index');
        Route::prefix('/{submission}')->group(function () {
            Route::get('/', GetOneSubmissionController::class)->name('show');
            Route::middleware(['role:' . UserTypes::DOCTOR->value])->group(function () {
                Route::post('/accept', AcceptSubmissionController::class)->name('accept');
                Route::post('/finish', FinishSubmissionController::class)->name('finish');
                Route::name('prescriptions.')->prefix('/prescriptions')->group(function () {
                    Route::post('/', UploadPrescriptionController::class)->name('store');
                });
            });
        });
});
    Route::put('/update', UpdatePatientController::class)->name('patient.update');
});
