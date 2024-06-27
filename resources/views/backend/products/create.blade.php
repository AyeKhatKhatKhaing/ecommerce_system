@extends('main')

@section('content')
<div class="row">
    <div class="col-xl-10 offset-xl-1">
        <div class="card">
            <div class="card-header">
                <a href="{{route('product')}}" class="card-title mb-0 d-inline-flex align-items-center create_title">
                    <i class=" ri-arrow-left-s-line mr-3 primary-icon"></i> 
                    <span class="create_sub_title">ကုန်ပစ္စည်းအသစ်ပြုလုပ်မည်</span>
                </a>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-9">
                        <form method="POST" action="{{route('product.store')}}" id="product_create" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-5">
                                <label class="form-check-label ms-2 mb-1" for="customSwitchsizemd">ပစ္စည်းကုန်နေပါသည်</label>
                                <div class="form-check form-switch form-switch-md mt-2 ms-5" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="customSwitchsizemd" name="is_sold_out">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label mb-3">အမည်</label>
                                        <input type="text" class="form-control" name="name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label mb-3">စျေးနှုန်း</label>
                                        <input type="number" class="form-control" name="price" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="category">အမျိူးအစား / Category</label>
                                        <select name="category_id" class="form-select mb-3" aria-label="Default select example" id='category'>
                                            <option selected disabled>အမျိူးအစား ရွေးပါ</option>
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">
                                                    {{$category->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="brand">အမှတ်တံဆိပ်</label>
                                        <select name="brand_id" class="form-select mb-3" aria-label="Default select example" id='brand'>
                                            <option selected disabled>အမှတ်တံဆိပ် ရွေးပါ</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{$brand->id}}">
                                                    {{$brand->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5 mt-3">
                                <label for="description" class="form-label">အကြောင်းအရာ / Description</label>
                                <textarea class="form-control" name="description" id="description" rows="8"></textarea>
                            </div>

                            <div class="mb-5 mt-3">
                                <label class="form-label">အရွယ်အစား / size</label>
                                <div class="ms-2 mt-3 d-flex gap-3">
                                    @foreach($sizes as $key => $size)
                                        <div>
                                            <input type="checkbox" id="size{{$key}}" name='size[]' value="{{$size}}">
                                            <label for="size{{$key}}">{{$size}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label mb-3">Color အရေအတွက်</label>
                                        <input type="number" class="form-control" name="color" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6 d-flex justify-content-center">
                                    <div class="mb-3">
                                        <label class="form-label mb-3">သတ်မှတ်ထားမဲ့ ပမာဏ / Fix Count</label>
                                        <input type="number" class="form-control" name="fix_count" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="images">Images</label>
                                <div class="input-images" id="images"></div>
                            </div>

                            <div class="text-end submit-m-btn">
                                <button type="submit" class="submit-btn">အသစ်ပြုလုပ်မည်</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreProductRequest', '#product_create') !!}
    <script src="{{ asset('assets/js/image-uploader.min.js') }}"></script>
    <script>
        $(".input-images").imageUploader({
            maxSize: 2 * 1024 * 1024,
            maxFiles: 10,
        });
    </script>
@endsection