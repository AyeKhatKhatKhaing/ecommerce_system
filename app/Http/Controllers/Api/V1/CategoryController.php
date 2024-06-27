<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
  public function listing(Request $request) {
    $query = Category::query();

    $result = $query
      ->orderBy('created_at', 'desc')
      ->get();

    return response()->json([
      'success' => true,
      'data'    => $result,
    ]);
  }
}
