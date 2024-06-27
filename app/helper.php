<?php

use Illuminate\Support\Facades\Validator;

if (!function_exists('canLoadMore')) {
  function canLoadMore($query) {
    $request    = request();
    $totalPages = ceil($query->total() / $request->limit);
    return $query->total() == 0 || $request->page == $totalPages ? false : true;
  }
}

if (!function_exists('validatorFail')) {
  function validatorFail($request, $rules) {
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $errors = $validator->errors()->messages();
      $ret    = [];
      foreach ($errors as $key => $value) {
        if (isset($value[0])) {
          $ret[$key] = $value[0];
        }
      }
      return $ret;
    }
  }
}
