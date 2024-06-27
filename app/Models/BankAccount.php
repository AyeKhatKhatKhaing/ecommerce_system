<?php
namespace App\Models;

use App\Casts\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'image'  => Image::class,
    'status' => 'boolean',
  ];
}
