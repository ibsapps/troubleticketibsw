<?php

namespace App\Models;

use App\Models\IbsTroubleTicket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class IbsTroubleTicketCategory extends Model
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

  public $timestamps = false;

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
      // $query = self::with(['ibs_division', 'ibs_department', 'ibs_position'])->where('ibs_employees.status', 1)->get();
      $query = self::where('status', 1)->get();
    }
    return $query;
  }
}
