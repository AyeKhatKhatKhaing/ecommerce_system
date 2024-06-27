<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'seen' => 'boolean',
  ];

  public function order() {
    return $this->hasOne(Order::class, 'id', 'content_id');
  }
}
