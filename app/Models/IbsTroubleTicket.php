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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class IbsTroubleTicket extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'ibs_department_id',
    'ibs_trouble_ticket_category_id',
    'ibs_vendor_id',
    'request_date',
    'due_date',
    'close_date',
    'total_sla',
    'number',
    'request',
    'description',
    'filename_original',
    'filename',
    'file_extension',
    'file_path',
    'priority',
    'status',
    'trouble_repair',
    'actioned_at',
    'actioned_by_id',
    'created_at',
    'updated_at',
    'created_by',
    'updated_by',
  ];
  protected $guarded = ['id'];
  protected $dates = ['request_date', 'due_date', 'close_date', 'created_at', 'updated_at'];

  // protected $casts = [
  //   'request' => 'encrypted'
  // ];

  // protected $with = ['ibs_department', 'ibs_department', 'ibs_position'];

  public $timestamps = false;
  //relation table function
    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function actioned_by()
    {
      return $this->belongsTo(User::class, 'actioned_by_id');
    }

    public function ibs_trouble_ticket_category()
    {
      return $this->belongsTo(IbsTroubleTicketCategory::class, 'ibs_trouble_ticket_category_id');
    }
    //

    public function ibs_vendor()
    {
      return $this->belongsTo(IbsVendor::class, 'ibs_vendor_id');
    }

    public function ibs_trouble_ticket_items()
    {
      return $this->hasMany(IbsTroubleTicketItem::class, 'id');
    }
  //

  public static function getData($status = '', $id = '')
  {
    if ($id == 'all') {
      $query = self::orderBy('status')->get();
    } elseif ($id == 'dashboard') {
      $query = self::whereIn('status', $status)->orderBy('id', 'ASC')->get();
    } elseif ($status != null && $id == null) {
      if ($status == 'open') {
        $query = self::where('status', $status)->orderBy('status')->get();
      } else {
        $query = self::where('user_id', auth()->user()->id)->orderBy('status')->get();
      }
    } else {
      $query = self::where('action_by_id', auth()->user()->id)->where('status', $status)->orderBy('status')->get();
    }
    return $query;
  }

  // public function getTicket($status, $category_id, $session_id)
  // {
  //   if ($status == '' && $category_id != null && $session_id == null) {
  //     $query = self::where('status', $status)->where('ibs_trouble_ticket_category_id', $category_id);

  //   } elseif ($category_id == null && $session_id != null) {
  //     $query = self::where('status', $status)->where('actioned_by_id', $session_id);

  //   } elseif ($category_id == 'user' && $session_id != null) {
  //     $query = self::where('status', $status)->where('user_id', $session_id);

  //   } elseif ($status == 'list' && $category_id != null && $session_id == null ) {
  //     $query = self::where('ibs_trouble_ticket_category_id', $category_id)->where('status', ['open','on progress']);

  //   } else {
  //     $query = self::where('status', $status);
  //   }
  //   return $query->orderByRaw("FIELD(status, 'open', 'on progress', 'reject', 'close')")->get();
  // }

  public static function getTicket($status, $category_id, $kind)
  {
    if ($status != null && $category_id == null && $kind == null) {
      $query = self::where('status', $status);

    } elseif ($status != null && $category_id != null && $kind == null) {
      if ($status == 'list') {
        $query = self::whereIn('status', ['open', 'on progress','close'])->where('ibs_trouble_ticket_category_id', $category_id);
      } else {
        $query = self::whereIn('status', ['open', 'on progress'])->where('ibs_trouble_ticket_category_id', $category_id);
      }
    } elseif ($status == null && $category_id == null && $kind != null) {
      $query = self::where('user_id', $kind)->orWhere('actioned_by_id', $kind);
    } else {
      $query = self::all();
    }
    return $query->orderByRaw("FIELD(status, 'open', 'on progress', 'reject', 'close')")->get();
  }

  public static function store($data)
  {
    $number = documentNumbering($data, 'trouble_ticket', null);
    $random_string = Str::random(30);
    $data = [
      'number' => $number,
      'user_id' => $data['user_id'],
      'ibs_department_id' => $data['ibs_department_id'],
      'ibs_trouble_ticket_category_id' => $data['ibs_trouble_ticket_category_id'],
      'request_date' => $data['request_date'],
      'priority' => $data['priority'],
      'request' => $data['request'],
      'description' => $data['description'],
      'filename_original' => (isset($data['file']) ? $data['file']->getClientOriginalName() : null),
      'filename' => (isset($data['file']) ? $random_string . "_" . $data['file']->getClientOriginalName() : null),
      'file_extension' => (isset($data['file']) ? $data['file']->getClientOriginalExtension() : null),
      'file_path' => (isset($data['file']) ? 'images/it/trouble_ticket/' . $random_string . "_" . $data['file']->getClientOriginalName() : null),
      "created_at" => now(),
      "created_by" => auth()->user()->id
    ];
    $query = self::create($data);

    return $query;
  }

  public static function updateData($id, $params, $last_data)
  {
    $random_string = Str::random(30);
    $upload_destination = public_path('images/it/trouble_ticket');
    switch ($params['status']) {
      case 'on progress':
        if (isset($params['trouble_repair'])) {
          $data = array(
            'due_date' => isset($params['due_date']) ? $params['due_date'] : $last_data->due_date,
            'status' => 'on progress',
            'ibs_vendor_id' => $params['trouble_repair'] == 'internal' ? null : $params['ibs_vendor_id'],
            'trouble_repair' => $params['trouble_repair'] != null ? $params['trouble_repair'] : $last_data->trouble_repair,
            'actioned_at' => date('Y-m-d H:i:s'),
            'actioned_by_id' => isset($params['actioned_by_id']) ? $params['actioned_by_id'] : ($last_data->actioned_by_id == null ? auth()->user()->id : $last_data->actioned_by_id),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id,
          );
        } else {
          $data = array(
            'due_date' => isset($params['due_date']) ? $params['due_date'] : $last_data->due_date,
            'status' => 'on progress',
            'actioned_at' => isset($params['actioned_by_id']) ? date('Y-m-d H:i:s') : $last_data->actioned_at,
            'actioned_by_id' => isset($params['actioned_by_id']) ? $params['actioned_by_id'] : ($last_data->actioned_by_id == null ? auth()->user()->id : $last_data->actioned_by_id),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id,
          );
        }

        break;
      case 'close':
        $tf1 = date_create(date('Y-m-d'));
        $tf2 = date_create($last_data->due_date);
        $sla = date_diff($tf1, $tf2);
        $data = array(
          'trouble_repair'  => isset($params['trouble_repair']) ? $params['trouble_repair'] : $last_data->trouble_repair,
          'ibs_vendor_id'  => isset($params['ibs_vendor_id']) ? $params['ibs_vendor_id'] : $last_data->ibs_vendor_id,
          'close_date'  => date('Y-m-d H:i:s'),
          'total_sla' => $tf1 > $tf2 ? '-' . $sla->d : $sla->d,
          'status' => 'close',
          'updated_at' => date('Y-m-d H:i:s'),
          'updated_by' => auth()->user()->id,
        );
        break;
      case 'reject':
        $data = array(
          'close_date' => date('Y-m-d H:i:s'),
          'total_sla' => null,
          'status' => 'reject',
          'updated_at' => date('Y-m-d H:i:s'),
          'updated_by' => auth()->user()->id,
        );
        break;
      default:
        if (isset($data['file'])) {
          deleteFile($last_data->filename, 'trouble_ticket', 'images/it/trouble_ticket', null);
        }

        $data = array(
          'due_date' => isset($params['due_date']) ? $params['due_date'] : $last_data->due_date,
          'request' => isset($params['request']) ? $params['request'] : $last_data->request,
          'description' => $params['description'],
          'filename_original' => (isset($params['file']) ? $params['file']->getClientOriginalName() : $last_data->filename_original),
          'filename' => (isset($params['file']) ? $random_string . "_" . $params['file']->getClientOriginalName() : $last_data->filename),
          'file_extension' => (isset($params['file']) ? $params['file']->getClientOriginalExtension() : $last_data->file_extension),
          'file_path' => (isset($params['file']) ? 'images/it/trouble_ticket/' . $random_string . "_" . $params['file']->getClientOriginalName() : $last_data->file_path),
          'priority' => isset($params['priority']) ? $params['priority'] : $last_data->priority,
          'status' => 'open',
          'updated_at' => date('Y-m-d H:i:s'),
          'updated_by' => auth()->user()->id,
        );
        break;
    }
    $query = self::where('id', $id)->update($data);
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
