<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
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

Route::get('user', [UserController::class, 'index'])->name('user');

Route::get('example', [ExampleController::class, 'index'])->name('example');
Route::get('example-datatable',[ExampleController::class,'exampleDatatable']);
