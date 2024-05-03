<?php

use App\Models\M_Post;
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

Route::get('/', function () {
  // $data['posts'] = M_Post::with('User')
  //   ->withCount('Likes')
  //   ->withCount('Comments')
  //   ->orderBy('created_at', 'desc')
  //   ->get();

  $data['postsCount'] = M_Post::count();

  return Inertia::render('Home', $data);
});

Route::get('/explore', function () {
  // $data['posts'] = M_Post::with('User')
  // ->withCount('Likes')
  // ->withCount('Comments')
  // ->inRandomOrder()
  // ->get();

  $data['postsCount'] = M_Post::count();

  return Inertia::render('Explore', $data);
});

Route::get('/add', function () {
  return Inertia::render('Add');
});
