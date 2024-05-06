<?php

namespace App\Http\Controllers;

use App\Models\M_Post;
use App\Models\M_PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Post extends Controller
{
  public function post(Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
    ]);
    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(storage_path('app/public/posts/images'), $imageName);

    M_Post::create([
      'user_id' => Auth::user()->id,
      'image' => $imageName,
      'content' => $request->content,
    ]);

    return to_route('home');
  }

  public function comment(Request $request)
  {
    $request->validate([
      'content' => 'required'
    ]);

    M_PostComment::create([
      'user_id' => Auth::user()->id,
      'post_id' => $request->postId,
      'content' => $request->content,
    ]);
  }
}
