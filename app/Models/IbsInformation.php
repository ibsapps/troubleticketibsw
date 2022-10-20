<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class IbsInformation extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'ibs_department_id',
    'live_until',
    'title',
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
  protected $table = 'ibs_informations';

  public $timestamps = false;
  //relation table function

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function ibs_department()
  {
    return $this->belongsTo(IbsDepartment::class, 'ibs_department_id');
  }

  public static function getData($tbl = '', $kind = '', $id = '')
  {
    switch ($tbl) {
      case 'dashboard':
        $query = self::where('live_until', '>', now())->where('status', 1)->orderBy('live_until')->get();
        break;      
      default:
        $query = self::where('status', 1)->orderBy('status')->get();
        break;
    }

    return $query;
  }

  public static function store($data)
  {
    
    $random_string = Str::random(30);
    $data = [
      'user_id' => $data['user_id'],
      'ibs_department_id' => $data['ibs_department_id'],
      'live_until' => $data['live_until'],
      'title' => $data['title'],
      'description' => $data['description'],
      'filename_original' => (isset($data['file']) ? $data['file']->getClientOriginalName() : null),
      'filename' => (isset($data['file']) ? $random_string . "_" . $data['file']->getClientOriginalName() : null),
      'file_extension' => (isset($data['file']) ? $data['file']->getClientOriginalExtension() : null),
      'file_path' => (isset($data['file']) ? 'images/sys/information/' . $random_string . "_" . $data['file']->getClientOriginalName() : null),
      'created_at' => now(),
      'created_by'=> auth()->user()->id
    ];

    $query = self::create($data);

    return $query;
  }

}
