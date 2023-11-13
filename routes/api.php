<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FakeData;
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
Route::get('/meals', [ApiController::class, 'getJsonResponse']);

Route::get('/fake-data', [FakeData::class, 'generateFakeData']);
Route::middleware('auth:sanctum')->get('/use    r', function (Request $request) {
    return $request->user();
});
