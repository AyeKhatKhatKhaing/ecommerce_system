<?php
namespace App\Http\Controllers\Api\V1;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller {
  /**
   * Brand Listing
   *
   * @param  Request $request
   * @return void
   */
  public function listing(Request $request) {
    $query  = Brand::query();
    $result = $query
      ->orderBy('created_at', 'desc')
      ->get();

    return response()->json([
      'success' => true,
      'data'    => $result,
    ]);
  }
}
