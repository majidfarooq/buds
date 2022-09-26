<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSubSection extends Model
{
  protected $fillable = [
    'title',
    'row_width',
    'section_id',
  ];

  public function section()
  {
    return $this->belongsTo(PageElementSection::class, 'section_id');
  }
}
