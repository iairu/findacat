<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupsController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\CatMarriagesController;
use App\Http\Controllers\CatsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CouplesController;
use App\Http\Controllers\FamilyActionsController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\HomeController;

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


Route::get('/', [CatsController::class, 'search']);

Route::controller(HomeController::class)->group(function () {
    Route::get('home', 'index')->name('home');
    Route::get('profile', 'index')->name('profile');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'index')->name('register');
    Route::post('register', 'create')->name('register');
});

Route::controller(UsersController::class)->group(function () {
    Route::get('authorize', 'index')->name('authorize');
    Route::post('register-user', 'create')->name('authorize');
});

Route::controller(FamilyActionsController::class)->group(function () {
    Route::post('family-actions/{cat}/set-sire', 'setSire')->name('family-actions.set-sire');
    Route::post('family-actions/{cat}/set-dam', 'setDam')->name('family-actions.set-dam');
    Route::post('family-actions/{cat}/add-child', 'addChild')->name('family-actions.add-child');
    Route::post('family-actions/{cat}/add-wife', 'addWife')->name('family-actions.add-wife');
    Route::post('family-actions/{cat}/add-husband', 'addHusband')->name('family-actions.add-husband');
    Route::post('family-actions/{cat}/set-parent', 'setParent')->name('family-actions.set-parent');
});

Route::controller(CatsController::class)->group(function () {
    Route::get('profile-search', 'search')->name('cats.search');
    Route::get('cats/{cat}', 'show')->name('cats.show');
    Route::get('cats/{cat}/edit', 'edit')->name('cats.edit');
    Route::post('cats/{cat}', 'update')->name('cats.update');
    Route::get('cats/{cat}/chart', 'chart')->name('cats.chart');
    Route::get('cats/{cat}/tree', 'tree')->name('cats.tree');
    Route::get('cats/test', 'test')->name('cats.test-mating');
    Route::get('cats/{cat}/tree/{generations}', 'tree')->name('cats.tree');
    Route::get('cats/{cat}/death', 'death')->name('cats.death');
    Route::delete('cats/{cat}', 'destroy')->name('cats.destroy');
});

Route::get('cats/{cat}/marriages', [CatMarriagesController::class, 'index'])->name('cats.marriages');

Route::get('birthdays', [BirthdayController::class, 'index'])->name('birthdays.index');

/**
 * Couple/Marriages Routes
 */
Route::controller(CouplesController::class)->group(function () {
    Route::get('couples/{couple}', 'show')->name('couples.show');
    Route::get('couples/{couple}/edit', 'edit')->name('couples.edit');
    Route::patch('couples/{couple}', 'update')->name('couples.update');
});


/**
 * Admin only routes
 */
Route::group(['middleware' => 'admin'], function () {
    /**
     * Backup Restore Database Routes
     */
    Route::controller(BackupsController::class)->group(function () {
        Route::post('backups/issue', 'issue')->name('backups.issue');
        Route::post('backups/export', 'export')->name('backups.export');
        Route::post('backups/import', 'import')->name('backups.import');
        Route::post('backups/export_breeds', 'export_breeds')->name('backups.export_breeds');
        Route::post('backups/import_breeds', 'import_breeds')->name('backups.import_breeds');
        Route::post('backups/export_ems', 'export_ems')->name('backups.export_ems');
        Route::post('backups/import_ems', 'import_ems')->name('backups.import_ems');
        Route::post('backups/upload', 'upload')->name('backups.upload');
        Route::post('backups/{fileName}/restore', 'restore')->name('backups.restore');
        Route::get('backups/{fileName}/dl', 'download')->name('backups.download');
    });
    Route::resource('backups', BackupsController::class);
    Route::post('upload', [FilesController::class,'store']);
});