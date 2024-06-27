<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\AuthRepository;

class AuthController extends Controller {
  /**
   * logout for user
   *
   * @return void
   */
  public function logout(Request $request) {
    $authRepo = new AuthRepository($request);
    return $authRepo->userLogout();
  }

  /**
   * Login with Phone Number
   *
   * @param  Request $request
   * @return void
   */
  public function loginWithPhone(Request $request) {
    $rules = [
      'phone'    => 'required|string',
      'password' => 'required|string',
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

    $authRepo = new AuthRepository($request);
    return $authRepo->userloginWithPhone();
  }

  /**
   * Register WIth Phone Number
   *
   * @param  Request $request
   * @return void
   */
  public function registerWithPhone(Request $request) {
    $rules = [
      'name'     => 'required|string',
      'phone'    => ['required', 'unique:customers,phone', 'numeric', 'regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
      'password' => 'required|string|min:8|confirmed',
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

    $authRepo = new AuthRepository($request);
    return $authRepo->userRegisterWithPhone();
  }

  /**
   * Auth User
   *
   * @return void
   */
  public function user() {
    return response()->json([
      'success' => true,
      'user'    => Auth::user(),
    ]);
  }
}
