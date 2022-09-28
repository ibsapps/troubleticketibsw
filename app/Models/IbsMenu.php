<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbsMenu extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function ibs_user_permissions()
  {
    return $this->hasMany(IbsUserPermission::class, 'id');
  }

  public function getPrefix()
  {
    $query = self::where(
      'status',
      '=',
      1
    )->orderBy('prefix')->get()->unique('prefix');

    return $query;
  }

  public function master_menu()
  {
    $query = self::where(
      'status',
      '=',
      1
    )->where('master_menu')->where('main_sub_menu')
      ->orderBy('master_menu')->orderBy('list');

    return $query->get();
  }


  public function sub_menu()
  {
    $query = self::where(
      'status',
      '=',
      1
    )->whereNotNull('master_menu')
      ->orderBy('master_menu')->orderBy('list');
    //$query->menu()->whereNull('master_menu')->get();

    return $query->get();
  }

  public function parent_sub_menu()
  {
    $query = self::where(
      'status',
      '=',
      1
    )->whereNotNull('main_sub_menu')
      ->orderBy('master_menu')->orderBy('list');
    //$query->menu()->whereNull('master_menu')->get();

    return $query->get();
  }
}
