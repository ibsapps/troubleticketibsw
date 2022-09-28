<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbsDivision extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  protected $fillable = [
    'name',
    'description',
    'status',
    'created_by',
    'updated_by'
  ];
  public function ibs_employees()
  {
    return $this->hasMany(IbsEmployee::class, 'id');
  }

  public function getData($id)
  {
    if ($id != null) {
      $query = self::find($id);
    } else {
      $query = self::where('status', 1)->get();
    }
    // return $this->belongsTo(IbsMenu::class)->where('status', 1);
    return $query;
  }
}
