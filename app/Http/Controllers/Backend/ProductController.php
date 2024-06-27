<?php
namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller {
  public $productImageArray = [];

  /**
   * product listing view
   *
   * @return void
   */
  public function listing() {
    return view('backend.products.index');
  }

  /**
   * Product create
   *
   * @return void
   */
  public function create() {
    $categories = Category::orderBy('id', 'desc')->get();
    $brands     = Brand::orderBy('id', 'desc')->get();
    $sizes      = ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL', '6XL', '7XL', '8XL', 'Free', 'Over'];

    return view('backend.products.create', compact('categories', 'brands', 'sizes'));
  }

  /**
   * Product Store
   *
   * @param  Request $request
   * @return void
   */
  public function store(StoreProductRequest $request) {
    DB::beginTransaction();
    try {
      $product              = new Product();
      $product->name        = $request->name;
      $product->price       = $request->price;
      $product->category_id = $request->category_id ?? null;
      $product->brand_id    = $request->brand_id ?? null;
      $product->description = $request->description;
      $product->color       = $request->color ?? null;
      $product->fix_count   = $request->fix_count > 0 ? $request->fix_count : 1;
      $product->size        = $request->size ?? [];
      $product->is_sold_out = empty($request->is_sold_out) ? 0 : 1;
      $product->save();

      if ($request->hasFile('images')) {
        $this->_createProductImages($product->id, $request->file('images'));
      }

      DB::commit();
      return redirect()->route('product')->with('created', 'Product Created Successfully');
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Create Review Images
   */
  private function _createProductImages($productId, $files) {
    foreach ($files as $image) {
      $this->productImageArray[] = [
        'product_id' => $productId,
        'path'       => $image->store('products'),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    ProductImage::insert($this->productImageArray);
  }

  /**
   * Product edit
   *
   * @param StoreProductRequest $request
   * @param [type] $id
   * @return void
   */
  public function edit($id) {
    $product    = Product::findOrFail($id);
    $categories = Category::orderBy('id', 'desc')->get();
    $brands     = Brand::orderBy('id', 'desc')->get();
    $sizes      = ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL', '6XL', '7XL', '8XL', 'Free', 'Over'];

    return view('backend.products.edit', compact('product', 'categories', 'brands', 'sizes'));
  }

  /**
   * Update Product
   *
   * @param [type] $id
   * @param  StoreProductRequest $request
   * @return void
   */
  public function update($id, UpdateProductRequest $request) {
    if (empty($request->old) && empty($request->images)) {
      return redirect()->back()->with('fail', 'Product Image is required');
    }

    DB::beginTransaction();
    try {
      $product              = Product::findOrFail($id);
      $product->name        = $request->name;
      $product->price       = $request->price;
      $product->category_id = $request->category_id ?? null;
      $product->brand_id    = $request->brand_id ?? null;
      $product->description = $request->description;
      $product->color       = $request->color ?? $product->color;
      $product->fix_count   = $request->fix_count > 0 ? $request->fix_count : $product->fix_count;
      $product->size        = $request->size ?? $product->size;
      $product->is_sold_out = empty($request->is_sold_out) ? 0 : 1;
      $product->update();

      // old image file delete
      if ($request->has('old')) {
        $files = $product->images()->whereNotIn('id', $request->old)->get();
        if (count($files) > 0) {
          foreach ($files as $file) {
            $oldPath = $file->getRawOriginal('path') ?? '';
            Storage::delete($oldPath);
          }

          $product->images()->whereNotIn('id', $request->old)->delete();
        }
      }

      if ($request->hasFile('images')) {
        $this->_createProductImages($product->id, $request->file('images'));
      }

      DB::commit();
      return redirect()->route('product')->with('updated', 'Product Updated Successfully');
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Product destroy
   *
   * @param [type] $id
   * @return void
   */
  public function destroy($id) {
    DB::beginTransaction();
    try {
      $product = Product::findOrFail($id);
      $product->delete();

      foreach ($product->images as $img) {
        $oldPath = $img->getRawOriginal('path') ?? '';
        Storage::delete($oldPath);
      }

      $product->images()->delete();
      DB::commit();
      return 'success';
    } catch(Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * ServerSide
   *
   * @return void
   */
  public function serverSide() {
    $product = Product::orderBy('created_at', 'desc');
    return datatables($product)
      ->addColumn('image', function ($each) {
        $image = $each->images()->first();
        if ($image) {
          return '<img src="' . $image->path . '" class="thumbnail_img"/>';
        } else {
          return '<img src="' . config('app.url') . '/images/default.jpg' . '" class="thumbnail_img"/>';
        }
      })
      ->addColumn('category', function ($each) {
        return $each->category->name ?? '-';
      })
      ->addColumn('brand', function ($each) {
        return $each->brand->name ?? '-';
      })
      ->editColumn('price', function($each) {
        return number_format($each->price) . ' Ks';
      })
      ->addColumn('action', function ($each) {
        $edit_icon   = '<a href="' . route('product.edit', $each->id) . '" class="edit_btn mr-3"><i class="ri-edit-box-fill"></i></a>';
        $delete_icon = '<a href="#" class="delete_btn" data-id="' . $each->id . '"><i class="ri-delete-bin-fill"></i></a>';

        return '<div class="action_icon">' . $edit_icon . $delete_icon . '</div>';
      })
      ->rawColumns(['category', 'brand', 'action', 'image'])
      ->toJson();
  }

  /**
   * Product images
   *
   * @return void
   */
  public function images($id) {
    $product   = Product::findOrFail($id);
    $oldImages = [];
    foreach ($product->images as $img) {
      $oldImages[] = [
        'id'  => $img->id,
        'src' => $img->path,
      ];
    }

    return response()->json($oldImages);
  }
}
