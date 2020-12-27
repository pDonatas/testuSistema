<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestsController;
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
Route::middleware('auth')->group(function() {
    // Admin/Dėstytojo dalis
    Route::middleware('admin')->group(function() {
        Route::get('tests/all', [TestsController::class, 'show'])->name('tests.all');
        Route::get('tests/info/{id}', [TestsController::class, 'summary'])->name('showTestInfo');
        Route::get('tests/showTest/{test}/{user}', [TestsController::class, 'showUserTest'])->name('showUserTest');
    });
    Route::get('/', [HomeController::class, 'index']);
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    // Testai
    Route::get('test/{id}', [TestsController::class, 'beginTest'])->name('beginTest');
    Route::post('endTest/{id}', [TestsController::class, 'endTest'])->name('endTest');
    Route::get('showTest/{id}', [TestsController::class, 'showTest'])->name('showTest');
    Route::get('tests/done', [TestsController::class, 'done'])->name('tests.done');
    Route::resource('tests', TestsController::class);
});

Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'create'])->name('register');
Route::get('login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'login'])->name('login');
