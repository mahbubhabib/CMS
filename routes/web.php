<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

Route::get('/', [PageController::class, 'index'])->name('pages.index');
Route::get('/create', [PageController::class, 'create'])->name('pages.create');
Route::post('/store', [PageController::class, 'store'])->name('pages.store');
Route::get('/show/{slug}', [PageController::class, 'show'])->where('slug', '.*')->name('pages.show');
Route::get('/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
Route::post('/update', [PageController::class, 'update'])->name('pages.update');
Route::delete('/{id}/destroy', [PageController::class, 'destroy'])->name('pages.destroy');
