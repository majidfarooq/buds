<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
    'parent_id',
    'description',
    'image',
  ];

  use HasSlug;

  /**
   * Get the options for generating the slug.
   */
  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
      ->generateSlugsFrom('name')
      ->saveSlugsTo('slug');
  }

  public function parent()
  {
    return $this->belongsTo(Category::class, 'parent_id', 'id');
  }

  public function children()
  {
    return $this->hasMany(Category::class, 'parent_id', 'id');
  }

  public function posts()
  {
    return $this->hasMany(Post::class, 'cat_id');
  }

  public function catExperiences()
  {
    return $this->experiences()->where('cat_id', $this->id)->take(5)->orderBy('id', 'desc');
  }

  public function experiences()
  {
    return $this->hasMany(Experience::class, 'cat_id')->where('isPublished', 1);
  }

  public function subCatExperiences()
  {
    return $this->hasMany(Experience::class, 'subCat_id')->where('isPublished', 1);
  }
}
