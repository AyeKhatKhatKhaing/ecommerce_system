<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model {
  use HasFactory;

  protected $table = 'order_customers';

  protected $guarded = [];

  public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'id');
  }

  public function customer() {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
}
