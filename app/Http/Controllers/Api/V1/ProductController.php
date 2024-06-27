<?php
namespace App\Http\Controllers\Api\V1;

use App\Exceptions\MyException;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller {
  public function listing(Request $request) {
    $request->validate([
      'page'  => 'numeric|required',
      'limit' => 'numeric|required',
    ]);

    $query = Product::query();

    if (isset($request->category_id)) {
      $query = $query->where('category_id', $request->category_id);
    }

    if (isset($request->brand_id)) {
      $query = $query->where('brand_id', $request->brand_id);
    }

    $result = $query
      ->with('images')
      ->where('is_sold_out', 0)
      ->orderBy('created_at', 'desc')
      ->paginate($request->limit);

    return response()->json([
      'success'       => true,
      'can_load_more' => canLoadMore($result),
      'total'         => $result->total(),
      'data'          => $result->getCollection(),
    ]);
  }

  /**
   * new Product listing
   *
   * @return void
   */
  public function newProductListing() {
    $query = Product::query(); 

    $result = $query
      ->with('images')
      ->where('is_sold_out', 0)
      ->orderBy('id', 'desc')
      ->limit(10)
      ->get();

    return response()->json([
      'success' => true,
      'data'    => $result,
    ]);
  }

  /**
   * Product Detail
   *
   * @param [type] $id
   * @return void
   */
  public function detail($id) {
    $product = Product::with('category', 'brand', 'images')
      ->where('is_sold_out', 0)
      ->where('id', $id)
      ->first();

    if (!$product) {
      throw new MyException('Product Not Found', 404);
    }

    return response()->json([
      'success' => true,
      'data'    => $product,
    ]);
  }
}
