<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankAccount>
 */
class BankAccountFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition() {
    return [
      'name'   => $this->faker->name(),
      'number' => $this->faker->randomNumber(8, true),
      'status' => 1,
    ];
  }
}
