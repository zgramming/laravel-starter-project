<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterDataController;
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

/**
 * Master Category & Master Data
 */

Route::get('master-category',[MasterCategoryController::class,'index'])->name('master-category');
Route::get('master-category-datatable',[MasterCategoryController::class,'datatable'])->name('master-category.datatable');
Route::get('master-category/form_modal/{code_category}',[MasterCategoryController::class,'form_modal'])->name('master-category.form_modal');
Route::post('master-category/save/{id}',[MasterCategoryController::class,'save'])->name('master-category.save');
Route::post('master-category/export',[WidgetController::class,'export'])->name('master-category.export');
Route::delete('master-category/delete/{id}',[MasterCategoryController::class,'delete'])->name('master-category.delete');

Route::get('master-data/{code_category}',[MasterDataController::class,'index'])->name('master-data');
Route::get('master-data/datatable/{code_category}',[MasterDataController::class,'datatable'])->name('master-data.datatable');
Route::get('master-data/form_modal/{code_category?}/{id?}',[MasterDataController::class,'form_modal'])->name('master-data.form_modal');
Route::post('master-data/save/{id}',[MasterDataController::class,'save'])->name('master-data.save');
Route::delete('master-data/delete/{id}',[MasterDataController::class,'delete'])->name('master-data.delete');

/**
 * Example Tutorial
 */
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

Route::post('widget/export',[WidgetController::class,'export'])->name('export');
Route::post('widget/import',[WidgetController::class,'import'])->name('import');

Route::get('widget/view-image',[WidgetController::class,'view_image'])->name('view-image');
Route::get('widget/view-document',[WidgetController::class,'view_document'])->name('view-document');

