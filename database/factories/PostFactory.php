<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Post::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title' => $this->faker->name(),
      'admin_id' => 1,
      'meta_title' => $this->faker->name(),
      'meta_description' => $this->faker->text(),
      'meta_keyword' => $this->faker->name(),
      'content' => $this->faker->text(800),
    ];
  }
}
