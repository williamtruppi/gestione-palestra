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
    Route::group(['prefix' => 'customers'], function() {
        Route::get('/', 'CustomerController@index');
        Route::get('/checkabbonamenti', 'CustomerController@CheckAbbonamenti');
        Route::post('/store', 'CustomerController@store');
        Route::put('/update/{customer}', 'CustomerController@update');
        Route::patch('/update/{customer}', 'CustomerController@update');
        Route::get('/{customer}', 'CustomerController@show');
        Route::delete('/{customer}', 'CustomerController@destroy');
    });
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('lessons', LessonController::class);
    Route::apiResource('cards', CardController::class);
    Route::apiResource('bookings', BookingController::class);
});