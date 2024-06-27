<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules() {
    return [
      'name'        => 'required',
      'price'       => 'required|numeric',
      'description' => 'required',
      'images'      => 'required|array|min:1|max:10',
      'images.*'    => 'required|image',
      'color'       => 'nullable|numeric',
      'fix_count'   => 'required',
    ];
  }
}
