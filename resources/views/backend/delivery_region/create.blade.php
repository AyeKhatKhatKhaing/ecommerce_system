@extends('main')

@section('content')
<div class="row">
    <div class="col-xl-10 offset-xl-1">
        <div class="card">
            <div class="card-header">
                <a href="{{route('region')}}" class="card-title mb-0 d-inline-flex align-items-center create_title">
                    <i class=" ri-arrow-left-s-line mr-3 primary-icon"></i> 
                    <span class="create_sub_title">တိုင်းဒေသကြီး / ပြည်နယ်အသစ်ဖန်တီးမည်</span>
                </a>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-9">
                        <form method="POST" action="{{route('region.store')}}" id="fee_create">
                            @csrf
                            <div class="mb-5">
                                <label class="form-check-label mb-1" for="customSwitchsizemd">အိမ်အရောက်၀န်ဆောင်မှူပေးမည်</label>
                                <div class="form-check form-switch form-switch-md mt-2 dir="ltr" style="margin-left: 30px">
                                    <input type="checkbox" class="form-check-input" id="customSwitchsizemd" name="is_cod">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="employeeName" class="form-label mb-3">အမည်</label>
                                <input type="text" class="form-control" name="name">
                            </div>

                            <div class="text-end submit-m-btn">
                                <button type="submit" class="submit-btn">အသစ်ပြုလုပ်မည့် တိုင်းဒေသကြီး / ပြည်နယ်</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreRegionRequest', '#fee_create') !!}
@endsection