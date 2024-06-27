<?php
namespace App\Models;

use App\Casts\ProfileImage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable {
  use HasFactory;
  use Notifiable;
  use HasApiTokens;

  protected $guarded = [];

  protected $casts = [
    'is_phone_verified' => 'boolean',
    'profile_image'     => ProfileImage::class,
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
  ];

  public function setPasswordAttribute($value) {
    $this->attributes['password'] = Hash::make($value);
  }

  public function cartProducts() {
    return $this->hasMany(Cart::class, 'user_id', 'id');
  }

  public function orderCustomer() {
    return $this->hasOne(OrderCustomer::class, 'customer_id', 'id');
  }

  public function orderProducts() {
    return $this->hasMany(OrderProduct::class, 'customer_id', 'id');
  }
}
