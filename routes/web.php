<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/dashboard', [App\Http\Controllers\PublicController::class, 'getDashboard'])->name('dashboard');

//Laravel version 8 'register' => false not working
Auth::routes(['register' => false]);

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::post('/store', [App\Http\Controllers\ExcelFileController::class, 'store'])->name('storeExcelFile');
Route::get('/fetch', [App\Http\Controllers\ExcelFileController::class, 'fetch'])->name('FetchExcelFile');
Route::get('/search', [App\Http\Controllers\ExcelFileController::class, 'search'])->name('getSearches');
