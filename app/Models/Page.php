<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
  use softDeletes, HasFactory;

  protected $fillable = [
  'title',
  'slug',
  'is_home',
  'page_type',
  'meta_title',
  'meta_keywords',
  'meta_description',
  'banner',
  'banner_content',
  'page_css',
  'page_script',
  'is_disabled',
  ];

  use HasSlug;

  public function getSlugOptions(): SlugOptions
  {
  return SlugOptions::create()
    ->generateSlugsFrom('title')
    ->saveSlugsTo('slug');
  }

  public function pageElements()
  {
  return $this->hasMany(PageElements::class, 'page_id')->orderBy('position', 'asc');
  }

  public function pageSections()
  {
  return $this->hasMany(PageSection::class, 'page_id')->where('parent_id', 0)->orderBy('order', 'asc');
  }

  public function getRouteKeyName()
  {
  return 'slug';
  }

  public static function boot() {
  parent::boot();
  static::deleting(function($model) {
    foreach($model->pageSections as $section){
    $section->delete();
    }
  });
  }
}
