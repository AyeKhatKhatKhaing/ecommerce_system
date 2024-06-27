<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'quantity' => 'integer',
  ];

  public function product() {
    return $this->belongsTo(Product::class, 'product_id', 'id');
  }

  public function customer() {
    return $this->belongsTo(Customer::class, 'user_id', 'id');
  }
}
