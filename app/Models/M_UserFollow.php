<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class M_UserFollow extends Model
{
  use HasFactory;


  protected $table = 'user_follows';

  protected $primaryKey = 'id';

  protected $keyType = 'string';

  public $incrementing = false;

  protected $fillable = [
    'user_id',
    'user_followed_id',
  ];

  public static function booted()
  {
    static::creating(function ($model) {
      $model->id = Str::uuid();
    });
  }

  public function User(): BelongsTo
  {
    return $this->belongsTo(M_User::class, 'user_id', 'id');
  }
}
