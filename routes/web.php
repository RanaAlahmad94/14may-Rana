<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'middleware' => 'auth',
    ],function (){
    Route::resource('/posts',PostController::class);
    Route::get('/user-posts',[PostController::class,'userPosts']);
    Route::get('/restore/{id}', [PostController::class, 'restore'])->name('posts.restore');
    Route::get('/restore-all', [PostController::class, 'restoreAll'])->name('posts.restoreAll');
    Route::get('/userPost', [PostController::class, 'userPosts'])->name('posts.userPost');
    Route::post('/posts',[PostController::class,'store'])->name('posts.store');
    Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
    Route::get('/show/{id}',[PostController::class,'show'])->name('posts.show');
    Route::post('/{id}/edit',[PostController::class,'edit'])->name('posts.edit');
    Route::get('/all-comments',[PostController::class, 'allComments'])->name('posts.allComments');
}

);
Route::get('admin',[AdminController::class,'getPosts'])->middleware('admin');
Route::get('posts', [PostController::class, 'index'])->middleware('admin')->name('posts.index');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
