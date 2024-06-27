<?php
namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\BankAccount;
use App\Models\DeliveryFee;
use Illuminate\Database\Seeder;
use App\Http\Repository\CheckoutRepository;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $faker = Faker::create();

    for ($i = 1; $i <= 30; $i++) {
      $cart         = Cart::first();
      $customer     = Customer::find($cart->user_id);
      $delivery     = DeliveryFee::inRandomOrder()->first();
      $bank_account = BankAccount::inRandomOrder()->first();

      request()->merge([
        'name'             => $customer->name,
        'phone'            => $faker->phoneNumber(),
        'delivery_address' => $faker->address(),
        'delivery_fee_id'  => $delivery->id,
        'bank_account_id'  => $bank_account->id,
        'cart_item_ids'    => [$cart->id],
      ]);

      $checkout = new CheckoutRepository(request(), true, $customer);
      $checkout->createOrder();
    }
  }
}
