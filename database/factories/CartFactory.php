<?php
namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition() {
    $product    = Product::inRandomOrder()->first();
    $customer   = Customer::inRandomOrder()->first();
    $randNumber = rand(1, 5);

    return [
      'user_id'    => $customer->id,
      'product_id' => $product->id,
      'size'       => $this->faker->randomElement(['s', 'm', 'l', 'xl', '2xl', '3xl', 'F', 'over']),
      'quantity'   => $randNumber,
    ];
  }
}
