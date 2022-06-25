<?php

use App\Http\Controllers\FieldController;
use App\Http\Controllers\SubscriberController;
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


Route::prefix('v1')->group(function () {

//    Route::get('fields', [FieldController::class, 'index']);

    Route::get('subscriber-statues', [SubscriberController::class, 'statuses']);
    Route::get('subscriber', [SubscriberController::class, 'index']);
    Route::get('subscriber/{subscriber}', [SubscriberController::class, 'show']);
    Route::post('subscriber', [SubscriberController::class, 'store']);
    Route::put('subscriber/{id}', [SubscriberController::class, 'store']);

    Route::resources(['fields' => FieldController::class]);
});
