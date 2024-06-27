@extends('main')

@section('content')
<div class="row">
    <div class="col-xl-10 offset-xl-1">
        <div class="card">
            <div class="card-header">
                <a href="{{route('dashboard')}}" class="card-title mb-0 d-inline-flex align-items-center create_title">
                    <i class=" ri-arrow-left-s-line mr-3 primary-icon"></i> 
                    <span class="create_sub_title">ဆက်တင်ပြင်မယ် / Edit Setting</span>
                </a>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-9">
                        <form method="POST" action="{{route('profile.update', $admin->id)}}" id="profile_update">
                            @csrf
                            <div class="mb-3">
                                <label for="employeeName" class="form-label mb-3">အမည်</label>
                                <input type="text" class="form-control" name="name" value="{{$admin->name}}">
                            </div>

                            <div class="mb-3">
                                <label for="employeeName" class="form-label mb-3">အီးမေးလ် / Email</label>
                                <input type="text" class="form-control" name="email" value="{{$admin->email}}">
                            </div>

                            <div class="mb-3">
                                <label for="employeeName" class="form-label mb-3">New Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="employeeName" class="form-label mb-3">Retype-Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProfileRequest', '#profile_update') !!}
@endsection