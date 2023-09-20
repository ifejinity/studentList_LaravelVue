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

Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth'])->group(function(){
    Route::get('/home', [StudentController::class, 'index']);
    Route::get('/logout', [StudentController::class, 'logout']);
    Route::get('/create', [StudentController::class, 'create']);
    Route::delete('/delete', [StudentController::class, 'delete']);
    Route::delete('/multiDelete', [StudentController::class, 'delete']);
    Route::post('/createProcess', [StudentController::class, 'createStudent']);
    Route::get('/edit', [StudentController::class, 'edit']);
    Route::post('/editProcess', [StudentController::class, 'editStudent']);
});