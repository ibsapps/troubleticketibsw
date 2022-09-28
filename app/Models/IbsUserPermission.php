<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\User as Authenticatable;


class IbsUserPermission extends model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'ibs_menu_id',
    'read',
    'create',
    'modify',
    'void',
    'cancel_void',
    'print',
    'export',
    'approve_1',
    'cancel_approve_1',
    'approve_2',
    'cancel_approve_2',
    'approve_3',
    'cancel_approve_3',
  ];
  protected $guarded = ['id'];

  // public function __construct()
  // {
  //   $this->middleware('auth');
  // }
  public function user()
  {
    // return $this->belongsTo(User::class, 'user_id')->where('status', 1);
    return $this->belongsTo(User::class, 'user_id');
  }

  public function ibs_menu()
  {
    // return $this->belongsTo(IbsMenu::class)->where('status', 1);
    return $this->belongsTo(IbsMenu::class, 'ibs_menu_id');
  }

  public function accessMasterMenu($id)
  {

    // $query = self::with(['ibs_menu' => function ($sql) {
    //   $sql->whereNull('master_menu')->whereNull('main_sub_menu')->where('status', 1)
    //     ->orderBy('master_menu')->orderBy('list');
    // }])->where('user_id', $id)->where('read', 1)->get();

    $query = self::join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")->where(
      'user_id',
      '=',
      $id
    )->where(
      'read',
      '=',
      1
    )->where('ibs_menus.master_menu')->where('ibs_menus.main_sub_menu')->where('ibs_menus.status', '=', 1)
      ->orderBy('ibs_menus.master_menu')->orderBy('ibs_menus.list')->get();

    return $query;
  }


  public function accessSubMenu($id)
  {
    $query = self::join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")->where(
      'user_id',
      '=',
      $id
    )->where(
      'read',
      '=',
      1
    )->whereNotNull('ibs_menus.master_menu')->where('ibs_menus.status', '=', 1)
      ->orderBy('ibs_menus.master_menu')->orderBy('ibs_menus.list');
    //$query->menu()->whereNull('master_menu')->get();

    return $query->get();
  }

  public function accessParentSubMenu($id)
  {
    $query = self::join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")->where(
      'user_id',
      '=',
      $id
    )->where(
      'read',
      '=',
      1
    )->whereNotNull('ibs_menus.main_sub_menu')->where('ibs_menus.status', '=', 1)
      ->orderBy('ibs_menus.master_menu')->orderBy('ibs_menus.list');
    //$query->menu()->whereNull('master_menu')->get();

    return $query->get();
  }

  public function getData($menu_id, $user_id)
  {
    if ($menu_id != null && $user_id != null) {
      $query = self::where('ibs_menu_id', '=', $menu_id)->where('user_id', '=', $user_id)->first();
    } else {
      $query = DB::table('ibs_user_permissions')->select('*')->groupBy('user_id')->get();
    }
    return $query;
  }

  public function updateData($menu_id, $user_id, $data)
  {
    $query = self::where('ibs_menu_id', '=', $menu_id)->where('user_id', '=', $user_id)->update($data);

    return $query;
  }

  public function check_access($tbl)
  {
    // $user = User::where('id', auth()->user()->id)->first();
    // print_r($user->id);
    $query = self::join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")
      ->where('user_id', auth()->user()->id)->where('ibs_menus.table', $tbl)->first();
    // $query = self::with(array('ibs_menu' => function ($sql) use ($tbl) {
    //   $sql->where('table', $tbl);
    // }))->where('user_id', $id)->first();

    return $query;
  }
}
