<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('order_products', function (Blueprint $table) {
      $table->unsignedBigInteger('customer_id')->after('product_id')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('order_products', function (Blueprint $table) {
      $table->dropColumn('customer_id');
    });
  }
};
