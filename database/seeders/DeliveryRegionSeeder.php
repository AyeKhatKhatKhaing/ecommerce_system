<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryRegionSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $regions = [];
    $regions = [
      [
        'name'       => 'ရန်ကုန်တိုင်းဒေသကြီး',
        'is_cod'     => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name'       => 'ပဲခူးတိုင်းဒေသကြီး',
        'is_cod'     => 0,
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('delivery_regions')->insert($regions);
  }
}
