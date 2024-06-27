<?php
namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {
  /**
   * order listing
   *
   * @param  Request $request
   * @return void
   */
  public function listing(Request $request) {
    $request->validate([
      'page'   => 'required|numeric',
      'limit'  => 'required|numeric',
      'status' => 'required|in:processing,cancel,confirm,finished',
    ]);

    $query = Order::query();
    if (isset($request->status)) {
      $query = $query->where('status', $request->status);
    }

    $result = $query
      ->where('customer_id', Auth::id())
      ->orderBy('id', 'desc')
      ->paginate($request->limit);

    return response()->json([
      'success'       => true,
      'can_load_more' => canLoadMore($result),
      'total'         => $result->total(),
      'data'          => $result->getCollection(),
    ]);
  }

  /**
   * Order detail
   *
   * @return void
   */
  public function detail($id) {
    $order = Order::with('customer', 'orderProduct', 'orderProduct.product', 'bankAccount', 'deliveryFee')
      ->where('customer_id', Auth::id())
      ->where('id', $id)
      ->first();
    if (!$order) {
      throw new MyException('Order Not Found', 404);
    }

    return response()->json([
      'success' => true,
      'data'    => $order,
    ]);
  }
}
