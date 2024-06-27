<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LivePhoto;

class LivePhotoController extends Controller {
  public function listing() {
    $photos = LivePhoto::all();

    return response()->json([
      'success' => true,
      'data'    => $photos,
    ]);
  }
}
