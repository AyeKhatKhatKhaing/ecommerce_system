<?php
namespace App\Classes\Order\Visitors;

use App\Models\OrderCustomer;
use App\Classes\Order\InvoiceOrder;

class OrderCustomerCreator implements OrderCreatorVisitor {
  public $sale;

  public function run(InvoiceOrder $sale) : OrderCustomerCreator {
    $this->sale = $sale;

    $customer                   = new OrderCustomer();
    $customer->order_id         = $this->sale->order->id;
    $customer->customer_id      = $this->sale->customer->id;
    $customer->name             = $this->sale->request->name;
    $customer->phone            = $this->sale->request->phone;
    $customer->delivery_address = $this->sale->request->delivery_address;
    $customer->save();

    return $this;
  }
}