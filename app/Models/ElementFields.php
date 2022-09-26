<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ElementFields extends Model
{

  use HasSlug;

  protected $fillable = ['title', 'slug', 'type', 'value', 'element_id'];

  public function getSlugOptions(): SlugOptions
  {
  return SlugOptions::create()
    ->generateSlugsFrom('title')
    ->usingSeparator('_')
    ->saveSlugsTo('slug');
  }

  public function element()
  {
  return $this->belongsTo(Element::class, 'element_id', 'id');
  }

  public function content()
  {
  return $this->hasMany(PageContent::class, 'field_id', 'id');
  }
}
