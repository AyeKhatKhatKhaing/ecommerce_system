<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeRequest;
use App\Models\DeliveryFee;
use App\Models\DeliveryRegion;

class DeliveryFeeController extends Controller {
  /**
   * product listing view
   *
   * @return void
   */
  public function index() {
    return view('backend.delivery_fees.index');
  }

  /**
   * Create Form
   *
   * @return void
   */
  public function create() {
    $regions = DeliveryRegion::cursor();
    return view('backend.delivery_fees.create', compact('regions'));
  }

  /**
   * Store Category
   *
   * @param  StoreCategoryRequest $request
   * @return void
   */
  public function store(StoreFeeRequest $request) {
    $fee                     = new DeliveryFee();
    $fee->delivery_region_id = $request->delivery_region_id;
    $fee->township           = $request->township;
    $fee->price              = $request->price;
    $fee->add_on_charge      = $request->add_on_charge ?? 0;
    $fee->save();

    return redirect()->route('fee')->with('created', 'Fee created Successfully');
  }

  /**
   * Product Categeory Edit
   *
   * @param [type] $id
   * @return void
   */
  public function edit($id) {
    $fee     = DeliveryFee::findOrFail($id);
    $regions = DeliveryRegion::cursor();
    return view('backend.delivery_fees.edit', compact('fee', 'regions'));
  }

  /**
   * Product Category Update
   *
   * @param Reqeuest $reqeuest
   * @param [type] $id
   * @return void
   */
  public function update(StoreFeeRequest $request, $id) {
    $fee                     = DeliveryFee::findOrFail($id);
    $fee->delivery_region_id = $request->delivery_region_id;
    $fee->township           = $request->township;
    $fee->price              = $request->price;
    $fee->add_on_charge      = $request->add_on_charge ?? $fee->add_on_charge;
    $fee->update();

    return redirect()->route('fee')->with('updated', 'Fee Updated Successfully');
  }

  /**
   * delete Category
   *
   * @return void
   */
  public function destroy($id) {
    $fee = DeliveryFee::findOrFail($id);
    $fee->delete();

    return 'success';
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $fees = DeliveryFee::with('region')->orderBy('created_at', 'desc');
    return datatables($fees)
      ->filterColumn('region_name', function($query, $keyword) {
        $query->whereHas('region', function($c) use ($keyword) {
          $c->where('name', 'like', '%' . $keyword . '%');
        });
      })
      ->addColumn('add_on_charge', function ($each) {
        return (!empty($each->add_on_charge) && $each->add_on_charge > 0) ? $each->add_on_charge : 0;
      })
      ->editColumn('price', function($each) {
        return number_format($each->price) . ' Ks';
      })
      ->editColumn('add_on_charge', function($each) {
        return number_format($each->add_on_charge) . ' Ks';
      })
      ->addColumn('region_name', function($each) {
        return $each->region->name ?? '-';
      })
      ->addColumn('action', function ($each) {
        $edit_icon   = '<a href="' . route('fee.edit', $each->id) . '" class="edit_btn mr-3"><i class="ri-edit-box-fill"></i></a>';
        $delete_icon = '<a href="#" class="delete_btn" data-id="' . $each->id . '"><i class="ri-delete-bin-fill"></i></a>';

        return '<div class="action_icon">' . $edit_icon . $delete_icon . '</div>';
      })
      ->rawColumns(['action', 'add_on_charger', 'region_name'])
      ->toJson();
  }
}
