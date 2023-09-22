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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function(){
    Route::inertia('/', 'index')->name('index');
    Route::get('/login', [UserController::class, 'login']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/logout', [UserController::class, 'logout']);

    Route::group(['middleware' => ['role:Super-Admin|admin|viewer']], function () {
        Route::get('/home', [StudentController::class, 'index']);
    });

    Route::group(['middleware' => ['role:Super-Admin|admin']], function () {
        Route::get('/create', [StudentController::class, 'create']);
        Route::post('/createProcess', [StudentController::class, 'createStudent']);
        Route::get('/edit/{id_number}', [StudentController::class, 'edit']);
        Route::post('/editProcess', [StudentController::class, 'editStudent']);
    });

    Route::group(['middleware' => ['role:Super-Admin']], function () {
        Route::delete('/delete', [StudentController::class, 'delete']);
        Route::delete('/multiDelete', [StudentController::class, 'delete']);
    });

    // practice
    Route::inertia('/manager', 'permissionManager');
    Route::get('/createrole', [UserController::class, 'createRole']);
});