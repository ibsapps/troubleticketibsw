<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class IbsArea extends Model
{
  use HasFactory, EncryptedAttribute;

  protected $guarded = ['id'];

  protected $fillable = [
    'name',
    'description',
    'status',
    'created_by',
    'updated_by'
  ];

  protected $encryptable = [
    'name'
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
