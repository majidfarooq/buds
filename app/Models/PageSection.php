<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
  protected $fillable = [
    'page_id',
    'section_id',
    'parent_id',
    'sub_section_id',
    'order',
    'e_id',
    'e_class',
    'container_type',
  ];

  public function section()
  {
    return $this->belongsTo(PageElementSection::class, 'section_id');
  }

  public function page()
  {
    return $this->belongsTo(Page::class, 'page_id');
  }

  public function pageSubSection()
  {
    return $this->belongsTo(PageSubSection::class, 'sub_section_id');
  }

  public function subsection()
  {
    return $this->hasMany($this, 'parent_id');
  }

  public function PageElements()
  {
    return $this->hasMany(PageElements::class, 'page_section_id');
  }

  public static function boot() {
    parent::boot();
    static::deleting(function($model) {
      foreach($model->subsection as $ss){
        foreach($ss->PageElements as $sse){
          foreach($sse->content as $ssec){
            $ssec->delete();
          }
          $sse->delete();
        }
        $ss->delete();
      }
      foreach($model->PageElements as $element){
        $element->delete();
      }
    });
  }
}
