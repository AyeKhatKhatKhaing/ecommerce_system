<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>
        
        <meta charset="utf-8" />
        <title>Innocence Baby</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.cs')}}s" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
        {{-- style --}}
        <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />

        {{-- Poppins --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        
        {{-- datatable --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

        {{-- Image Upload --}}
        <link href="{{ asset('assets/css/image-uploader.min.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('layouts.Header');
            
            @include('layouts.Sidebar');
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                @yield('content')
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

              @include('layouts.Footer')
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->

        

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
{{-- 
        <div class="customizer-setting d-none d-md-block">
            <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
                data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
            </div>
        </div> --}}

        <!-- Theme Settings -->
       @include('layouts.ThemeSetting');

        {{-- Jquery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        {{-- <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script> --}}
        {{-- <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script> --}}
        <script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
        <script src="{{asset('assets/js/plugins.js')}}"></script>

        <!-- prismjs plugin -->
        {{-- <script src="{{asset('assets/libs/prismjs/prism.j')}}s"></script> --}}
        
        <!-- App js -->
        <script src="{{asset('assets/js/app.js')}}"></script>

        {{-- Sweet Alert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        {{-- Datatable --}}
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

        {{-- jsvalidation --}}
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        <script>
            $(document).ready(function() {
                let token = document.head.querySelector('meta[name="csrf-token"]')
                
                if(token) {
                    $.ajaxSetup({
                        headers : {
                            'X-CSRF-TOKEN' : token.content
                        }
                    })
                };

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1800,
                    width : '25em',
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                @if (session('created'))
                    Toast.fire({
                        icon: 'success',
                        title: "အောင်မြင်ပါသည်။"
                    })
                @endif

                @if (session('updated'))
                    Toast.fire({
                        icon: 'success',
                        title: "အောင်မြင်ပါသည်။"
                    })
                @endif

                @if (session('cancel'))
                    Toast.fire({
                        icon: 'success',
                        title: "အော်ဒါ cancel ခြင်းအောင်မြင်ပါသည်။"
                    })
                @endif

                @if (session('confirm'))
                    Toast.fire({
                        icon: 'success',
                        title: "အော်ဒါ confirm ခြင်းအောင်မြင်ပါသည်။"
                    })
                @endif

                @if (session('finished'))
                    Toast.fire({
                        icon: 'success',
                        title: "အော်ဒါအောင်မြင်စွာ ပေးပို့ပြီးပါပြီ။"
                    })
                @endif
            })
        </script>
        @yield('script')
    </body>

</html>