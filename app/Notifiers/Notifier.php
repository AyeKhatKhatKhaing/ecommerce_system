<?php
namespace App\Notifiers;

abstract class Notifier {
  public function __construct() {
    $this->notify();
  }

  abstract public function via();

  abstract public function toSms();

  public function notify() {
    foreach ($this->via() as $via) {
      $instance = new $via;
      $instance->send($this);
    }
  }
}
