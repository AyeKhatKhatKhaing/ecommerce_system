<?php
namespace App\Http\Repository;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CartListingResource;

class CartRepository {
  public Request $request;

  public $list = [];

  public $totalPrice = 0;

  public function __construct(Request $request) {
    $this->request = $request;
  }

  /**
   * cart lising
   *
   * @return void
   */
  public function cartListing() {
    $query = Cart::query();

    $result = $query
      ->with('product', 'product.brand', 'product.category', 'product.images')
      ->whereHas('product', function ($p) {
        return $p->where('is_sold_out', 0);
      })
      ->where('user_id', Auth::id())
      ->latest()
      ->get();

    return response()->json([
      'success' => true,
      'data'    => CartListingResource::collection($result),
    ]);
  }

  /**
   * cart count
   *
   * @return void
   */
  public function cartCountGet() {
    $cartCount = Cart::where('user_id', Auth::id())
      ->count();

    return response()->json([
      'success'    => true,
      'cart_count' => $cartCount,
    ]);
  }

  /**
   * variations create
   *
   * @return void
   */
  public function cartCreate() {
    $product = Product::where('is_sold_out', 0)
      ->where('id', $this->request->product_id)
      ->first();

    if (!$product) {
      throw new MyException('Product Not Found', 404);
    }

    $cart             = new Cart();
    $cart->user_id    = Auth::id();
    $cart->product_id = $product->id;
    $cart->size       = $this->request->size;
    $cart->quantity   = $this->request->quantity;
    $cart->save();

    return response()->json([
      'success' => true,
      'message' => 'Successfully Created',
    ]);
  }

  /**
   * Update Cart Variation
   *
   * @param [type] $cartId
   * @param [type] $id
   * @return void
   */
  public function updateCart($id) {
    $product = Product::where('is_sold_out', 0)
      ->where('id', $this->request->product_id)
      ->first();

    if (!$product) {
      throw new MyException('Product Not Found', 404);
    }

    $cart = Cart::find($id);
    if (!$cart) {
      throw new MyException('Cart Not Found', 404);
    }

    $cart->user_id    = Auth::id();
    $cart->product_id = $product->id;
    $cart->size       = $this->request->size;
    $cart->quantity   = $this->request->quantity;
    $cart->update();

    return response()->json([
      'success' => true,
      'message' => 'Successfully Updated',
    ]);
  }

  /**
   * delete cart
   *
   * @param [type] $id
   * @return void
   */
  public function deleteCart($id) {
    $cart = Cart::find($id);
    if (!$cart) {
      throw new MyException('Cart Not Found', 404);
    }
    $cart->delete();

    return response()->json([
      'success' => true,
      'message' => 'Successfully Deleted',
    ]);
  }

  /**
   * Clear Cart
   *
   * @return void
   */
  public function clearCart() {
    $customer = Customer::find(Auth::id());
    $customer->cartProducts()->delete();

    return response()->json([
      'success' => true,
      'message' => 'Successfully Clear Cart',
    ]);
  }
}
