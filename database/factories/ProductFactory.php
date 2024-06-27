<?php
namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition() {
    $category = Category::inRandomOrder()->first();
    $brand    = Brand::inRandomOrder()->first();
    return [
      'name'        => $this->faker->name(),
      'description' => $this->faker->text(50),
      'brand_id'    => $brand->id,
      'category_id' => $category->id,
      'price'       => $this->faker->randomElement([10000, 20000, 25000, 150000]),
      'color'       => $this->faker->randomElement([2, 3, 6, 3]),
      'size'        => [
        $this->faker->randomElement(['s', 'm', 'l', 'xl', '2xl', '3xl', 'F', 'over']),
      ],
      'is_sold_out' => 0,
      'fix_count'   => 5,
    ];
  }
}
