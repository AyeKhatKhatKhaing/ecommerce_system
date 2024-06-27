<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  protected $casts = [
    'size'        => 'array',
    'is_sold_out' => 'boolean',
    'fix_count'   => 'integer',
    'color'       => 'integer',
    'price'       => 'integer',
  ];

  public function category() {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function brand() {
    return $this->belongsTo(Brand::class, 'brand_id', 'id');
  }

  public function images() {
    return $this->hasMany(ProductImage::class, 'product_id', 'id');
  }
}
