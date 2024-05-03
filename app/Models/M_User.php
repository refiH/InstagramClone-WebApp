<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class M_User extends Authenticatable
{
  use HasFactory;

  protected $table = 'users';

  protected $primaryKey = 'id';

  protected $keyType = 'string';

  public $incrementing = false;

  protected $fillable = [
    'username',
    'email',
    'password',
    'image',
    'bio',
  ];

  public static function booted()
  {
    static::creating(function ($model) {
      $model->id = Str::uuid();
    });
  }

  public function Posts(): HasMany
  {
    return $this->hasMany(M_Post::class, 'user_id');
  }

  public function Follows(): HasMany
  {
    return $this->hasMany(M_UserFollow::class, 'user_id');
  }

  public function Followers(): HasMany
  {
    return $this->hasMany(M_UserFollow::class, 'user_followed_id');
  }
}
