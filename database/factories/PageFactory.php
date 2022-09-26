<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
  protected $model = Page::class;

  public function definition()
  {
    return [
      'title' => $this->faker->title(),
      'meta_title' => $this->faker->title(),
      'meta_keywords' => $this->faker->title(),
      'meta_description' => $this->faker->sentence('100'),
      'banner' => $this->faker->image('public/storage/banner'),
      'banner_content' => $this->faker->paragraphs('5'),
    ];
  }
}