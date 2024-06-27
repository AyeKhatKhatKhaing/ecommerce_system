<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box mb-4 mt-3">
        <!-- Dark Logo-->
        <a href="{{route('dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('images/logo.jpg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('images/logo.jpg') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{route('dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('images/logo.jpg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('images/logo.jpg') }}" alt="" height="70" class="rounded-circle">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">
                        <i class="ri-dashboard-line"></i> <span data-key="t-landing">ပင်မ</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('products') ? 'active' : '' }}" href="{{route('product')}}">
                        <i class="ri-t-shirt-line"></i> <span data-key="t-landing">ကုန်ပစ္စည်း</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('categories') ? 'active' : '' }}" href="{{route('category')}}">
                        <i class="ri-shirt-line"></i> <span data-key="t-landing">ပစ္စည်းအမျိုးအစား</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('brands') ? 'active' : '' }}" href="{{route('brand')}}">
                        <i class="ri-gift-fill"></i> <span data-key="t-landing">အမှတ်တံဆိပ် / Brand</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('delivery_regions') ? 'active' : '' }}" href="{{route('region')}}">
                        <i class="ri-takeaway-fill"></i> <span data-key="t-landing">တိုင်းဒေသကြီး / ပြည်နယ်</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('delivery_fees') ? 'active' : '' }}" href="{{route('fee')}}">
                        <i class="ri-takeaway-fill"></i> <span data-key="t-landing">မြို့နယ်အလိုက်ပို့ဆောင်ခ</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('accounts') ? 'active' : '' }}" href="{{route('account')}}">
                        <i class="ri-bank-line"></i> <span data-key="t-landing">ဘဏ်အကောင့် / Bank Account</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link menu-link {{ request()->is('customers') ? 'active' : '' }}" href="{{route('customer')}}">
                        <i class="ri-team-fill"></i> <span data-key="t-landing">ဝယ်ယူသူများ / Customers</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a
                      class="nav-link menu-link"
                      href="#sidebarAuth"
                      data-bs-toggle="collapse"
                      role="button"
                      aria-expanded="false"
                      aria-controls="sidebarAuth"
                    >
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="ri-focus-fill"></i>
                        <span data-key="t-authentication">အော်ဒါများ / Orders</span>
                        <i class="ri-arrow-right-s-line ms-2" style="margin-top: 1px"></i>
                    </div>
                    </a>
                    <div class="collapse menu-dropdown {{ 
                    request()->is('orders') || request()->is('all-orders') || request()->is('cancel_orders') || request()->is('confirm_orders') || request()->is('finished_orders')
                    ? 'show' : '' }}" id="sidebarAuth">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a
                              href="{{route('all.order')}}"
                              class="nav-link {{ request()->is('all-orders') ? 'active' : '' }}"
                            >
                              အော်ဒါများ
                            </a>
                        </li>
                        <li class="nav-item">
                          <a
                            href="{{route('order')}}"
                            class="nav-link {{ request()->is('orders') ? 'active' : '' }}"
                          >
                            အော်ဒါအသစ်များ
                          </a>
                        </li>

                        <li class="nav-item">
                            <a
                              href="{{route('cancel_order')}}"
                              class="nav-link {{ request()->is('cancel_orders') ? 'active' : '' }}"
                            >
                                ပယ်ဖျက်ထားသော အော်ဒါများ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{route('confirm_order')}}"
                                class="nav-link {{ request()->is('confirm_orders') ? 'active' : '' }}"
                            >
                                လက်ခံထားသော အော်ဒါများ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{route('finished_order')}}"
                                class="nav-link {{ request()->is('finished_orders') ? 'active' : '' }}"
                            >
                                ပို့ဆောင်ပီးသော အော်ဒါများ
                            </a>
                        </li>
                      </ul>
                    </div>
                  </li>

                  <li class="nav-item mb-2">
                    <a class="nav-link menu-link" href="{{route('live')}}">
                        <i class="ri-image-fill"></i> <span data-key="t-landing">Live Photos</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>