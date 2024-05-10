<?php

namespace App\Http\Controllers;

use App\Models\M_Post;
use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class C_Pages extends Controller
{
  public function home()
  {
    $data['postsCount'] = M_Post::count();

    return Inertia::render('Home', $data);
  }

  public function explore()
  {
    $data['postsCount'] = M_Post::count();

    return Inertia::render('Explore', $data);
  }

  public function add()
  {
    return Inertia::render('Add');
  }

  public function profile($username)
  {
    $user = M_User::where('username', $username)
      ->select(
        'id',
        'username',
        'image',
        'bio',
      )
      ->withCount('Posts')
      ->withCount('Follows')
      ->withCount('Followers')
      ->firstOrFail();

    return Inertia::render('Profile', ['user' => $user]);
  }

  public function editProfile()
  {
    $user = Auth::user();

    return Inertia::render('EditProfile', ['user' => $user]);
  }
}
