<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
  protected $fillable = ['page_element_id', 'field_id', 'content'];

  public function pageElement()
  {
  return $this->belongsTo(PageElements::class, 'element_id');
  }

  public function field()
  {
  return $this->belongsTo(ElementFields::class, 'field_id');
  }
}
