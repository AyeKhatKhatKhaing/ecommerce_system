<?php
namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class DashboardController extends Controller {
  public function index() {
    $order      = Order::query();
    $totalOrder = $order->count();
    if ($totalOrder >= 1000) {
      $totalOrder = $this->convert($totalOrder);
    }

    $todayOrder = $order->whereDate('created_at', Carbon::today())->count();

    $product      = Product::query();
    $totalProduct = $product->count();

    $brand      = Brand::query();
    $totalBrand = $brand->count();

    $mostSellProducts = Product::selectRaw('
      products.name,
      product_images.*,
      SUM(order_products.quantity) total_quantity
    ')
      ->join('product_images', 'product_images.product_id', 'products.id')
      ->leftJoin('order_products', 'order_products.product_id', 'products.id')
      ->groupBy('products.id')
      ->orderBy('total_quantity', 'desc')
      ->where('order_products.quantity', '!=', 0)
      ->limit(10)
      ->get();

    $mostBuyCustomer = Customer::selectRaw('
        customers.id,
        customers.name,
        customers.profile_image,
        SUM(orders.grand_total) as amount
      ')
      ->leftJoin('order_customers', 'order_customers.customer_id', 'customers.id')
      ->leftJoin('orders', 'orders.id', 'order_customers.order_id')
      ->groupBy('customers.id')
      ->orderBy('amount', 'desc')
      ->where('orders.grand_total', '!=', 0)
      ->limit(10)
      ->get();

    return view('backend.dashboard.index', compact('totalOrder', 'todayOrder', 'totalProduct', 'totalBrand', 'mostSellProducts', 'mostBuyCustomer'));
  }

  /**
   * Convert thousand, million 
   *
   * @param [type] $value
   * @return void
   */
  public function convert($value) {
    $number = $value / 1000;
    if ($number >= 1000) {
      $millions = $number / 1000;
      return number_format($millions) . 'M';
    }
    return number_format($number) . 'K';
  }

  public function editProfile() {
    $admin = Auth::user();
    return view('backend.profile', compact('admin'));
  }

  public function updateProfile(UpdateProfileRequest $request) {
    $admin = User::find(Auth::id());

    $admin->name     = $request->name ?? $admin->name;
    $admin->email    = $request->email ?? $admin->email;
    $admin->password = $request->password ?? $admin->password;
    $admin->save();

    return redirect()->route('dashboard')->with('updated', 'အောင်မြင်ပါသည်။');
  }
}
