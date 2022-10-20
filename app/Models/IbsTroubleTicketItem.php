<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class IbsTroubleTicketItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'ibs_trouble_ticket_id',
    'description',
    'filename_original',
    'filename',
    'file_extension',
    'file_path',
    'status',
    'created_at',
    'updated_at',
    'created_by',
    'updated_by',
  ];
  protected $guarded = ['id'];
  public $timestamps = false;
  protected $baseDir = 'images/it/trouble_ticket';
  // protected $with = ['ibs_department', 'ibs_department', 'ibs_position'];

  //relation table function
  public function ibs_trouble_ticket()
  {
    return $this->belongsTo(IbsTroubleTicket::class, 'ibs_trouble_ticket_id');
  }
  //

  public static function getData($id)
  {
    $query = self::where('id', $id)->first();
    return $query;
  }
  public static function getItem($id)
  {
    $query = self::where('ibs_trouble_ticket_id', $id)->where('status', 1)->get();
    return $query;
  }
  // public function getData($id, $tbl)
  // {
  //   if ($id != null && $tbl == null) {
  //     $query = self::find($id);
  //   } elseif ($tbl != null) {
  //     $query = self::where('status', '=', [1])->whereRaw('id not in (select ibs_employee_id from users)')->get();
  //   } else {
  //     // $query = self::with(['ibs_division', 'ibs_department', 'ibs_position'])->where('ibs_employees.status', 1)->get();
  //     $query = self::where('ibs_employees.status', 1)->get();
  //   }
  //   return $query;
  // }
}
