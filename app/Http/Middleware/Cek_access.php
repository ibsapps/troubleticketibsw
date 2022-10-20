<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\IbsUserPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Cek_access
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, $tbl)
  {
    $access = IbsUserPermission::check_access($tbl);
    // $access = User::hasRead(auth()->user()->id, $tbl);
    if ($access == true) {
      return $next($request);
    } else {
      // print_r('hoho');
      return redirect('dashboard')->with('message', "You don't have permission!");
    }
    // if (!$request->user()->hasRead(auth()->user()->id, $tbl)) {
    //   return $next($request);
    // }
    // return redirect('/dashboard');
  }
}
