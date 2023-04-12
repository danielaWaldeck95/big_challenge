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
use App\Http\Controllers\AcceptSubmissionController;

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
    Route::prefix('/submissions')->group(function () {
        Route::post('/', StoreSubmissionController::class)->name('submissions.store');
        Route::get('/', GetSubmissionsController::class)->name('submissions.index');
        Route::prefix('/{submission}')->group(function () {
            Route::get('/', GetOneSubmissionController::class)->name('submissions.show');
        });
        Route::group(['middleware' => ['role:' . UserTypes::DOCTOR->value]], function () {
            Route::post('{pendingSubmission}/accept', AcceptSubmissionController::class)->name('submissions.accept');
        });
});
    Route::put('/update', UpdatePatientController::class)->name('patient.update');
});
