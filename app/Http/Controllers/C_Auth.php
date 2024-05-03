<?php

namespace App\Http\Controllers;

use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class C_Auth extends Controller
{
  public function loginPage()
  {
    if (Auth::check()) {
      return to_route('home');
    }

    $error = session()->get('error');

    return Inertia::render('Login', ['error' => $error]);
  }

  public function registerPage()
  {
    if (Auth::check()) {
      return to_route('home');
    }

    $error = session()->get('error');

    return Inertia::render('Register', ['error' => $error]);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required',
      'password' => 'required'
    ]);

    $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $user = M_User::where($loginField, $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
      Auth::login($user);
      return to_route('home');
    } else {
      return to_route('auth.login-page')->with('error', 'Username, email, or password incorrect.');
    }
  }

  public function register(Request $request)
  {
    $request->validate([
      'username' => 'required|unique:users',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed|min:8'
    ]);

    $user = M_User::create([
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'is_admin' => false
    ]);

    Auth::login($user);
    return to_route('home');
  }

  public function logout()
  {
    Auth::logout();
    return to_route('auth.login-page');
  }
}
