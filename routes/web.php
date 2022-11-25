<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;

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
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('update-settings',[SettingController::class,'update'])->name('update-settings');
Route::get('connected',[SettingController::class,'connected'])->name('connected');
Route::get('api-callback',[SettingController::class,'callback'])->name('api-callback');
Route::get('oauth-error',[SettingController::class,'errorHandling'])->name('oauth-error');
