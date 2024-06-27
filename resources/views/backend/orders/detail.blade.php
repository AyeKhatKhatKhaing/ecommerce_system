@extends('main')

@section('content')
    <div class="row">
        <div class="col-xl-9 offset-xl-1">
            <div class="card">
                <div class="card-header p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{url()->previous()}}" class="card-title mb-0 d-inline-flex align-items-center create_title">
                                <i class=" ri-arrow-left-s-line mr-3 primary-icon"></i> 
                                <span class="create_sub_title">အော်ဒါများ</span>
                            </a>
                        </div>
                        @if($order->status == 'processing')
                            <div>
                                <a href="{{route('confirm.order', $order->id)}}" class="confirm_btn">Confirm</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h5>
                                {{$order->order_number}} 
                                @if($order->status == 'cancel') 
                                    <span class="badge rounded-pill bg-danger p-2 ms-3">{{$order->status}}</span>
                                @else
                                    <span class="badge rounded-pill bg-success p-2 ms-3">{{$order->status}}</span>
                                @endif
                            </h5>
                            <div class="d-flex gap-5 mt-4 mb-0">
                                <p class="text-muted">Invoice Date/Time</p>
                                <p class="text-muted">{{ Carbon\Carbon::parse($order->created_at)->format('d M Y - h:i s')}}</p>
                            </div>
        
                            <div class="d-flex gap-5 my-0">
                                <p class="text-muted">Payment Type</p>
                                <p class="text-muted">{{ $order->payment_type }}</p>
                            </div>
        
                            <div class="d-flex gap-5 my-0">
                                <p class="text-muted">Delivery Address</p>
                                <p class="text-muted">{{ $order->customer->delivery_address ?? '-' }}</p>
                            </div>
                        </div>
                        @if($order->payment_screenshot) 
                            <div class="col-4">
                                <a href="{{$order->payment_screenshot}}" target="_blank">
                                    <img src="{{$order->payment_screenshot}}" class="rounded" alt="payment_screenshot" width="150px" height="150px">
                                </a>
                            </div>
                        @endif
                    </div>
                    
        
                    <hr class="text-muted">
        
                    <h6 class="fw-bold">Products</h6>
                    @foreach($order->orderProduct as $oproduct)
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                {{$oproduct->quantity}} x <span class="text-dark fw-bold">{{$oproduct->product->name ?? '-'}}</span> ( {{$oproduct->size}} )
                                <img class="rounded ms-2" src="{{$oproduct->product->images[0]->path ?? asset('images/default.jpg')}}" alt="" width="45px" height="45px">
                            </div>
                            <div>
                                {{$oproduct->quantity}} X <span class="fw-bold">{{$oproduct->product->price}} Ks</span>
                            </div>
                            <div class="mt-3">
                                <p class="fw-bold">Ks {{number_format($oproduct->total_price)}}</p>
                            </div>
                        </div>
                    @endforeach

                    <hr class="text-muted">

                    <h6 class="fw-bold">Customer</h6>
                    <div class="mb-5">
                        <div class="row mt-4">
                            <div class="col-3">
                                Name
                            </div>
                            <div class="col-1">
                                -
                            </div>
                            <div class="col-8">
                                {{$order->customer->name}}
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-3">
                                Phone
                            </div>
                            <div class="col-1">
                                -
                            </div>
                            <div class="col-8">
                                {{$order->customer->phone}}
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted">

                    <h6 class="fw-bold">Delivery Address</h6>
                    <div class="mb-5">
                        <div class="row mt-4">
                            <div class="col-3">
                                Region / Township
                            </div>
                            <div class="col-1">
                                -
                            </div>
                            <div class="col-8">
                                {{$region->name ?? '-'}} / {{$order->deliveryFee->township ?? '-'}}
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-3">
                                Price
                            </div>
                            <div class="col-1">
                                -
                            </div>
                            <div class="col-8">
                                {{!empty($order->deliveryFee->price) ? 'Ks ' . number_format($order->deliveryFee->price) : '-'}}
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-3">
                                Add On Charge
                            </div>
                            <div class="col-1">
                                -
                            </div>
                            <div class="col-8">
                                {{!empty($order->deliveryFee->add_on_charge) ? 'Ks ' . number_format($order->deliveryFee->add_on_charge): 0}}
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted">

                    <div class="d-flex justify-content-between">
                        <div class="text-muted">Subtotal</div>
                        <div>
                            <p>Ks {{number_format($order->total)}}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="text-muted">Delivery Fee</div>
                        <div>
                            <p>Ks {{number_format($order->delivery_fee)}}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">Grand Total</div>
                        <div>
                            <p class="fw-bold">Ks {{number_format($order->grand_total)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection