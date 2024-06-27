<?php
namespace App\Http\Controllers\Api\V1;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\CartRepository;

class CartController extends Controller {
  /**
   * cart listing
   *
   * @param  Request $request
   * @return void
   */
  public function listing(Request $request) {
    $cartRepo = new CartRepository($request);
    return $cartRepo->cartListing();
  }

  public function getCartsCount(Request $request) {
    $cartRepo = new CartRepository($request);
    return $cartRepo->cartCountGet();
  }

  /**
   * create carts
   *
   * @param  Request $request
   * @return void
   */
  public function create(Request $request) {
    $rules = [
      'product_id' => 'required',
      'size'       => 'required|string',
      'quantity'   => 'required|numeric|min:10',
    ];

    $ret = validatorFail($request, $rules);

    if (!empty($ret) && count($ret) > 0) {
      return response()->json([
        'code'    => 422,
        'success' => false,
        'message' => 'Validation Error',
        'error'   => $ret,
      ], 200);
    }

    $cartRepo = new CartRepository($request);
    return $cartRepo->cartCreate();
  }

  public function update($id, Request $request) {
    $request->validate([
      'product_id' => 'required',
      'size'       => 'required|string',
      'quantity'   => 'required|numeric',
    ]);

    $cartRepo = new CartRepository($request);
    return $cartRepo->updateCart($id);
  }

  /**
   * cart Delete
   *
   * @param [type] $id
   * @param  Request $request
   * @return void
   */
  public function destroy($id, Request $request) {
    $cartRepo = new CartRepository($request);
    return $cartRepo->deleteCart($id);
  }

  /**
   * cart Clear
   *
   * @return void
   */
  public function cartClear(Request $request) {
    $cartRepo = new CartRepository($request);
    return $cartRepo->clearCart();
  }
}
