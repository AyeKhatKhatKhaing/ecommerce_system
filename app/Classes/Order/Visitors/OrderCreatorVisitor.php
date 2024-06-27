<?php
namespace App\Classes\Order\Visitors;

use App\Classes\Order\InvoiceOrder;

interface OrderCreatorVisitor {
  public function run(InvoiceOrder $sale);
}