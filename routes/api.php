<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;

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


Route::middleware('auth:sanctum')->group(function () {
    // Mendapatkan semua berita
    Route::get('/news', [NewsController::class, 'index']);

    // Menyimpan berita baru
    Route::post('/news', [NewsController::class, 'store']);

    // Mendapatkan detail berita berdasarkan ID
    Route::get('/news/{id}', [NewsController::class, 'show']);

    // Memperbarui berita berdasarkan ID
    Route::put('/news/{id}', [NewsController::class, 'update']);

    // Menghapus berita berdasarkan ID
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);

    // Melakukan pencarian berita berdasarkan kata kunci
    Route::get('/news/search/{query}', [NewsController::class, 'search']);

    // Mendapatkan berita olahraga
    Route::get('/news/category/sport', [NewsController::class, 'sport']);

    // Mendapatkan berita finansial
    Route::get('/news/category/finance', [NewsController::class, 'finance']);

    // Mendapatkan berita otomotif
    Route::get('/news/category/automotive', [NewsController::class, 'automotive']);
});

# untuk register dan login pake auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
