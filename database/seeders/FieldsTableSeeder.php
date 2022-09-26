<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $field = array(
      array(
        'title' => 'banner_img',
        'slug' => 'banner_img',
        'type' => 'attachment',
        'value' => '/public/storage/placeholder.jpg',
        'element_id' => '1',
      ),
      array(
        'title' => 'banner_text',
        'slug' => 'banner_text',
        'type' => 'textarea',
        'value' => 'banner_text',
        'element_id' => '1',
      ),
      array(
        'title' => 'content',
        'slug' => 'content',
        'type' => 'textarea',
        'value' => 'textarea',
        'element_id' => '2',
      ),
      array(
        'title' => 'single Image',
        'slug' => 'single_image',
        'type' => 'attachment',
        'value' => '/public/storage/placeholder.jpg',
        'element_id' => '3',
      ),
      array(
        'title' => 'card Image',
        'slug' => 'card_image',
        'type' => 'attachment',
        'value' => '/public/storage/placeholder.jpg',
        'element_id' => '4',
      ),
      array(
        'title' => 'card Content',
        'slug' => 'card_content',
        'type' => 'textarea',
        'value' => 'Card Content',
        'element_id' => '4',
      ),
      array(
        'title' => 'Accordion Title',
        'slug' => 'accordion_title',
        'type' => 'text',
        'value' => 'Accordion Title',
        'element_id' => '5',
      ),
      array(
        'title' => 'Question',
        'slug' => 'question',
        'type' => 'text',
        'value' => 'Write Question?',
        'element_id' => '6',
      ),
      array(
        'title' => 'Answer',
        'slug' => 'answer',
        'type' => 'textarea',
        'value' => 'Type Answer Here.',
        'element_id' => '6',
      ),
      array(
        'title' => 'Slider Image',
        'slug' => 'slider_img',
        'type' => 'attachment',
        'value' => '/public/storage/placeholder.jpg',
        'element_id' => '8',
      ),
      array(
        'title' => 'Slider Text',
        'slug' => 'slider_text',
        'type' => 'textarea',
        'value' => 'slider text',
        'element_id' => '8',
      ),
      array(
        'title' => 'Flip Card Content',
        'slug' => 'flip_card_content',
        'type' => 'textarea',
        'value' => 'Enter Your Flip Card Content Here',
        'element_id' => '9',
      ),
      array(
        'title' => 'Flip Card Image',
        'slug' => 'flip_card_image',
        'type' => 'attachment',
        'value' => '/public/storage/placeholder.jpg',
        'element_id' => '9',
      ),
    );
    DB::table('element_fields')->insert($field);
  }
}
