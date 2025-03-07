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
    Schema::table('delivery_fees', function (Blueprint $table) {
      $table->integer('add_on_charge')->after('price')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('delivery_fees', function (Blueprint $table) {
      $table->dropColumn('add_on_charge');
    });
  }
};
