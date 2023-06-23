<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('auth.me');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'books'
], function ($router) {
    Route::get('/{id?}', [BookController::class, 'index'])->name('books.all');
    Route::post('/', [BookController::class, 'createBook'])->name('books.create');
    Route::put('/{id}', [BookController::class, 'updateBook'])->name('books.update');
    Route::delete('/{id}', [BookController::class, 'deleteBook'])->name('books.delete');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'list'
], function ($router) {
    Route::get('/books', [BookController::class, 'getAllBooks'])->name('list.books');
    Route::get('/authors', [BookController::class, 'getAllAuthors'])->name('list.authors');
    Route::get('/genres', [BookController::class, 'getAllGenres'])->name('list.genres');
});
