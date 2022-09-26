<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageElementSection extends Model
{
  protected $fillable = [
    'title',
    'slug',
  ];

  public function PageSubSections()
  {
    return $this->hasMany(PageSubSection::class, 'section_id')->orderBy('id','asc');
  }
}
