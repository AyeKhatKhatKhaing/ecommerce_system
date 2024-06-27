<?php
namespace App\Http\Controllers\Api\V1;

use App\Exceptions\MyException;
use App\Http\Controllers\Controller;
use App\Http\Repository\CheckoutRepository;
use App\Models\DeliveryRegion;
use Illuminate\Http\Request;

class CheckoutController extends Controller {
  /**
   * get Detail Checkout
   *
   * @param  Request $request
   * @return void
   */
  public function getCheckout(Request $request) {
    $request->validate([
      'region_id'   => 'required',
      'delivery_id' => 'nullable',
    ]);

    $checkoutRepo = new CheckoutRepository($request);
    return $checkoutRepo->getCheckout();
  }

  /**
   * Checkout Create
   *
   * @param  Request $request
   * @return void
   */
  public function checkout(Request $request) {
    $rules = [
      'name'             => 'required|string',
      'phone'            => ['required', 'numeric', 'regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
      'delivery_address' => 'required',
      'region_id'        => 'required',
      'delivery_fee_id'  => 'required',
    ];

    $region = DeliveryRegion::find($request->region_id);
    if (!$region) {
      throw new MyException('Region Not Found', 404);
    }

    if ($region->is_cod == false) {
      $rules['screenshot']      = 'required|image';
      $rules['bank_account_id'] = 'required';
    } else {
      $rules['bank_account_id'] = 'nullable';
    }

    $ret = validatorFail($request, $rules);

    if (!empty($ret) && count($ret) > 0) {
      return response()->json([
        'code'    => 422,
        'success' => false,
        'message' => 'Validation Error',
        'error'   => $ret,
      ], 200);
    }

    $checkoutRepo = new CheckoutRepository($request);
    return $checkoutRepo->createOrder();
  }
}
