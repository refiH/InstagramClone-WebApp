<?php

use App\Models\M_Post;
use App\Models\M_PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/get-posts', function (Request $request) {
  $posts = M_Post::with('User')
    ->withCount('Likes')
    ->withCount('Comments')
    ->orderBy('created_at', 'desc')
    ->paginate($request->count, ['*'], 'page', $request->input('page', 1));

  return response()->json($posts);
})->name('get-posts');

Route::get('/get-random-posts', function (Request $request) {
  $posts = M_Post::with('User')
    ->withCount('Likes')
    ->withCount('Comments')
    ->inRandomOrder()
    ->paginate($request->count, ['*'], 'page', $request->input('page', 1));

  return response()->json($posts);
})->name('get-random-posts');

// Modal
Route::get('/get-post/{post}', function (M_Post $post) {
  $post = M_Post::where('id', $post->id)
    ->with('User:id,username,image')
    ->with(['Likes' => function ($query) {
      $query->select('id', 'user_id', 'post_id', 'created_at')->with('User:id,username,image');
    }])
    ->withCount('Likes')
    ->withCount('Comments')
    ->first();

  return response()->json($post);
})->name('get-post');

Route::get('/get-comments/{post}', function (M_Post $post, Request $request) {
  $comments = M_PostComment::where('post_id', $post->id)
    ->with('User:id,username,image')
    ->paginate(5, ['*'], 'page', $request->input('page', 1));

  return response()->json($comments);
})->name('get-comments');
