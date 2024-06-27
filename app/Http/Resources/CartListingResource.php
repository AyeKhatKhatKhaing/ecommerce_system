<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartListingResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request                                        $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request) {
    $result = [
      'id'         => $this->id,
      'user_id'    => $this->user_id,
      'product_id' => $this->product_id,
      'size'       => $this->size,
      'quantity'   => $this->quantity,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'product'    => [
        'id'            => $this->product->id,
        'name'          => $this->product->name,
        'description'   => $this->product->description,
        'brand_name'    => $this->product->brand->name ?? null,
        'category_name' => $this->product->category->name ?? null,
        'price'         => $this->product->price,
        'color'         => $this->product->color,
        'size'          => $this->product->size,
        'is_sold_out'   => $this->product->is_sold_out,
        'fix_count'     => $this->product->fix_count,
        'images'        => $this->product->images,
      ],
    ];
    return $result;
  }
}
