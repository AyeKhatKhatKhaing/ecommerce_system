<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {
  use HasFactory;

  protected $table = 'order_products';

  protected $guarded = [];

  protected $casts = [
    'quantity'    => 'integer', 
    'price'       => 'integer',
    'total_price' => 'integer',
  ];

  public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'id');
  }

  public function product() {
    return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
  }

  public function customer() {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
}
