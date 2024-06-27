<?php
namespace App\Http\Controllers\Api\V1;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {
  /**
   * Notifications listing
   *
   * @param  Request $request
   * @return void
   */
  public function listing(Request $request) {
    $request->validate([
      'page'  => 'required|numeric',
      'limit' => 'required|numeric',
    ]);

    $query  = Notification::query();
    $result = $query->where('user_id', Auth::id())
      ->orderBy('created_at', 'desc')
      ->paginate($request->limit);

    return response()->json([
      'success'       => true,
      'total'         => $result->total(),
      'can_load_more' => canLoadMore($result),
      'data'          => NotificationResource::collection($result),
    ]);
  }

  /**
   * Get Noti Count
   *
   * @return void
   */
  public function getNotiCount() {
    $notiCount = Notification::where('user_id', Auth::id())
      ->count();

    return response()->json([
      'success'    => true,
      'noti_count' => $notiCount,
    ]);
  }
}
