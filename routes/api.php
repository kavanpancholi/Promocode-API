<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\PromocodeController;
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

Route::get('test', function() {
    return 'hello';
});
Route::resource('events', EventController::class);
Route::post('test12', [PromocodeController::class, 'apply']);
//Route::resource('promocodes', PromocodeController::class);
