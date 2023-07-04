<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/tag_view', [App\Http\Controllers\NewTagContoller::class, 'show_tags'])->name('show_tags');
Route::post('/tag_new', [App\Http\Controllers\NewTagContoller::class, 'new_tag'])->name('new_tag');
Route::post('/tag_edit', [App\Http\Controllers\NewTagContoller::class, 'edit_tag'])->name('edit_tag');
Route::post('/tag_delete', [App\Http\Controllers\NewTagContoller::class, 'delete_tag'])->name('delete_tag');
