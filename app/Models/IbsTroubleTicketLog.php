<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class IbsTroubleTicketLog extends Model
{
  use HasFactory;

  protected $fillable = [
    'ibs_trouble_ticket_id',
    'user',
    'pic',
    'status',
    'trouble_repair',
    'category',
    'created_ticket_at',
    'due_date_ticket_at',
    'closed_ticket_at',
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

  public function checkLog($id, $status)
  {
    $query = self::where('ibs_trouble_ticket_id', $id)->where('status', $status)->first();
    return $query;
  }
  //

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
