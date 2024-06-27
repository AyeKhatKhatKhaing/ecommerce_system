<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request                                        $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request) {
    $result = [
      'id'           => $this->id,
      'user_id'      => $this->user_id,
      'content_id'   => $this->content_id,
      'content_type' => $this->content_type,
      'title'        => $this->title,
      'body'         => $this->body,
      'order_number' => $this->order->order_number,
    ];

    return $result;
  }
}
