<?php

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

Route::get('promocodes/active', [PromocodeController::class, 'active']);
Route::put('promocodes/{promocode}/activate', [PromocodeController::class, 'activate']);
Route::put('promocodes/{promocode}/deactivate', [PromocodeController::class, 'deactivate']);
Route::post('promocodes/apply', [PromocodeController::class, 'apply']);
Route::resource('promocodes', PromocodeController::class);
