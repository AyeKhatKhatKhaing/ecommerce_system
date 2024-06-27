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
    Schema::create('order_customers', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('order_id')->nullable();
      $table->unsignedBigInteger('customer_id')->nullable();
      $table->string('name')->nullable();
      $table->string('phone')->nullable();
      $table->string('delivery_address')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('order_customers');
  }
};
