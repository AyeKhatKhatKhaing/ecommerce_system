<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;
use App\Models\DeliveryRegion;

class DeliveryRegionController extends Controller {
  /**
   * product listing view
   *
   * @return void
   */
  public function index() {
    return view('backend.delivery_region.index');
  }

  /**
   * Create Form
   *
   * @return void
   */
  public function create() {
    return view('backend.delivery_region.create');
  }

  /**
   * Store Category
   *
   * @param  StoreCategoryRequest $request
   * @return void
   */
  public function store(StoreRegionRequest $request) {
    $region         = new DeliveryRegion();
    $region->name   = $request->name;
    $region->is_cod = empty($request->is_cod) ? 0 : 1;
    $region->save();

    return redirect()->route('region')->with('created', 'Region created Successfully');
  }

  /**
   * Product Categeory Edit
   *
   * @param [type] $id
   * @return void
   */
  public function edit($id) {
    $region = DeliveryRegion::findOrFail($id);
    return view('backend.delivery_region.edit', compact('region'));
  }

  /**
   * Product Category Update
   *
   * @param Reqeuest $reqeuest
   * @param [type] $id
   * @return void
   */
  public function update(StoreRegionRequest $request, $id) {
    $region         = DeliveryRegion::findOrFail($id);
    $region->name   = $request->name;
    $region->is_cod = empty($request->is_cod) ? 0 : 1;
    $region->update();

    return redirect()->route('region')->with('updated', 'Region Updated Successfully');
  }

  /**
   * delete Category
   *
   * @return void
   */
  public function destroy($id) {
    $region = DeliveryRegion::findOrFail($id);
    $region->delete();

    return 'success';
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $regions = DeliveryRegion::orderBy('created_at', 'desc');
    return datatables($regions)
      ->addColumn('action', function ($each) {
        $edit_icon   = '<a href="' . route('region.edit', $each->id) . '" class="edit_btn mr-3"><i class="ri-edit-box-fill"></i></a>';
        $delete_icon = '<a href="#" class="delete_btn" data-id="' . $each->id . '"><i class="ri-delete-bin-fill"></i></a>';

        return '<div class="action_icon">' . $edit_icon . $delete_icon . '</div>';
      })
      ->rawColumns(['action'])
      ->toJson();
  }
}
