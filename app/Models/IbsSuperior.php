<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbsSuperior extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  protected $fillable = [
    'user_id',
    'superior_user_id',
    'status',
    'created_by',
    'created_at',
    'updated_at',
    'updated_by'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function getData()
  {
    $query = self::where('superior_user_id', auth()->user()->id)->where('status', 1)->get();
    return $query;
  }
}
