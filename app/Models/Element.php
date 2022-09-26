<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
  protected $fillable = ['title', 'type', 'parentId', 'template'];

  public static function boot()
  {
  parent::boot();
  static::deleting(function ($model) {
    $model->fields()->delete();
  });
  }

  public function fields()
  {
  return $this->hasMany(ElementFields::class, 'element_id', 'id');
  }

  public function child_element()
  {
  return $this->hasOne(Element::class, 'parentId', 'id');
  }

  public function parent_element()
  {
  return $this->hasOne(Element::class, 'id', 'parentId');
  }
}
