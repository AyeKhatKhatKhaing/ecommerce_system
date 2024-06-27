<?php
namespace App\Channels;

use App\Models\Notification;

class DatabaseChannel {
  public function send($notifier) {
    if (method_exists($notifier, 'toDatabase')) {
      $notifications = $notifier->toDatabase();
      Notification::insert($notifications);
    }
  }
}