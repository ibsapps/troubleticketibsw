<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class AuthenticationController extends Controller
{

  public function __construct()
  {
    $this->user = new User();
  }

  public function index()
  {
    return view('authentications.login', [
      'title' => 'Login'
    ]);
  }

  public function authenticate(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required'],
      'password' => ['required']
    ]);

    // dd('Berhasil Login');
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended('/dashboard');
    }

    return back()->with('Error', 'Login Failed! Wrong password');

    // $credentials = $request->validate([
    //   'email' => 'required',
    //   'password' => 'required'
    // ]);

    // $email_check = $this->user::getLogin($request->input('email'));

    // if ($email_check) {
    //   if ($email_check->status == 0) {
    //     return back()->with('Error', 'Account Suspended! Please Contact IT.');
    //   } else {
    //     if ($email_check->password != null) {
    //       if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended('/dashboard');
    //       }
    //       return back()->with('Error', 'Login Failed!. Wrong email or password');
    //     } else {
    //       $data = [
    //         'email' => $request->input('email'),
    //         'username' => $request->input('password')
    //       ];
    //       if (Auth::attempt($data)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended('/dashboard');
    //       } else {
    //         return back()->with('Error', 'Login Failed!. Wrong Password');
    //       }
    //     }
    //   }  
    // } else {
    //   return back()->with('Error', 'Email Not Found!');
    // }

    // dd('Berhasil Login');
    // if (Auth::attempt($credentials)) {
    //   $request->session()->regenerate();
    //   return redirect()->intended('/dashboard');
    // }

    // return back()->with('Error', 'Login Failed! Wrong password');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
  }
}
