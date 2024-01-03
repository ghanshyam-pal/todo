<?php

use App\Http\Controllers\crud;
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



Route::get('/', [crud::class,'index'])->name('index');
Route::post('save',[crud::class,'save'])->name('save');
Route::post('toggle-status',[crud::class,'toggle'])->name('toggle');
Route::post('delete',[crud::class,'delete'])->name('delete');

Route::get('get-trash', [crud::class,'index'])->name('index');
Route::get('all', [crud::class,'all'])->name('all');
Route::get('completed', [crud::class,'completed'])->name('all');

Route::get('incompleted', [crud::class,'incomplete'])->name('all');
Route::get('trash', [crud::class,'getTrash'])->name('all');
Route::post('restore', [crud::class,'restore'])->name('all');
Route::post('hard-delete', [crud::class,'hardDelete'])->name('all');

Route::post('update', [crud::class,'update'])->name('all');


