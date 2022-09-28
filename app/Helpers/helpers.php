<?php

// namespace App\Helpers;
// use App\Models\IbsUserPermission;

use App\Mail\MailNotify;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

// if (!function_exists('check_access')) {
// function check_access($tbl, $id)
// {
//   $query = DB::table('ibs_user_permissions')->join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")
//     ->where('ibs_menus.table', $tbl)->where('user_id', auth()->user()->id)->where('read', 1)->first();

//   return $query;
//   // if ($query != null) {
//   //   return true;
//   // } else {
//   //   return false;
//   // }
// }


// function checkId()
// {
//   // $user = User::first()->getOriginal();

//   $user = session()->all();
//   // return print_r($user);
//   return $user;
// }

function helperCheckAccess($tbl)
{
  // $user = Auth::user();
  // return print_r($user);
  $query = DB::table('ibs_user_permissions')->join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")
    ->where('ibs_menus.table', $tbl)->where('user_id', Auth::user('id'))->where('read', 1)->first();

  return $query;
  // return $user;
  // if ($query != null) {
  //   return true;
  // } else {
  //   return false;
  // }
}

function documentNumbering($data, $tbl, $kind)
{
  switch ($tbl) {
    case 'trouble_ticket':
      $trouble_ticket = DB::table('ibs_trouble_tickets')->where('request_date', 'LIKE', '%' . date('Y') . '%')->orderBy('id', 'desc')->first();
      $dept = DB::table('ibs_departments')->find($data['ibs_department_id']);
      switch ($data['ibs_trouble_ticket_category_id']) {
        case '1':
          $code = 'NET';
          break;
        case '2':
          $code = 'SUP';
          break;
        default:
          $code = 'APP';
          break;
      }


      if (empty($trouble_ticket)) {
        $num_suffix = 1;
      } else {
        $num_suffix = intval(substr($trouble_ticket->number, -4)) + 1;
      }

      if (is_int($num_suffix)) {
        $num_length = Str::length(strval($num_suffix));
      }

      if ($num_length == 1) {
        $num_prefix = "000";
      } elseif ($num_length == 2) {
        $num_prefix = "00";
      } else {
        $num_prefix = "0";
      }
      $date = date('ym');

      $number = $dept->symbol . '#' . $code . $date . $num_prefix . $num_suffix;
      break;

    default:
      # code...
      break;
  }

  return $number;
}


function sendMailNotification($data, $tbl, $pic, $kind)
{
  switch ($tbl) {
    case 'trouble_ticket_items':
      $subj_mail = 'Tiket kamu dengan nomor ' . $data->number . ' ' . $kind;
      $sender = 'troubleticket@ibsmulti.com';
      break;

    default:
      # code...
      break;
  }
  Mail::to($data->user->email)->send(new MailNotify($subj_mail, $sender, $data, $pic));

  // if (Mail::failures()) {
  //   return response()->with('error', 'Something error!');
  // } else {
  //   return response()->with('success', 'Something error!');
  // }
}


function deleteFile($data, $tbl, $path, $kind)
{
  switch ($tbl) {
    case 'trouble_ticket_item':
      if (File::exists(public_path($path . '/' . $data))) {
        File::delete(public_path($path . '/' . $data));
      }
      break;

    default:
      # code...
      break;
  }
}

  // public static function access($tbl, $access)
  // {
  //   $query
  //   // $permission = DB::table('ibs_user_permissions')->join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")
  //     // ->where('ibs_menus.table', $tbl)->where('read', 1)->row();

  //   print_r($permission);
  //   if ($permission) {
  //     return true;
  //   } else {
  //     return false;
  //   }
  // }
// }
