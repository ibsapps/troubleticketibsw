<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
  public function index()
  {
    return view('authentications.login', [
      'title' => 'Login'
    ]);
  }

  public function authenticate(Request $request)
  {
    $credentials = $request->validate([
      'username' => ['required'],
      'password' => ['required']
    ]);

    //dd('Berhasil Login');
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended('/dashboard');
    }

    return back()->with('Error', 'Login failed');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
  }
}
