<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

  protected $fillable = [
    'title',
    'slug',
    'content',
  ];

  public function MenuItem()
  {
    return $this->hasMany(MenuItem::class,'menu_id','id')->orderBy('position', 'asc');
  }
}
