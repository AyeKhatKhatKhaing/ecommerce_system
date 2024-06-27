<?php
namespace App\Http\Controllers\Backend;

use App\Models\LivePhoto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreLivePhotoRequest;

class LivePhotoController extends Controller {
  /**
   * Bank Account listing view
   *
   * @return void
   */
  public function index() {
    return view('backend.live_photos.index');
  }

  /**
   * Create Form
   *
   * @return void
   */
  public function create() {
    return view('backend.live_photos.create');
  }

  /**
   * Store Category
   *
   * @param  StoreCategoryRequest $request
   * @return void
   */
  public function store(StoreLivePhotoRequest $request) {
    $livePhoto = new LivePhoto();
    if ($request->hasFile('image')) {
      $livePhoto->image = $request->file('image')->store('live_photos');
    }
    $livePhoto->save();

    return redirect()->route('live')->with('created', 'Live photo created Successfully');
  }

  /**
   * Product Categeory Edit
   *
   * @param [type] $id
   * @return void
   */
  public function edit($id) {
    $photo = LivePhoto::findOrFail($id);
    return view('backend.live_photos.edit', compact('photo'));
  }

  /**
   * Product Category Update
   *
   * @param Reqeuest $reqeuest
   * @param [type] $id
   * @return void
   */
  public function update(StoreLivePhotoRequest $request, $id) {
    $photo = LivePhoto::findOrFail($id);
    if ($request->hasFile('image')) {
      $oldImage = $photo->getRawOriginal('image') ?? '';
      Storage::delete($oldImage);
      $photo->image = $request->file('image')->store('live_photos');
    }
    $photo->update();

    return redirect()->route('live')->with('updated', 'Account Updated Successfully');
  }

  /**
   * delete Category
   *
   * @return void
   */
  public function destroy($id) {
    $photo    = LivePhoto::findOrFail($id);
    $oldImage = $photo->getRawOriginal('image') ?? '';
    Storage::delete($oldImage);
    $photo->delete();

    return 'success';
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $photo = LivePhoto::orderBy('id', 'desc');
    return datatables($photo)
      ->addColumn('image', function ($each) {
        return '<img src="' . $each->image . '" class="thumbnail_img"/>';
      })
      ->addColumn('action', function ($each) {
        $edit_icon   = '<a href="' . route('live.edit', $each->id) . '" class="edit_btn mr-3"><i class="ri-edit-box-fill"></i></a>';
        $delete_icon = '<a href="#" class="delete_btn" data-id="' . $each->id . '"><i class="ri-delete-bin-fill"></i></a>';

        return '<div class="action_icon">' . $edit_icon . $delete_icon . '</div>';
      })
      ->rawColumns(['image', 'action'])
      ->toJson();
  }
}
