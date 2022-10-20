<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class IbsVendor extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'status',
    'created_at',
    'updated_at',
    'created_by',
    'updated_by',
  ];
  protected $guarded = ['id'];

  // protected $with = ['ibs_department', 'ibs_department', 'ibs_position'];

  //relation table function
  public function ibs_trouble_tickets()
  {
    return $this->hasMany(IbsTroubleTicket::class, 'id');
  }
  //

  public static function getData($id)
  {
    if ($id != null) {
      $query = self::find($id);
    } else {
      $query = self::where('status', 1)->get();
    }
    return $query;
  }
}
