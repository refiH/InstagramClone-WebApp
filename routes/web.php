<?php

use App\Http\Controllers\C_Api;
use App\Http\Controllers\C_Auth;
use App\Http\Controllers\C_Pages;
use App\Http\Controllers\C_Post;
use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Glide\GlideImage;

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

// AUTH
Route::middleware('guest')->group(function () {
  Route::get('/login', [C_Auth::class, 'loginPage'])->name('auth.login-page');
  Route::get('/register', [C_Auth::class, 'registerPage'])->name('auth.register-page');

  Route::post('/login', [C_Auth::class, 'login'])->name('auth.login');
  Route::post('/register', [C_Auth::class, 'register'])->name('auth.register');
});
Route::get('/logout', [C_Auth::class, 'logout'])->name('auth.logout');

// MAIN
Route::middleware('auth')->group(function () {
  // Post-Related
  Route::post('/post', [C_Post::class, 'post'])->name('post');
  Route::post('/comment', [C_Post::class, 'comment'])->name('comment');
  Route::post('/like', [C_Post::class, 'like'])->name('like');
  Route::delete('/delete', [C_Post::class, 'delete'])->name('delete');

  // API-Related
  Route::get('/get-posts', [C_Api::class, 'getPosts'])->name('get-posts');
  Route::get('/get-random-posts', [C_Api::class, 'getRandomPosts'])->name('get-random-posts');
  Route::get('/get-user-posts/{username}', [C_Api::class, 'getUserPosts'])->name('get-user-posts');
  Route::get('/get-post/{post}', [C_Api::class, 'getPost'])->name('get-post');
  Route::get('/get-comments/{post}', [C_Api::class, 'getComments'])->name('get-comments');
  Route::get('/get-auth-user',  [C_Api::class, 'getAuthUser'])->name('get-auth-user');
  Route::post('/save-profile-image', [C_Api::class, 'saveProfileImage'])->name('save-profile-image');

  // Pages
  Route::get('/', [C_Pages::class, 'home'])->name('home');
  Route::get('/explore', [C_Pages::class, 'explore'])->name('explore');
  Route::get('/add', [C_Pages::class, 'add'])->name('add');
  Route::get('/user/{username}', [C_Pages::class, 'profile'])->name('profile');
  Route::get('/edit-profile', [C_Pages::class, 'editProfile'])->name('edit-profile');
});
