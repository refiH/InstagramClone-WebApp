<?php

namespace App\Http\Controllers;

use App\Models\M_Post;
use Illuminate\Http\Request;
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
}
