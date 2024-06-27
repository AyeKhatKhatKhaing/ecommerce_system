<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryFeeListingResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request                                        $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request) {
    $result = [
      'id'                 => $this->id,
      'delivery_region_id' => $this->delivery_region_id,
      'township'           => $this->township,
      'price'              => $this->price,
      'add_on_charge'      => $this->add_on_charge ?? 0,
      'total_price'        => $this->price + (empty($this->add_on_charge) ? 0 : $this->add_on_charge),
      'has_on_charge'      => $this->add_on_charge ? true : false,
    ];

    return $result;
  }
}
