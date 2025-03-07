<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('customers', function (Blueprint $table) {
      $table->id();
      $table->string('name')->nullable();
      $table->string('phone')->nullable();
      $table->string('password')->nullable();
      $table->string('profile_image')->nullable();
      $table->boolean('is_phone_verified')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('customers');
  }
};
