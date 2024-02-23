<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('profile');

Route::middleware('auth')->group(function () {
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image');
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::patch('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

require __DIR__ . '/auth.php';
