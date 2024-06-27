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
    Schema::create('order_products', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('order_id')->nullable();
      $table->unsignedInteger('product_id')->nullable();
      $table->integer('quantity')->nullable();
      $table->integer('price')->nullable();
      $table->integer('total_price')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('order_products');
  }
};
