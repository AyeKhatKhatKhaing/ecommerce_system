<?php
namespace App\Models;

use App\Casts\PaymentScreenShot;
use App\Notifiers\SendNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model {
  use HasFactory;

  protected $table = 'orders';

  const ON_PROCESSING = 'processing';
  const ON_CANCEL     = 'cancel';
  const ON_CONFIRM    = 'confirm';
  const ON_FINISHED   = 'finished';

  protected $guarded = [];

  protected $casts = [
    'total'              => 'integer',
    'grand_total'        => 'integer',
    'delivery_fee'       => 'integer',
    'payment_screenshot' => PaymentScreenShot::class,
  ];

  public function customer() {
    return $this->hasOne(OrderCustomer::class, 'order_id', 'id');
  }

  public function orderProduct() {
    return $this->hasMany(OrderProduct::class, 'order_id', 'id');
  }

  public function bankAccount() {
    return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
  }

  public function deliveryFee() {
    return $this->belongsTo(DeliveryFee::class, 'delivery_fee_id', 'id');
  }

  protected static function booted() {
    static::updated(function ($order) {
      if ($order->status !== Order::ON_PROCESSING && $order->status != $order->getOriginal('status')) {
        new SendNotification($order);
      }
    });
  }
}
