<?php

use App\Http\Controllers\ApiTestMatchesController;
use App\Http\Controllers\ApiRulesController;
use App\Http\Controllers\ApiUserMatchDayController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/matches', ApiTestMatchesController::class);
Route::resource('/points', ApiUserMatchDayController::class);
Route::resource('/rules', ApiRulesController::class);
