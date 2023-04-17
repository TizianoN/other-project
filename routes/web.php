<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
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

Route::get('/', [GuestHomeController::class, 'index']);

Route::get('/home', [PostController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function() {
        Route::resource('posts', PostController::class);
            // ->parameters(['posts' => 'post:slug']);
    });

Route::middleware('auth')
    ->prefix('/profile') // * tutti gli url hanno il prefisso "/profile"
    ->name('profile.') // * tutti i nomi delle rotte hanno il prefisso "profile".
    ->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

require __DIR__ . '/auth.php';