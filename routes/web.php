<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::inertia('/index', 'index')->name('index')->middleware('guest');

Route::match(['post', 'get'], '/login', [UserController::class, 'login']);
Route::get('/home', [StudentController::class, 'index'])->middleware('auth');
Route::get('/logout', [StudentController::class, 'logout'])->middleware('auth');
Route::get('/create', [StudentController::class, 'create'])->middleware('auth');
Route::delete('/delete', [StudentController::class, 'delete'])->middleware('auth');
Route::post('/createProcess', [StudentController::class, 'createStudent'])->middleware('auth');
Route::get('/edit', [StudentController::class, 'edit'])->middleware('auth');