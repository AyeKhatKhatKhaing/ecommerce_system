<?php
namespace App\Types;

class SmsPayload {
  private String $_toPhone;

  private String $_message;

  private String $_sender;

  public function toPhone(String $toPhone) {
    $this->_toPhone = $toPhone;
    return $this;
  }

  public function message(String $message) {
    $this->_message = $message;
    return $this;
  }

  public function sender(String $sender) {
    $this->_sender = $sender;
    return $this;
  }

  /**
   * sms payload
   *
   * @return array
   */
  public function toArray() {
    $payload = [
      'to'      => $this->_toPhone,
      'message' => $this->_message,
      'sender'  => $this->_sender,
    ];

    return $payload;
  }
}
