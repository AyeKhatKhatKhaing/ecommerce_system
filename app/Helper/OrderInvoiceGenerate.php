<?php
namespace App\Helper;

use App\Models\Order;

class OrderInvoiceGenerate {
  public static function orderNumber() {
    $date           = date('Y-m-d H:i:s');
    $timetostr      = strtotime($date);
    $chars          = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $timetostr;
    $generateNumber = '';
    for ($i = 0; $i < 6; $i++) {
      $generateNumber .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    if (Order::where('order_number', $generateNumber)->exists()) {
      return self::orderNumber();
    }

    return '#SA-inbaby_' . $generateNumber;
  }
}