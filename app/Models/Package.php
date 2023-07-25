<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\SlugOptions;

class Package extends Model
{
  use HasFactory, softDeletes, HasSlug;
  protected $fillable = [
    'title',
    'type',
    'price',
    'tax',
    'delivery_fee',
    'amount',
    'mark_up',
    'description',
      'image',
      'thumbnail',
      'show_frontend'
  ];

  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
      ->generateSlugsFrom('title')
      ->saveSlugsTo('slug');
  }
}
