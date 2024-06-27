<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\BankAccount;
use App\Models\DeliveryFee;
use App\Models\DeliveryRegion;
use App\Models\OrderProduct;
use App\Models\ProductImage;
use App\Models\OrderCustomer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run() {
    File::deleteDirectory(storage_path('app/seeder-images'));

    User::truncate();
    User::factory(1)->create();

    BankAccount::truncate();
    BankAccount::factory(5)->create();

    Brand::truncate();
    Brand::factory(15)->create();

    Category::truncate();
    Category::factory(15)->create();

    Customer::truncate();
    Customer::factory(80)->create();

    DeliveryRegion::truncate();
    $this->call([
      DeliveryRegionSeeder::class,
    ]);

    DeliveryFee::truncate();
    DeliveryFee::factory(6)->create();

    Product::truncate();
    Product::factory(20)->create();

    ProductImage::truncate();
    ProductImage::factory(20)->create();

    Cart::truncate();
    Cart::factory(50)->create();

    Order::truncate();
    OrderProduct::truncate();
    OrderCustomer::truncate();

    $this->call([
      OrderSeeder::class,
    ]);
  }
}
