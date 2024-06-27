<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryFee>
 */
class DeliveryFeeFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition() {
    return [
      'delivery_region_id' => 1,
      'township'           => $this->faker->unique()->randomElement(['ဗဟန်း', 'ကြည့်မြင်တိုင်', 'သာကေတ', 'တာမွေ', 'လှည်းတန်း', 'အခြား']),
      'price'              => $this->faker->randomElement([2000, 3000, 2500]),
      'add_on_charge'      => $this->faker->randomElement([0, 500, 300, 200]),
    ];
  }
}
