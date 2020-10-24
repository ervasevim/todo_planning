<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something grnaeat!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [Controller::class, 'index']);
Route::get('get-api-data', [Controller::class, 'getApiData']);
Route::get('create-planning', [Controller::class, 'createPlanning'])->name('create-planning');
Route::get('list-task', [Controller::class, 'taskList']);