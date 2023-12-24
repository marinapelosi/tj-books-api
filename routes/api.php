<?php

use App\Http\Controllers\User\PassportAuthController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\Report\DashboardController;
use App\Http\Controllers\Report\BookByAuthorReportController;
use App\Http\Controllers\Report\BookByAuthorGroupingAuthorsReportController;
use App\Http\Controllers\Report\BookByAuthorGroupingBooksReportController;
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

Route::post('/login', [PassportAuthController::class, 'login'])->name('login');

//Route::middleware('auth:api')->group(function () {
    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::post('/filter', [BookController::class, 'filter']);
        Route::get('/{id}', [BookController::class, 'show']);
        Route::post('/', [BookController::class, 'store']);
        Route::put('/{id}', [BookController::class, 'update']);
        Route::delete('/{id}', [BookController::class, 'destroy']);
    });

    Route::prefix('authors')->group(function () {
        Route::get('/', [AuthorController::class, 'index']);
        Route::post('/filter', [AuthorController::class, 'filter']);
        Route::get('/{id}', [AuthorController::class, 'show']);
        Route::post('/', [AuthorController::class, 'store']);
        Route::put('/{id}', [AuthorController::class, 'update']);
        Route::delete('/{id}', [AuthorController::class, 'destroy']);
    });

    Route::prefix('subjects')->group(function () {
        Route::get('/', [SubjectController::class, 'index']);
        Route::post('/filter', [SubjectController::class, 'filter']);
        Route::get('/{id}', [SubjectController::class, 'show']);
        Route::post('/', [SubjectController::class, 'store']);
        Route::put('/{id}', [SubjectController::class, 'update']);
        Route::delete('/{id}', [SubjectController::class, 'destroy']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'generateReport']);
        Route::get('/dashboard-counters', [DashboardController::class, 'generateCountersReport']);
        Route::get('/dashboard-topfives', [DashboardController::class, 'generateTopFivesReport']);
        Route::get('/dashboard-lastbooks', [DashboardController::class, 'generateLastBooksReport']);
        Route::get('/book-by-author', [BookByAuthorReportController::class, 'generateReport']);
        Route::get('/book-by-author-grouping-authors', [BookByAuthorGroupingAuthorsReportController::class, 'generateReport']);
        Route::get('/book-by-author-grouping-books', [BookByAuthorGroupingBooksReportController::class, 'generateReport']);
    });
//});
