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
    Schema::table('delivery_regions', function (Blueprint $table) {
      $table->boolean('is_cod')->after('name')->default(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('delivery_regions', function (Blueprint $table) {
      $table->dropColumn('is_cod');
    });
  }
};
