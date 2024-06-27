@extends('main')

@section('content')
<div class="row">
    <div class="col-xl-10 offset-xl-1">
        <div class="card">
            <div class="card-header">
                <a href="{{route('fee')}}" class="card-title mb-0 d-inline-flex align-items-center create_title">
                    <i class=" ri-arrow-left-s-line mr-3 primary-icon"></i> 
                    <span class="create_sub_title">ပို့ဆောင်ခကိုပြုပြင်မည်</span>
                </a>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-9">
                        <form method="POST" action="{{route('fee.update', $fee->id)}}" id="fee_update">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="employeeName" class="form-label mb-3">မြို့နယ်</label>
                                <input type="text" class="form-control" name="township" value="{{$fee->township}}">
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="category">တိုင်းဒေသကြီး / ပြည်နယ် ( Region )</label>
                                <select name="delivery_region_id" class="form-select mb-3" aria-label="Default select example" id='category'>
                                    <option selected disabled>တိုင်းဒေသကြီး / ပြည်နယ် ( Region ) ရွေးပါ</option>
                                    @foreach ($regions as $region)
                                        <option value="{{$region->id}}" {{$region->id == $fee->delivery_region_id ? 'selected' : ''}}>
                                            {{$region->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="employeeName" class="form-label mb-3">စျေးနူန်း</label>
                                        <input type="number" class="form-control" name="price" value="{{$fee->price}}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="employeeName" class="form-label mb-3">တန်ဆာခ</label>
                                        <input type="number" class="form-control" name="add_on_charge" value="{{$fee->add_on_charge}}">
                                    </div>
                                </div>
                            </div>
                            <div class="text-end submit-m-btn">
                                <button type="submit" class="submit-btn">ပြင်ဆင်မှုများကိုသိမ်းမည်</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreFeeRequest', '#fee_update') !!}
@endsection