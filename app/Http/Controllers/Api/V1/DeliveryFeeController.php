<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryFeeListingResource;
use App\Models\DeliveryFee;
use App\Models\DeliveryRegion;

class DeliveryFeeController extends Controller {
  /**
   * region Listing
   *
   * @return void
   */
  public function regionListing() {
    $result = DeliveryRegion::all();

    return response()->json([
      'success' => true,
      'data'    => $result,
    ]);
  }

  /**
   * delivery Fee listing
   *
   * @return void
   */
  public function listing($regionId) {
    $result = DeliveryFee::where('delivery_region_id', $regionId)
      ->get();

    return response()->json([
      'success' => true,
      'data'    => DeliveryFeeListingResource::collection($result),
    ]);
  }
}
