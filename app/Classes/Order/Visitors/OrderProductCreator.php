<?php
namespace App\Classes\Order\Visitors;

use App\Models\OrderProduct;
use App\Classes\Order\InvoiceOrder;

class OrderProductCreator implements OrderCreatorVisitor {
  protected $insertProductArray = [];
  public $sale;

  public function run(InvoiceOrder $sale) : OrderProductCreator {
    $cartItems  = $sale->items;
    $this->sale = $sale;

    foreach ($cartItems as $item) {
      $price = $item['product']['price'] * $item['quantity'];
      $sale->checkoutTotalPrice += $price;

      $insertProductArray[] = [
        'order_id'    => $this->sale->order->id,
        'product_id'  => $item['product']['id'],
        'customer_id' => $this->sale->customer->id,
        'quantity'    => $item['quantity'],
        'price'       => $item['product']['price'],
        'size'        => $item['size'],
        'total_price' => $price,
        'created_at'  => now(),
        'updated_at'  => now(),
      ];
    }

    // mysql prevent load
    OrderProduct::insert($insertProductArray);
    return $this;
  }
}