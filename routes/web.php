<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\AuthorController::class, 'index'])->name('authors.index');
Route::get('/create', [App\Http\Controllers\AuthorController::class, 'create'])->name('authors.create');
Route::post('/store', [App\Http\Controllers\AuthorController::class, 'store'])->name('file.store');
