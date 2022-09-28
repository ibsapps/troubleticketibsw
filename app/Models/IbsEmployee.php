<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class IbsEmployee extends Model
{
  use HasFactory;

  protected $fillable = [
    'ibs_position_id',
    'ibs_department_id',
    'ibs_division_id',
    'ibs_area_id',
    'nik',
    'name',
    'email',
    'group',
    'contract_statu',
    'entry_date',
    'gender',
    'born_date',
    'place_of_birth',
    'ktp_number',
    'npwp',
    'bpjs_tk',
    'bpjs_kes',
    'origin_address',
    'phone_number',
    'phone_number_2',
    'religion',
    'education_location',
    'education_degree',
    'education_major',
    'cost_center',
    'cost_center_description',
    'directorate',
    'status',
    'created_at',
    'updated_at',
    'created_by',
    'updated_by',
  ];
  protected $guarded = ['id'];

  protected $with = ['ibs_division', 'ibs_department', 'ibs_position'];


  //relation table function
  public function ibs_department()
  {
    return $this->belongsTo(IbsDepartment::class, 'ibs_department_id');
  }
  public function ibs_position()
  {
    return $this->belongsTo(IbsPosition::class, 'ibs_position_id');
  }
  public function ibs_division()
  {
    return $this->belongsTo(IbsDivision::class, 'ibs_division_id');
  }
  public function ibs_area()
  {
    return $this->belongsTo(IbsArea::class, 'ibs_area_id');
  }
  //
  public function users()
  {
    $this->hasMany(IbsUser::class);
  }

  public function getData($id, $tbl)
  {
    if ($id != null && $tbl == null) {
      $query = self::find($id);
    } elseif ($tbl != null) {
      $query = self::where('status', '=', [1])->whereRaw('id not in (select ibs_employee_id from users)')->get();
    } else {
      // $query = self::with(['ibs_division', 'ibs_department', 'ibs_position'])->where('ibs_employees.status', 1)->get();
      $query = self::where('ibs_employees.status', 1)->get();
    }
    return $query;
  }
}
