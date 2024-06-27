<?php
namespace App\Channels;

use App\Emitters\SmsEmitter;
use App\Notifiers\Notifier;

class SmsChannel {
  /**
   * send sms
   *
   * @param  Notifier $notifier
   * @return void
   */
  public function send(Notifier $notifier) {
    if (method_exists($notifier, 'toSms')) {
      $message = $notifier->toSms();

      if (is_array($message)) {
        foreach ($message as $msg) {
          $fcm = new SmsEmitter($msg);
          $fcm->emit();
        }
      } else {
        $fcm = new SmsEmitter($message);
        $fcm->emit();
      }
    }
  }
}
