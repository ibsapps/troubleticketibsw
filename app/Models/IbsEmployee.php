<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use ESolution\DBEncryption\Traits\EncryptedAttribute;


class IbsEmployee extends Model
{
  use HasFactory, EncryptedAttribute;

  protected $fillable = [
    'ibs_position_id',
    'ibs_department_id',
    'ibs_division_id',
    'area',
    'sub_area',
    'ptkp',
    'nik',
    'name',
    'company_email',
    'email',
    'group',
    'contract_status',
    'entry_date',
    'gender',
    'born_date',
    'place_of_birth',
    'ktp_number',
    'npwp',
    'bpjs_tk',
    'bpjs_kes',
    'origin_address',
    'temporary_address',
    'phone_number',
    'smartfren_phone_number',
    'religion',
    'sinarmas_bank_account',
    'mandiri_bank_account',
    'education_location',
    'education_degree',
    'education_major',
    'cost_center',
    'cost_center_description',
    'directorate',
    'marital_status',
    'join_date',
    'resign_date',
    'contract_begin',
    'contract_end',
    'status',
    'reason_of_status',
    'created_at',
    'updated_at',
    'created_by',
    'updated_by',
  ];
  protected $guarded = ['id'];

  protected $with = ['ibs_division', 'ibs_department', 'ibs_position'];

  protected $encryptable = [
    'email','company_email','sinarmas_bank_account','mandiri_bank_account','origin_address','temporary_address','phone_number','smartfren_phone_number','ktp_number',
    'npwp','bpjs_tk','bpjs_kes'
  ];

  protected $dates = ['join_date', 'entry_date', 'born_date', 'resign_date', 'contract_begin', 'contract_end', 'created_at', 'updated_at'];

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

  public static function getData($id, $tbl)
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

  public static function findData($params, $kind)
  {
    $query = self::where($kind, $params)->first();
    return $query;
  }
}
