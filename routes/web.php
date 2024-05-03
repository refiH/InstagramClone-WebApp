<?php

use App\Http\Controllers\C_Auth;
use App\Models\M_Post;
use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('/login', [C_Auth::class, 'loginPage'])->name('auth.login-page');
Route::get('/register', [C_Auth::class, 'registerPage'])->name('auth.register-page');

Route::post('/login', [C_Auth::class, 'login'])->name('auth.login');
Route::post('/register', [C_Auth::class, 'register'])->name('auth.register');

Route::get('/logout', [C_Auth::class, 'logout'])->name('auth.logout');

// MAIN
Route::middleware('auth')->group(function () {
  // Home
  Route::get('/', function () {
    $data['postsCount'] = M_Post::count();

    return Inertia::render('Home', $data);
  })->name('home');

  // Explore
  Route::get('/explore', function () {
    $data['postsCount'] = M_Post::count();

    return Inertia::render('Explore', $data);
  })->name('explore');

  // Add
  Route::get('/add', function () {
    return Inertia::render('Add');
  })->name('add');

  // Get Auth User
  Route::get('/get-auth-user', function () {
    $user = Auth::user();

    return response()->json($user);
  })->name('get-auth-user');
});
