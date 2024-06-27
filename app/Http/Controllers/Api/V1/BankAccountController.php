<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;

class BankAccountController extends Controller {
  public function listing() {
    $result = BankAccount::where('status', 1)->get();

    return response()->json([
      'success' => true,
      'data'    => $result,
    ]);
  }
}
