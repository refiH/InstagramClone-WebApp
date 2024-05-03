<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class M_Post extends Model
{
  use HasFactory;

  protected $table = 'posts';

  protected $primaryKey = 'id';

  protected $keyType = 'string';

  public $incrementing = false;

  protected $fillable = [
    'username',
    'email',
    'password',
    'bio',
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

  public function Likes(): HasMany
  {
    return $this->hasMany(M_PostLike::class, 'post_id');
  }

  public function Comments(): HasMany
  {
    return $this->hasMany(M_PostComment::class, 'post_id');
  }
}
