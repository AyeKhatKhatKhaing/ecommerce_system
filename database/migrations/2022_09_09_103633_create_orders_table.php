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
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->string('order_number')->nullable();
      $table->unsignedBigInteger('customer_id')->nullable();
      $table->unsignedInteger('bank_account_id')->nullable();
      $table->string('payment_type')->nullable();
      $table->dateTime('paid_at')->nullable();
      $table->string('payment_screenshot')->nullable();
      $table->unsignedBigInteger('delivery_fee_id')->nullable();
      $table->integer('total')->nullable();
      $table->integer('grand_total')->nullable();
      $table->integer('delivery_fee')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('orders');
  }
};
