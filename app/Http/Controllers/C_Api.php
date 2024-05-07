<?php

namespace App\Http\Controllers;

use App\Models\M_Post;
use App\Models\M_PostComment;
use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Api extends Controller
{
  public function getPost(M_Post $post)
  {
    $post = M_Post::where('id', $post->id)
      ->with('User:id,username,image')
      ->with(['Likes' => function ($query) {
        $query->where('user_id', Auth::id());
      }])
      ->withCount('Likes')
      ->withCount('Comments')
      ->first();

    return response()->json($post);
  }

  public function getPosts(Request $request)
  {
    $posts = M_Post::with('User:id,username,image')
      ->with(['Likes' => function ($query) {
        $query->where('user_id', Auth::id());
      }])
      ->withCount('Likes')
      ->withCount('Comments')
      ->orderBy('created_at', 'desc')
      ->paginate($request->count, ['*'], 'page', $request->input('page', 1));

    return response()->json($posts);
  }

  public function getUserPosts(Request $request, $username)
  {
    $user = M_User::where('username', $username);

    $posts = M_Post::where('user_id', $user->id)
      ->withCount('Likes')
      ->withCount('Comments')
      ->orderBy('created_at', 'desc')
      ->paginate($request->count, ['*'], 'page', $request->input('page', 1));

    return response()->json($posts);
  }

  public function getRandomPosts(Request $request)
  {
    $posts = M_Post::with('User:id,username,image')
      ->withCount('Likes')
      ->withCount('Comments')
      ->inRandomOrder()
      ->paginate($request->count, ['*'], 'page', $request->input('page', 1));

    return response()->json($posts);
  }

  public function getComments(M_Post $post, Request $request)
  {
    $comments = M_PostComment::where('post_id', $post->id)
      ->with('User:id,username,image')
      ->orderBy('created_at', 'desc')
      ->paginate(5, ['*'], 'page', $request->input('page', 1));

    return response()->json($comments);
  }

  public function getAuthUser()
  {
    $user = Auth::user();

    $userData = [
      'id' => $user->id,
      'username' => $user->username,
      'email' => $user->email,
      'image' => $user->image,
      'bio' => $user->bio,
      'is_admin' => $user->is_admin,
      'created_at' => $user->created_at,
      'updated_at' => $user->updated_at,
    ];

    return response()->json($userData);
  }
}
