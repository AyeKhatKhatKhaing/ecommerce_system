<?php
namespace App\Http\Controllers\Backend;

use App\Models\BankAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAccountRequest;

class BankAccountController extends Controller {
  /**
   * Bank Account listing view
   *
   * @return void
   */
  public function index() {
    return view('backend.accounts.index');
  }

  /**
   * Create Form
   *
   * @return void
   */
  public function create() {
    return view('backend.accounts.create');
  }

  /**
   * Store Category
   *
   * @param  StoreCategoryRequest $request
   * @return void
   */
  public function store(StoreAccountRequest $request) {
    $account         = new BankAccount();
    $account->name   = $request->name;
    $account->number = $request->number ?? null;
    if ($request->hasFile('image')) {
      $account->image = $request->file('image')->store('accounts');
    }
    $account->status = 1;
    $account->save();

    return redirect()->route('account')->with('created', 'Account created Successfully');
  }

  /**
   * Product Categeory Edit
   *
   * @param [type] $id
   * @return void
   */
  public function edit($id) {
    $account = BankAccount::findOrFail($id);
    return view('backend.accounts.edit', compact('account'));
  }

  /**
   * Product Category Update
   *
   * @param Reqeuest $reqeuest
   * @param [type] $id
   * @return void
   */
  public function update(StoreAccountRequest $request, $id) {
    $account         = BankAccount::findOrFail($id);
    $account->name   = $request->name;
    $account->number = $request->number ?? $account->number;
    if ($request->hasFile('image')) {
      $oldImage = $account->getRawOriginal('image') ?? '';
      Storage::delete($oldImage);
      $account->image = $request->file('image')->store('accounts');
    }
    $account->update();

    return redirect()->route('account')->with('updated', 'Account Updated Successfully');
  }

  /**
   * delete Category
   *
   * @return void
   */
  public function destroy($id) {
    $account  = BankAccount::findOrFail($id);
    $oldImage = $account->getRawOriginal('image') ?? '';
    Storage::delete($oldImage);

    $account->status = 0;
    $account->update();

    return 'success';
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $account = BankAccount::where('status', 1)->orderBy('id', 'desc');
    return datatables($account)
      ->addColumn('image', function ($each) {
        return '<img src="' . $each->image . '" class="thumbnail_img"/>';
      })
      ->addColumn('action', function ($each) {
        $edit_icon   = '<a href="' . route('account.edit', $each->id) . '" class="edit_btn mr-3"><i class="ri-edit-box-fill"></i></a>';
        $delete_icon = '<a href="#" class="delete_btn" data-id="' . $each->id . '"><i class="ri-delete-bin-fill"></i></a>';

        return '<div class="action_icon">' . $edit_icon . $delete_icon . '</div>';
      })
      ->rawColumns(['image', 'action'])
      ->toJson();
  }
}
