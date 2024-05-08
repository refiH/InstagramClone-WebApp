<?php

namespace App\Http\Controllers;

use App\Models\M_Post;
use App\Models\M_PostComment;
use App\Models\M_PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Glide\GlideImage;

class C_Post extends Controller
{
  public function post(Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:5120'
    ]);

    $imageName = Auth::user()->username . '_'  . time() . '.' . $request->image->extension();
    $path = storage_path("app/public/posts/images");

    $request->file('image')->move($path, $imageName);
    $image = storage_path("app/public/posts/images/$imageName");

    // resize image
    if (filesize($image) > 1024 * 1024) {
      GlideImage::create($image)
        ->modify(['q' => 70])
        ->save($image);
    }

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

  public function like(Request $request)
  {
    $existingLike = M_PostLike::where('user_id', Auth::user()->id)
      ->where('post_id', $request->postId)
      ->first();

    if ($existingLike) {
      $existingLike->delete();

      $likesCount = M_PostLike::where('post_id', $request->postId)->count();
      return response()->json(['message' => 'deleted', 'count' => $likesCount]);
    } else {
      M_PostLike::create([
        'user_id' => Auth::user()->id,
        'post_id' => $request->postId,
        'status' => $request->status,
      ]);

      $likesCount = M_PostLike::where('post_id', $request->postId)->count();
      return response()->json(['message' => 'added', 'count' => $likesCount]);
    }
  }
}
