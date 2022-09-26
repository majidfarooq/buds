<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ElementsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $elements = array(
      array(
        'title' => 'banner',
        'type' => null,
        'parentId' => null,
        'template' => '<div id="{{cstm_id}}" class="{{cstm_class}}"><div class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner"><div class="carousel-item active"><img src="{{banner_img}}" class="banner_img d-block w-100" alt=""><div class="banner_text">{{banner_text}}</div></div></div></div></div>',
      ),
      array(
        'title' => 'text',
        'type' => null,
        'parentId' => null,
        'template' => '<div  id="{{cstm_id}}"  class="{{cstm_class}}">{{content}}</div>',
      ),
      array(
        'title' => 'image',
        'type' => null,
        'parentId' => null,
        'template' => '<div  id="{{cstm_id}}"  class="{{cstm_class}}" ><div class="card single_image"><img src="{{single_image}}" class="card-img-top single_image" alt="..."></div></div>',
      ),
      array(
        'title' => 'card',
        'type' => null,
        'parentId' => null,
        'template' => '<div id="{{cstm_id}}" class="{{cstm_class}}"><div class="card"><div class="card_image"><img src="{{card_image}}" class="card-img-top card_image" alt="..."></div><div class="card-body"><div class="card-text">{{card_content}}</div></div></div></div>',
      ),
      array(
        'title' => "accordion",
        'type' => "parent",
        'parentId' => null,
        'template' => "<div id='{{cstm_id}}' class='{{cstm_class}}'><div class='accordion accordion-flush' id='accordionFlushCollapse'><h1>{{toggle_title}}</h1>{{section_loop}}</div></div>",
      ),
      array(
        'title' => 'question',
        'type' => 'daughter',
        'parentId' => 5,
        'template' => '<div id="{{cstm_id}}" class="{{cstm_class}} accordion-item"><h2 class="accordion-header" id="heading-collapse-"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-" aria-expanded="false" aria-controls="flush-collapse-">{{question}}</button></h2><div id="flush-collapse-" class="accordion-collapse collapse" aria-labelledby="heading-collapse-" data-bs-parent="#accordionFlushCollapse"><div class="accordion-body">{{answer}}</div></div></div>',
      ),
      array(
        'title' => 'slider',
        'type' => 'parent',
        'parentId' => null,
        'template' => '<div id="{{cstm_id}}"  class="{{cstm_class}}"><div class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner">{{section_loop}}</div></div></div>',
      ),
      array(
        'title' => 'slider content',
        'type' => 'daughter',
        'parentId' => 7,
        'template' => '<div class="carousel-item"><img src="{{slider_img}}" class="d-block w-100" alt=""><div class="banner_text slider_text">{{slider_text}}</div></div>',
      ),
      array(
        'title' => 'Flip Card',
        'type' => null,
        'parentId' => null,
        'template' => '<div id="{{cstm_id}}" class="flip-card w-100 {{cstm_class}}"><div class="flip-card-inner"><div class="flip-card-front"><img src="{{flip_card_image}}" alt=""></div><div class="flip-card-back">{{flip_card_content}}</div></div></div>',
      ),
    );
    DB::table('elements')->insert($elements);
  }
}


