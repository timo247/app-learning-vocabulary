<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VocabularyController;

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



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('vocabularies', [VocabularyController::class, 'redirectToVocabulariesList']);
    Route::post('/update', [VocabularyController::class, 'update']);
    Route::post('/create', [VocabularyController::class, 'store']);
    Route::delete('/delete', [VocabularyController::class, 'destroy']);
});

Route::post("login", [UserController::class, 'authenticate'])->name('authenticate');
Route::post("logout", [UserController::class, 'logout']);
// Route::get('/login', function () {
//     return view('auth.login');
// });