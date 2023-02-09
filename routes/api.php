<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUser;
use Illuminate\Http\Response;
use App\Http\Controllers\Auth\LogoutController;

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


Route::post('/signup', RegisterUser::class)->name('signup');
Route::post('/login', LoginController::class)->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/logout', LogoutController::class)->name('logout');
});

Route::any('{any}', function(){
    return response()->json([
    	'status' => 'error',
        'message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
})->where('any', '.*');
