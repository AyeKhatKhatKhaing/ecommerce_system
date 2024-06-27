<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model {
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'price'         => 'integer',
    'add_on_charge' => 'integer',
  ];

  public function region() {
    return $this->belongsTo(DeliveryRegion::class, 'delivery_region_id', 'id');
  }
}
