<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderProduct;

class CustomerController extends Controller {
  /**
   * customer listing view
   *
   * @return void
   */
  public function index() {
    return view('backend.customers.index');
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $customer = Customer::with('orderCustomer');

    return datatables($customer)
      ->addColumn('image', function ($each) {
        return '<img src="' . $each->profile_image . '" class="profile_thumbnail_img"/>';
      })
      ->addColumn('action', function ($each) {
        if ($each->orderCustomer) {
          $edit_icon = '<a href="' . route('customer.view', $each->id) . '" class="view_btn mr-3"><i class="ri-eye-fill"></i></a>';

          return '<div class="action_icon">' . $edit_icon . '</div>';
        }

        return '-';
      })
      ->rawColumns(['image', 'action'])
      ->toJson();
  }

  public function getCustomerProducts($id) {
    $customer = Customer::findOrFail($id);
    return view('backend.customers.view_products', compact('id', 'customer'));
  }

  public function customerProductServerSide($id) {
    $orderProduct = OrderProduct::with('customer', 'product', 'product.images')
      ->whereHas('customer', function($c) use ($id) {
        return $c->where('id', $id);
      });

    return datatables($orderProduct)
      ->filterColumn('name', function($query, $keyword) {
        $query->whereHas('product', function($q1) use ($keyword) {
          $q1->where('name', 'like', '%' . $keyword . '%');
        });
      })
      ->addColumn('image', function ($each) {
        $image = $each->product->images()->first();
        if ($image) {
          return '<img src="' . $image->path . '" class="thumbnail_img"/>';
        } else {
          return '<img src="' . config('app.url') . '/images/default.jpg' . '" class="thumbnail_img"/>';
        }
      })
      ->editColumn('price', function($each) {
        return number_format($each->price) . ' Ks';
      })
      ->editColumn('total_price', function($each) {
        return number_format($each->total_price) . ' Ks';
      })
      ->addColumn('name', function($each) {
        $product = $each->product;
        return '<p>' . $product->name . '</p>';
      })
      ->rawColumns(['name', 'image'])
      ->toJson();
  }
}
