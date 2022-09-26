<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

class PageElements extends Model
{
  protected $fillable = [
    'page_id',
    'element_id',
    'position',
    'e_id',
    'e_class',
    'page_section_id',
    'sub_section_id',
    'children_ids',
  ];

  public function page()
  {
    return $this->belongsTo(Page::class,'page_id');
  }

  public function element()
  {
    return $this->belongsTo(Element::class,'element_id');
  }

  public function content(){
    return $this->hasMany(PageContent::class,'page_element_id');
  }

  public function child_page_element($ids){
    $childrens = PageElements::whereIn('id',$ids)->with('content','element')->orderBy('id', 'asc')->get();
    return $childrens;
  }
  public function fieldsWithContent()
  {
//    $fldWithCont=[];
//    $fields=$this->element->where('id','1');
//    //$this->transections->where('transactionType','debit')->sum('amount');
//    dd($fields);
//    $cntr=0;
//    foreach($fields->fields as $fld){
//      $fldWithCont[$cntr]['field']=$fld;
//      $fldWithCont[$cntr]['content']= $this->content->where('field_id',$fld->id)->first();
//    }
//    return $fldWithCont;
  }

  public static function boot() {
    parent::boot();
    static::deleting(function($model) {
      if ($model->children_ids != null) {
      $ids = explode(',', $model->children_ids);
      $model->child_page_element($ids)->each(function($child) {
        $child->content()->delete();
        $child->delete();
      });
      $model->content()->delete();
      } else {
      $model->content()->delete();
      }
      return true;
    });
  }
}
