<?php

use App\Http\Controllers\crud;
use App\Http\Middleware\loginGuard;
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


Route::middleware([loginGuard::class])->group(function () {

    Route::get('/', [crud::class,'index'])->name('index');
    Route::post('save',[crud::class,'save'])->name('save');
    Route::post('toggle-status',[crud::class,'toggle'])->name('toggle');
    Route::post('delete',[crud::class,'delete'])->name('delete');

    // Route::get('get-trash', [crud::class,'index'])->name('get-trash');
    Route::get('all', [crud::class,'all'])->name('all');
    Route::get('completed', [crud::class,'completed'])->name('completed');

    Route::get('incompleted', [crud::class,'incomplete'])->name('incompleted');
    Route::get('trash', [crud::class,'getTrash'])->name('trash');
    Route::post('restore', [crud::class,'restore'])->name('restore');
    Route::post('hard-delete', [crud::class,'hardDelete'])->name('hard-delete');

    Route::post('update', [crud::class,'update'])->name('update');

   
});


Route::get('login', [crud::class,'login'])->name('login');
Route::get('register', [crud::class,'register'])->name('register');
Route::post('auth', [crud::class,'auth'])->name('auth');
Route::post('reg', [crud::class,'reg'])->name('reg');
Route::get('logout', [crud::class,'logout'])->name('logout');


