<?php
namespace App\Classes\Order\Visitors;

use App\Models\Order;
use App\Models\DeliveryFee;
use App\Exceptions\MyException;
use App\Classes\Order\InvoiceOrder;

class OrderTotalCalculate implements OrderCreatorVisitor {
  public $sale;

  public function run(InvoiceOrder $sale) : OrderTotalCalculate {
    $this->sale = $sale;

    $fee = DeliveryFee::find($this->sale->request->delivery_fee_id);
    if (!$fee) {
      throw new MyException('Delivery Fee Not Found', 404);
    }

    $deliveryFee = $fee->price + (empty($fee->add_on_charge) ? 0 : $fee->add_on_charge);

    $this->sale->order->delivery_fee_id = $this->sale->request->delivery_fee_id;
    $this->sale->order->total           = $this->sale->checkoutTotalPrice;
    $this->sale->order->delivery_fee    = $deliveryFee;
    $this->sale->order->grand_total     = $this->sale->checkoutTotalPrice + $deliveryFee;
    $this->sale->order->status          = Order::ON_PROCESSING;

    return $this;
  }
}