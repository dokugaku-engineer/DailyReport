<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlackPostsController;
use App\Http\Controllers\SlackController;
use App\Http\Controllers\SpreadsheetsController;
use App\Http\Controllers\SlackToSpreadsheetController;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('v1.0/slack_posts',[SlackPostsController::class, 'store']);

Route::get('v1.0/slack',[SlackController::class, 'index']);
Route::post('v1.0/slack',[SlackController::class, 'store']);
Route::get('v1.0/slack',[SlackController::class, 'show']);
Route::put('v1.0/slack',[SlackController::class, 'update']);
Route::delete('v1.0/slack',[SlackController::class, 'destroy']);

Route::get('v1.0/spreadsheets',[SpreadsheetsController::class, 'index']);
Route::post('v1.0/spreadsheets',[SpreadsheetsController::class, 'store']);
Route::get('v1.0/spreadsheets',[SpreadsheetsController::class, 'show']);
Route::put('v1.0/spreadsheets',[SpreadsheetsController::class, 'update']);
Route::delete('v1.0/spreadsheets',[SpreadsheetsController::class, 'destroy']);

Route::get('v1.0/slack_to_spreadsheet',[SlackToSpreadsheetController::class, 'index']);
Route::post('v1.0/slack_to_spreadsheet',[SlackToSpreadsheetController::class, 'store']);
Route::get('v1.0/slack_to_spreadsheet',[SlackToSpreadsheetController::class, 'show']);
Route::put('v1.0/slack_to_spreadsheet',[SlackToSpreadsheetController::class, 'update']);
Route::delete('v1.0/slack_to_spreadsheet',[SlackToSpreadsheetController::class, 'destroy']);
