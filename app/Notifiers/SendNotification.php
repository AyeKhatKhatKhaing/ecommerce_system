<?php
namespace App\Notifiers;

use App\Models\Order;
use App\Channels\DatabaseChannel;

class SendNotification extends Notifier {
  public Order $order;

  public $messageForCustomer = [];

  /**
   * class constructor
   *
   * @param String $phoneNumber
   */
  public function __construct(Order $order) {
    $this->order = $order;
    $this->handleMessage();
    parent::__construct();
  }

  /**
   * add Channel
   *
   * @return void
   */
  public function via() {
    return [DatabaseChannel::class];
  }

  public function handleMessage() {
    $this->messageForCustomer = [
      Order::ON_CANCEL => [
        'title' => 'Order Cancel',
        'body'  => 'သင်ရဲ့အော်ဒါ မအောင်မြင်ပါ။ကျေးဇူးပြူ၍ အော်ဒါအသစ်ထပ်မံမှာယူပေးပါ။',
      ],

      Order::ON_CONFIRM => [
        'title' => 'Order Confrim',
        'body'  => 'သင်ရဲ့အော်ဒါ အောင်မြင်ပါသည်။ ၀ယ်ယူအားပေးမှု့ အတွက်ကျေးဇူးတင်ပါသည်။',
      ],

      Order::ON_FINISHED => [
        'title' => 'Order Finished',
        'body'  => 'သင်ရဲ့အော်ဒါအား အောင်မြင်စွာပို့ဆောင်ပြီးပါပြီ။။ ၀ယ်ယူအားပေးမှု့ အတွက်ကျေးဇူးတင်ပါသည်။',
      ],
    ];
  }

  /**
   * payload sms data
   */
  public function toSms() {
  }

  public function toDatabase() {
    $payload = [];
    $payload = [
      'user_id'      => $this->order->customer->customer_id,
      'content_id'   => $this->order->id,
      'content_type' => $this->order->status, 
      'title'        => $this->messageForCustomer[$this->order->status]['title'],
      'body'         => $this->messageForCustomer[$this->order->status]['body'],
      'seen'         => 0,
      'created_at'   => now(),
      'updated_at'   => now(),
    ];

    return $payload;
  }
}
