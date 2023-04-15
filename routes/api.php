<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'gym', 'namespace' => 'App\Http\Controllers\Api', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('lessons', LessonController::class);
    Route::apiResource('cards', CardController::class);
    Route::apiResource('bookings', BookingController::class);
});