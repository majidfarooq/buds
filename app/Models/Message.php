<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
    'sender_id',
    'content_id',
    'readby',
    'message',
  ];

  public function user()
  {
    return $this->belongsTo(\App\Models\User::class, 'sender_id','id');
  }
}
