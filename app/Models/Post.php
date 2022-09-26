<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
  use softDeletes;
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'admin_id',
    'cat_id',
    'meta_title',
    'meta_description',
    'meta_keyword',
    'content',
    'thumbnail',
  ];

  use HasSlug;

  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
      ->generateSlugsFrom('title')
      ->saveSlugsTo('slug');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'cat_id', 'id');
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function admin()
  {
    return $this->belongsTo(Admin::class);
  }
}
