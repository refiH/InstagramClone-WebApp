<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class M_PostComment extends Model
{
  use HasFactory;

  protected $table = 'post_comments';

  protected $primaryKey = 'id';

  protected $keyType = 'string';

  public $incrementing = false;

  protected $fillable = [
    'post_id',
    'user_id',
    'content',
  ];

  public static function booted()
  {
    static::creating(function ($model) {
      $model->id = Str::uuid();
    });
  }

  public function Post(): BelongsTo
  {
    return $this->belongsTo(M_Post::class, 'post_id', 'id');
  }

  public function User(): BelongsTo
  {
    return $this->belongsTo(M_User::class, 'user_id', 'id');
  }
}
