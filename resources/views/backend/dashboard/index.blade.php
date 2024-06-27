@extends('main')

@section('content')
   <h4 class="mb-5">Dashboard</h4>
   <div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                  <p
                    class="text-uppercase fw-medium text-muted text-truncate mb-0"
                  >
                    Total Order
                  </p>
                </div>
              </div>
              <div
                class="d-flex align-items-end justify-content-between mt-4"
              >
                <div>
                  <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                    {{$totalOrder}}
                  </h4>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span
                      class="avatar-title bg-soft-success rounded fs-3"
                    >
                      <i class="ri-focus-fill text-success"></i>
                    </span>
                  </div>
            </div>
            <!-- end card body -->
          </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                  <p
                    class="text-uppercase fw-medium text-muted text-truncate mb-0"
                  >
                    Today Order
                  </p>
                </div>
              </div>
              <div
                class="d-flex align-items-end justify-content-between mt-4"
              >
                <div>
                  <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                    {{$todayOrder}}
                  </h4>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span
                      class="avatar-title bg-soft-success rounded fs-3"
                    >
                      <i class="ri-focus-fill text-success"></i>
                    </span>
                  </div>
            </div>
            <!-- end card body -->
          </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                  <p
                    class="text-uppercase fw-medium text-muted text-truncate mb-0"
                  >
                    Total Product
                  </p>
                </div>
              </div>
              <div
                class="d-flex align-items-end justify-content-between mt-4"
              >
                <div>
                  <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                    {{$totalProduct}}
                  </h4>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-soft-info rounded fs-3">
                      <i class="ri-shirt-line text-info"></i>
                    </span>
                  </div>
            </div>
            <!-- end card body -->
          </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                  <p
                    class="text-uppercase fw-medium text-muted text-truncate mb-0"
                  >
                    Total Brand
                  </p>
                </div>
              </div>
              <div
                class="d-flex align-items-end justify-content-between mt-4"
              >
                <div>
                  <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                    {{$totalBrand}}
                  </h4>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-soft-info rounded fs-3">
                      <i class="ri-gift-fill text-info"></i>
                    </span>
                  </div>
            </div>
            <!-- end card body -->
          </div>
        </div>
    </div>
   </div>

   <div class="row mt-5">
    <div class="col-6">
        <div class="card p-3">
            <p class="fw-bold">Top Products</p>

            @if(count($mostSellProducts))
              <div class="row mt-3 mb-4">
                  <div class="col-8">
                      Product Name
                  </div>
                  <div class="col-4 text-center">
                      Total Order
                  </div>
              </div>

              @foreach ($mostSellProducts as $product)
                  <div class="card ps-4 pe-2 py-3 mb-3">
                      <div class="row">
                          <div class="col-8">
                              <img class="rounded" src="{{empty($product->path) ? 
                                config('app.url') . '/images/default.jpg'
                              : config('app.url') . '/image/' . $product->path}}" alt="product_image" width="45px" height="45px">
                              <p class="d-inline ms-2">
                                  {{$product->name}}
                              </p>
                          </div>
                          <div class="col-4 d-flex justify-content-center align-items-center">
                              {{$product->total_quantity}}
                          </div>
                      </div>
                  </div>
              @endforeach
            @else
                <div class="text-center text-muted">No Products yet</div>
            @endif
        </div>
    </div>

    <div class="col-6">
        <div class="card p-3">
            <p class="fw-bold">Top Customers</p>

            @if(count($mostBuyCustomer))
              <div class="row mt-3 mb-4">
                  <div class="col-8">
                      Customer Name
                  </div>
                  <div class="col-4 text-center">
                      Buy Amount
                  </div>
              </div>

              @foreach ($mostBuyCustomer as $customer)
              <a href="{{route('customer.view', $customer->id)}}">
                <div class="card ps-4 pe-2 py-3 mb-3">
                    <div class="row">
                        <div class="col-8">
                            <img class="rounded" src="{{$customer->profile_image}}" alt="product_image" width="45px" height="45px">
                            <p class="d-inline ms-2 text-dark">
                                {{$customer->name}}
                            </p>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center text-dark">
                            {{number_format($customer->amount)}} Ks
                        </div>
                    </div>
                </div>
              </a>
              @endforeach
            @else 
              <div class="text-center text-muted">No Customers yet</div>
            @endif
        </div>
    </div>
   </div>
@endsection