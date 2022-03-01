<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WidgetController;
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
Route::get('example-datatable', [ExampleController::class, 'exampleDatatable']);
Route::get("example/create-modal", [ExampleController::class, 'form_modal']);
Route::get("example/create", [ExampleController::class, 'form_page']);
Route::get("example/update/{id}", [ExampleController::class, 'form_page']);
Route::get("example/update-modal/{id}", [ExampleController::class, 'form_modal']);
Route::post("example/save/{id}",[ExampleController::class,'save']);
Route::delete("example/delete/{id}",[ExampleController::class,'delete']);


/**
 * Widget Controller
 * To Control Widget [Export, Import, ...]
 */

Route::get('widget/export',[WidgetController::class,'form_export']);
Route::get('widget/import',[WidgetController::class,'form_import']);
Route::get('widget/import-progress',[WidgetController::class,'import_progress']);

Route::post('widget/export',[WidgetController::class,'export']);
Route::post('widget/import',[WidgetController::class,'import']);
