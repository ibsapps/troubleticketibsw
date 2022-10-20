<?php

namespace App\Models;

use App\Models\IbsEmployee;
use App\Models\IbsUserPermission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'ibs_employee_id',
    'username',
    'password',
    'fullname',
    'email',
    'created_by',
    'updated_by',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  public $timestamps = false;

  public function ibs_user_permissions()
  {
    return $this->hasMany(IbsUserPermission::class, 'id');
  }

  public function ibs_superiors()
  {
    return $this->hasMany(IbsSuperior::class, 'id');
  }

  public function ibs_informations()
  {
    return $this->hasMany(IbsInformation::class, 'id');
  }

  public function ibs_employee()
  {
    return $this->belongsTo(IbsEmployee::class, 'ibs_employee_id');
  }

  public function ibs_trouble_tickets()
  {
    return $this->hasMany(IbsTroubleTicket::class, 'id');
  }

  public function getLogin($email)
  {
    $query = self::where('email', $email)->first();

    return $query;
  }

  public static function getData($id, $job)
  {
    if ($id != null) {
      $query = self::find('id ?', [$id]);
    } elseif ($job == 'list') {
      $query = self::where('status', '=', [1])->get();
    } else {
      $query = self::where('status', '=', [1])->whereRaw('id not in (select user_id from ibs_user_permissions)')->get();
    }
    return $query;
  }

  public static function listUser()
  {
    $query = self::where('status', '=', [1])->whereRaw('id in (select user_id from ibs_user_permissions)')->get();
    return $query;
  }

  public static function hasRead($id, $tbl)
  {
    $query = DB::table('ibs_user_permissions')->join('ibs_menus', 'ibs_menus.id', "=", "ibs_user_permissions.ibs_menu_id")
      ->where('user_id', $id)->where('ibs_menus.table', $tbl)->where('read', 1)->row();

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public static function updatedData($id, $tbl, $kind)
  {
    if ($id != null && $tbl == null && $kind == null) {
      $query = self::where('id', $id)->update(['status' => 0]);
    }
    return $query;
  }
}
