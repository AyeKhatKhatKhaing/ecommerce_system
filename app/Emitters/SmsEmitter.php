<?php
namespace App\Emitters;

use App\Types\SmsPayload;
use Illuminate\Support\Facades\Http;

class SmsEmitter {
  public const BASE_URL = 'https://smspoh.com/api/v2/send';

  /**
   * payload to sent
   *
   * @var SmsPayload
   */
  public SmsPayload $payload;

  /**
   * dependency for smspayload
   *
   * @param SmsPayload $payload
   */
  public function __construct(SmsPayload $payload) {
    $this->payload = $payload;
  }

  /**
   * emit notification
   *
   * @return void
   */
  public function emit() {
    $token   = config('sms.token');
    $payload = $this->payload->toArray();

    Http::withToken(
      $token,
    )->withHeaders([
      'Content-Type' => 'application/json',
    ])->post(self::BASE_URL, $payload);
  }
}
