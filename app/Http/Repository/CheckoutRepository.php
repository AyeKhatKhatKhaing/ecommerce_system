<?php
namespace App\Http\Repository;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
use Illuminate\Support\Facades\DB;
use App\Classes\Order\InvoiceOrder;
use App\Models\Customer;
use App\Models\DeliveryRegion;
use Illuminate\Support\Facades\Auth;

class CheckoutRepository {
  public Request $request;

  public $list = [];

  public $totalPrice = 0;

  public Order $order;

  public $insertProductArray = [];

  public $checkoutTotalPrice = 0;

  public $testing;

  public $testCustomer;

  public $authCustomer;

  public function __construct(Request $request, $testing = false, Customer $testCustomer = null) {
    $this->request      = $request;
    $this->testing      = $testing;
    $this->testCutsomer = $testCustomer;
    $this->authCustomer = $testing ? Customer::find($testCustomer->id) : Customer::find(Auth::id());
  }

  /**
   * Get Detail Checkout
   *
   * @return void
   */
  public function getCheckout() {
    $cartProducts = Cart::with('product')
      ->whereHas('product', function($p) {
        return $p->where('is_sold_out', 0);
      })
      ->where('user_id', Auth::id())
      ->get();

    if (!$cartProducts || $cartProducts->count() <= 0) {
      throw new MyException('No Items in the carts', 404);
    }

    $fee = DeliveryFee::find($this->request->delivery_id);
    if (!$fee) {
      $deliveryFee = 0;
    } else {
      $deliveryFee = $fee->price + (empty($fee->add_on_charge) ? 0 : $fee->add_on_charge);
    }

    $region = DeliveryRegion::find($this->request->region_id);
    if (!$region) {
      throw new MyException('Region Not Found', 404);
    }

    $cartItems = $cartProducts->toArray();
    $this->_eachProduct($cartItems);

    return response()->json([
      'success' => true,
      'data'    => [
        'list'   => $this->list,
        'is_cod' => $region->is_cod,
        'prices' => [
          'delivery_fee' => $deliveryFee,
          'total'        => $this->totalPrice,
          'grand_total'  => $deliveryFee + $this->totalPrice,
        ],
      ],
    ]);
  }

  /**
   * Each Product List
   *
   * @param [type] $cartItems
   * @return void
   */
  private function _eachProduct($cartItems) {
    foreach ($cartItems as $item) {
      $product = Product::with('brand', 'category', 'images')
        ->find($item['product_id'])->toArray();

      $cartTotal = $product['price'] * $item['quantity'];
      $this->totalPrice += $cartTotal;

      $productList = [
        'id'            => $product['id'],
        'name'          => $product['name'],
        'description'   => $product['description'],
        'brand_name'    => $product['brand']['name'] ?? null,
        'category_name' => $product['category']['name'] ?? null,
        'price'         => $product['price'],
        'color'         => $product['color'],
        'size'          => $product['size'],
        'is_sold_out'   => $product['is_sold_out'],
        'fix_count'     => $product['fix_count'],
        'images'        => $product['images'],
      ];

      $this->list[] = [
        'cart_id'    => $item['id'],
        'user_id'    => $item['user_id'],
        'product_id' => $item['product_id'],
        'quantity'   => $item['quantity'],
        'size'       => $item['size'],
        'created_at' => $item['created_at'],
        'updated_at' => $item['updated_at'],
        'product'    => $productList,
        'total'      => $cartTotal,
      ];
    }
  }

  /**
   * Create Order
   *
   * @return void
   */
  public function createOrder() {
    DB::beginTransaction();
    try {
      // method changing
      (new InvoiceOrder($this->request))
        ->setCartItems($this->_cartItems())
        ->setCustomer($this->authCustomer)
        ->create();

      DB::commit();
      return response()->json([
        'success' => true,
        'message' => 'Order Created Successfully',
      ]);
    } catch(Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  /**
   * Cart item
   *
   * @return void
   */
  private function _cartItems() {
    $cartProducts = Cart::with('product')
      ->whereHas('product', function($p) {
        return $p->where('is_sold_out', 0);
      })
      ->where('user_id', $this->authCustomer->id)
      ->get();

    if (!$cartProducts || $cartProducts->count() <= 0) {
      throw new MyException('No Items in the carts', 404);
    }
    return $cartProducts->toArray();
  }
}