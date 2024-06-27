<?php
namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\DeliveryRegion;

class OrderController extends Controller {
  /**
   * Order listing view
   *
   * @return void
   */
  public function index() {
    return view('backend.orders.index');
  }

  /**
   * All orders
   *
   * @return void
   */
  public function allOrders() {
    return view('backend.orders.all_orders');
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function allOrderServerSide() {
    $order = Order::with('customer', 'customer.customer')
      ->orderBy('created_at', 'desc');

    return datatables($order)
      ->editColumn('created_at', function($each) {
        return '<span class="badge rounded-pill bg-success p-2">' . Carbon::parse($each->created_at)->format('d M Y, H:i:s') . '</span>';
      })
      ->filterColumn('customer', function($query, $keyword) {
        $query->whereHas('customer', function($q1) use ($keyword) {
          $q1->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('phone', 'like', '%' . $keyword . '%');
        });
      })
      ->editColumn('grand_total', function($each) {
        return number_format($each->grand_total) . ' Ks';
      })
      ->addColumn('customer', function($each) {
        $name  = !empty($each->customer->name) ? '<p><i class="ri-user-fill me-3"></i>' . $each->customer->name . '</p>' : '';
        $phone = !empty($each->customer->phone) ? '<p><i class="ri-phone-fill me-3"></i>' . $each->customer->phone . '</p>' : '';

        return '<div class="ms-2">' . $name . $phone . '</div>';
      })
      ->addColumn('action', function ($each) {
        $view_btn = '<a href="' . route('order.detail', $each->id) . '" class="view_btn mr-2">View</a>';
        return '<div class="action_icon mt-2">' . $view_btn . '</div>';
      })
      ->rawColumns(['created_at', 'action', 'customer'])
      ->toJson();
  }

  public function detail($id) {
    $order = Order::with('customer', 'orderProduct', 'orderProduct.product', 'orderProduct.product.images', 'bankAccount', 'deliveryFee')
      ->findOrFail($id);

    $region = DeliveryRegion::find($order->deliveryFee->delivery_region_id);

    return view('backend.orders.detail', compact('order', 'region'));
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $order = Order::with('customer', 'customer.customer')
      ->where('status', Order::ON_PROCESSING)
      ->orderBy('created_at', 'desc');

    return datatables($order)
      ->editColumn('created_at', function($each) {
        return '<span class="badge rounded-pill bg-success p-2">' . Carbon::parse($each->created_at)->format('d M Y, H:i:s') . '</span>';
      })
      ->filterColumn('customer', function($query, $keyword) {
        $query->whereHas('customer', function($q1) use ($keyword) {
          $q1->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('phone', 'like', '%' . $keyword . '%');
        });
      })
      ->editColumn('grand_total', function($each) {
        return number_format($each->grand_total) . ' Ks';
      })
      ->addColumn('customer', function($each) {
        $name  = !empty($each->customer->name) ? '<p><i class="ri-user-fill me-3"></i>' . $each->customer->name . '</p>' : '';
        $phone = !empty($each->customer->phone) ? '<p><i class="ri-phone-fill me-3"></i>' . $each->customer->phone . '</p>' : '';

        return '<div class="ms-2">' . $name . $phone . '</div>';
      })
      ->addColumn('action', function ($each) {
        $view_btn    = '<a href="' . route('order.detail', $each->id) . '" class="view_btn mr-2">View</a>';
        $reject_btn  = '<a href="' . route('reject.order', $each->id) . '" class="reject_btn mr-2">Cancel</a>';
        $confirm_btn = '<a href="' . route('confirm.order', $each->id) . '" class="confirm_btn">Confirm</a>';

        return '<div class="action_icon mt-2">' . $view_btn . $reject_btn . $confirm_btn . '</div>';
      })
      ->rawColumns(['created_at', 'action', 'customer'])
      ->toJson();
  }

  /**
   * Cancel Order Blade
   *
   * @return void
   */
  public function cancelOrders() {
    return view('backend.orders.cancel_index');
  }

  /**
   * Cancel Order Server Side
   *
   * @return void
   */
  public function cancelOrderServerSide() {
    $order = Order::with('customer')
      ->where('status', Order::ON_CANCEL)
      ->orderBy('id', 'desc');

    return datatables($order)
      ->editColumn('created_at', function($each) {
        return '<span class="badge rounded-pill bg-success p-2">' . Carbon::parse($each->created_at)->format('d M Y, H:i:s') . '</span>';
      })
      ->filterColumn('customer', function($query, $keyword) {
        $query->whereHas('customer', function($q1) use ($keyword) {
          $q1->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('phone', 'like', '%' . $keyword . '%');
        });
      })
      ->editColumn('grand_total', function($each) {
        return number_format($each->grand_total) . ' Ks';
      })
      ->addColumn('customer', function($each) {
        $name  = '<p><i class="ri-user-fill me-3"></i>' . $each->customer->name . '</p>';
        $phone = '<p><i class="ri-phone-fill me-3"></i>' . $each->customer->phone . '</p>';

        return '<div class="ms-2">' . $name . $phone . '</div>';
      })
      ->addColumn('action', function ($each) {
        $view_btn       = '<a href="' . route('order.detail', $each->id) . '" class="view_btn mr-2">View</a>';
        $processing_btn = '<a href="' . route('processing.order', $each->id) . '" class="reject_btn mr-2">Processing</a>';

        return '<div class="action_icon mt-2">' . $view_btn . $processing_btn . '</div>';
      })
      ->rawColumns(['created_at', 'customer', 'action'])
      ->toJson();
  }

  public function confirmOrders() {
    return view('backend.orders.confirm_index');
  }

  /**
   * Confirm Order Server Side
   *
   * @return void
   */
  public function confirmOrderServerSide() {
    $order = Order::with('customer')
      ->where('status', Order::ON_CONFIRM)
      ->orderBy('id', 'desc');

    return datatables($order)
      ->editColumn('created_at', function($each) {
        return '<span class="badge rounded-pill bg-success p-2">' . Carbon::parse($each->created_at)->format('d M Y, H:i:s') . '</span>';
      })
      ->filterColumn('customer', function($query, $keyword) {
        $query->whereHas('customer', function($q1) use ($keyword) {
          $q1->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('phone', 'like', '%' . $keyword . '%');
        });
      })
      ->editColumn('grand_total', function($each) {
        return number_format($each->grand_total) . ' Ks';
      })
      ->addColumn('customer', function($each) {
        $name  = '<p><i class="ri-user-fill me-3"></i>' . $each->customer->name . '</p>';
        $phone = '<p><i class="ri-phone-fill me-3"></i>' . $each->customer->phone . '</p>';

        return '<div class="ms-2">' . $name . $phone . '</div>';
      })
      ->addColumn('action', function ($each) {
        $view_btn     = '<a href="' . route('order.detail', $each->id) . '" class="view_btn mr-2">View</a>';
        $finished_btn = '<a href="' . route('finished.order', $each->id) . '" class="finished_btn">Finished</a>';
        return '<div class="action_icon mt-2">' . $view_btn . $finished_btn . '</div>';
      })
      ->rawColumns(['created_at', 'customer', 'action'])
      ->toJson();
  }

  public function finishedOrders() {
    return view('backend.orders.finished_index');
  }

  /**
   * Finished Order Server Side
   *
   * @return void
   */
  public function finishedOrderServerSide() {
    $order = Order::with('customer')
      ->where('status', Order::ON_FINISHED)
      ->orderBy('id', 'desc');

    return datatables($order)
      ->editColumn('created_at', function($each) {
        return '<span class="badge rounded-pill bg-success p-2">' . Carbon::parse($each->created_at)->format('d M Y, H:i:s') . '</span>';
      })
      ->filterColumn('customer', function($query, $keyword) {
        $query->whereHas('customer', function($q1) use ($keyword) {
          $q1->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('phone', 'like', '%' . $keyword . '%');
        });
      })
      ->editColumn('grand_total', function($each) {
        return number_format($each->grand_total) . ' Ks';
      })
      ->addColumn('customer', function($each) {
        $name  = '<p><i class="ri-user-fill me-3"></i>' . $each->customer->name . '</p>';
        $phone = '<p><i class="ri-phone-fill me-3"></i>' . $each->customer->phone . '</p>';

        return '<div class="ms-2">' . $name . $phone . '</div>';
      })
      ->addColumn('action', function ($each) {
        $view_btn = '<a href="' . route('order.detail', $each->id) . '" class="view_btn mr-2">View</a>';
        return '<div class="action_icon mt-2">' . $view_btn . '</div>';
      })
      ->rawColumns(['created_at', 'customer', 'action'])
      ->toJson();
  }

  /**
   * Reject Order
   *
   * @param [type] $id
   * @return void
   */
  public function rejectOrder($id) {
    $order         = Order::findOrFail($id);
    $order->status = Order::ON_CANCEL;
    $order->update();

    return redirect()->back()->with('cancel', 'Cancel Order');
  }

  /**
   * Confirm Order
   *
   * @param [type] $id
   * @return void
   */
  public function confirmOrder($id) {
    $order         = Order::findOrFail($id);
    $order->status = Order::ON_CONFIRM;
    $order->update();

    return redirect()->back();
  }

  /**
   * Finished Order
   *
   * @param [type] $id
   * @return void
   */
  public function finishedOrder($id) {
    $order         = Order::findOrFail($id);
    $order->status = Order::ON_FINISHED;
    $order->update();

    return redirect()->back();
  }

  /**
   * Finished Order
   *
   * @param [type] $id
   * @return void
   */
  public function processingOrder($id) {
    $order         = Order::findOrFail($id);
    $order->status = Order::ON_PROCESSING;
    $order->update();

    return redirect()->back();
  }
}
