<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MenuItem extends Model
{
  use HasSlug;

  protected $fillable = ['title', 'slug', 'url', 'page_type', 'page_id', 'menu_id', 'position', 'parent_id'];

  /**
   * Get the options for generating the slug.
   */
  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
      ->generateSlugsFrom('title')
      ->saveSlugsTo('slug');
  }

  public function parent()
  {
    return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
  }

  public function submenu()
  {
    return $this->hasMany(MenuItem::class, 'parent_id', 'id');
  }

  public function page()
  {
    return $this->belongsTo(Page::class, 'page_id', 'id');
  }

  public function menu()
  {
    return $this->belongsTo(Menu::class, 'menu_id', 'id');
  }
}
