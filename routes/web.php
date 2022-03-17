<?php

use App\Http\Controllers\AccessMenuController;
use App\Http\Controllers\AccessModulController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;
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

/**
 * START AuthController
 */
Route::get('login',[AuthController::class,'index'])->name('login');
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);

/**
 * START Management User
 */
Route::get('setting/user', [UserController::class, 'index']);
Route::get('setting/user/datatable', [UserController::class, 'datatable']);
Route::get('setting/user/form_modal/{id}', [UserController::class, 'form_modal']);
Route::post('setting/user/save/{id}', [UserController::class, 'save']);
Route::delete('setting/user/delete/{id}', [UserController::class, 'delete']);

/**
 * START Management Group User
 */
Route::get('setting/user-group', [UserGroupController::class, 'index']);
Route::get('setting/user-group/datatable', [UserGroupController::class, 'datatable']);
Route::get('setting/user-group/form_modal/{id}', [UserGroupController::class, 'form_modal']);
Route::post('setting/user-group/save/{id}', [UserGroupController::class, 'save']);
Route::delete('setting/user-group/delete/{id}', [UserGroupController::class, 'delete']);

/**
 * START APP_MODUL
 */
Route::get('setting/modul',[ModulController::class,'index']);
Route::get('setting/modul/datatable',[ModulController::class,'datatable']);
Route::get('setting/modul/form_modal/{id}',[ModulController::class,'form_modal']);
Route::post('setting/modul/save/{id}',[ModulController::class,'save']);
Route::delete('setting/modul/delete/{id}',[ModulController::class,'delete']);

/**
 * START APP MENU
 */
Route::get('setting/menu',[MenuController::class,'index']);
Route::get('setting/menu/datatable',[MenuController::class,'datatable']);
Route::get('setting/menu/form_modal/{id}',[MenuController::class,'form_modal']);
Route::post('setting/menu/save/{id}',[MenuController::class,'save']);
Route::delete('setting/menu/delete/{id}',[MenuController::class,'delete']);
/// Ajax Section
Route::get('ajax/menu/get_menu_by_modul/{id_modul}',[MenuController::class,'getMenuByModul']);


/**
 * START Access Modul
 */
Route::get('setting/access-modul',[AccessModulController::class,'index']);
Route::get('setting/access-modul/datatable',[AccessModulController::class,'datatable']);
Route::get('setting/access-modul/form_modal/{idUserGroup}',[AccessModulController::class,'form_modal']);
Route::post('setting/access-modul/save/{idUserGroup}',[AccessModulController::class,'save']);

/**
 * START Access Menu
 */
Route::get('setting/access-menu',[AccessMenuController::class,'index']);
Route::get('setting/access-menu/datatable',[AccessMenuController::class,'datatable']);
Route::get('setting/access-menu/form_modal/{idUserGroup}',[AccessMenuController::class,'form_modal']);
Route::post('setting/access-menu/save/{idUserGroup}',[AccessMenuController::class,'save']);

/**
 * START Master Category & Master Data
 */
Route::get('setting/master-category',[MasterCategoryController::class,'index'])->name('master-category');
Route::get('setting/master-category-datatable',[MasterCategoryController::class,'datatable'])->name('master-category.datatable');
Route::get('setting/master-category/form_modal/{code_category}',[MasterCategoryController::class,'form_modal'])->name('master-category.form_modal');
Route::post('setting/master-category/save/{id}',[MasterCategoryController::class,'save'])->name('master-category.save');
Route::post('setting/master-category/export',[WidgetController::class,'export'])->name('master-category.export');
Route::delete('setting/master-category/delete/{id}',[MasterCategoryController::class,'delete'])->name('master-category.delete');

Route::get('setting/master-data/{code_category}',[MasterDataController::class,'index'])->name('master-data');
Route::get('setting/master-data/datatable/{code_category}',[MasterDataController::class,'datatable'])->name('master-data.datatable');
Route::get('setting/master-data/form_modal/{code_category?}/{id?}',[MasterDataController::class,'form_modal'])->name('master-data.form_modal');
Route::post('setting/master-data/save/{id}',[MasterDataController::class,'save'])->name('master-data.save');
Route::delete('setting/master-data/delete/{id}',[MasterDataController::class,'delete'])->name('master-data.delete');

/**
 * Example Tutorial
 */
Route::get('setting/example', [ExampleController::class, 'index'])->name('example');
Route::get('setting/example-datatable', [ExampleController::class, 'exampleDatatable']);
Route::get("setting/example/create-modal", [ExampleController::class, 'form_modal']);
Route::get("setting/example/create", [ExampleController::class, 'form_page']);
Route::get("setting/example/update/{id}", [ExampleController::class, 'form_page']);
Route::get("setting/example/update-modal/{id}", [ExampleController::class, 'form_modal']);
Route::post("setting/example/save/{id}",[ExampleController::class,'save']);
Route::delete("setting/example/delete/{id}",[ExampleController::class,'delete']);


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
