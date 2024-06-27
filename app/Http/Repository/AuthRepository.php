<?php
namespace App\Http\Repository;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository {
  public Request $request;

  /**
   * constructor class
   *
   * @param Request $request
   */
  public function __construct(Request $request) {
    $this->request = $request;
  }

  /**
   * logout User
   *
   * @return void
   */
  public function userLogout() {
    Auth::user()->token()->revoke();

    return response()->json([
      'success' => true,
      'message' => 'Logged out Successfully.',
    ]);
  }

  /**
   * login with user phone number
   *
   * @return void
   */
  public function userloginWithPhone() {
    $customer = Customer::where('phone', $this->request->phone)->first();
    if ($customer) {
      if (Hash::check($this->request->password, $customer->password)) {
        Auth::login($customer);
        $token = $this->guard()->user()->createToken('api-user')->accessToken;
        return response()
          ->json(['status' => 'success', 'token' => $token, 'user' => $customer], 200)
          ->header('Authorization', $token);
      } else {
        return [
          'success' => false,
          'code'    => 500,
          'error'   => 'Wrong Password',
        ];
      }
    } else {
      return [
        'success' => false,
        'code'    => 500,
        'error'   => 'No user found with this phone number',
      ];
    }
  }

  /**
   * Register with user phone number
   *
   * @return void
   */
  public function userRegisterWithPhone() {
    $user = Customer::create([
      'name'              => $this->request->name,
      'phone'             => $this->request->phone,
      'password'          => $this->request->password,
      'is_phone_verified' => 1,
    ]);

    Auth::login($user);
    $token = $this->guard()->user()->createToken('api-user')->accessToken;
    return response()
      ->json([
        'success' => true,
        'token'   => $token,
        'user'    => $this->guard()->user()->refresh(),
      ])
      ->header('Authorization', $token);
  }

  /**
   * guard
   *
   * @return object
   */
  private function guard() {
    return Auth::guard();
  }
}
