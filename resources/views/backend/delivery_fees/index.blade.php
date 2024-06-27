@extends('main')

@section('content')
    <h4 class="mb-3">ပို့ဆောင်ခ</h4>
    <div class="card brand">
        <div class="card-header d-flex justify-content-between py-4">
            <a class="primary_button" href="{{route('fee.create')}}">
                <div class="d-flex align-items-center">
                    <i class=" ri-add-circle-fill mr-2 primary-icon"></i>
                    <span class="button_content">ပို့ဆောင်ခအသစ်ဖန်တီးမည်</span>
                </div>
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="datatable" style="width:100%;">
                <thead class="text-center">
                    <th class="text-center no-sort">မြို့နယ်</th>
                    <th class="text-center no-sort">တိုင်းဒေသကြီး / ပြည်နယ်</th>
                    <th class="text-center">စျေးနူန်း</th>
                    <th class="text-center">တန်ဆာခ</th>
                    <th class="text-center no-sort no-search">ပြင်မည်/ဖျက်မည်</th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
      $(document).ready(function() {
            let table = $('#datatable').DataTable( {
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/delivery_fees/datatable/ssd",
                language : {
                  "processing": "<img src='{{asset('/images/loading.gif')}}' width='50px'/><p></p>",
                  "paginate" : {
                    "previous" : '<i class="ri-arrow-left-circle-fill"></i>',
                    "next" : '<i class="ri-arrow-right-circle-fill"></i>',
                  }
                },
                columns : [
                  {data: 'township', name: 'township', class: 'text-center'},
                  {data: 'region_name', name: 'region_name', class: 'text-center'},
                  {data: 'price', name: 'price', class: 'text-center'},
                  {data: 'add_on_charge', name: 'add_on_charge', class: 'text-center'},
                  {data: 'action', name: 'action', class: 'text-center'},
                ],
                columnDefs : [
                  {
                    targets : 'hidden',
                    visible : false,
                    searchable : false,
                  },
                  {
                    targets : 'no-sort',
                    sortable : false,
                  },
                  {
                    targets : 'no-search',
                    searchable : false,
                  },
                  {
                    targets: [0],
                    class : "control"
                  },  
                ]
            });

            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1800,
              width : '18em',
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

            $(document).on('click', '.delete_btn', function(e) {
              e.preventDefault();
              swal({
                text: "Are you sure?",
                icon: "info",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  let id = $(this).data('id');
                  $.ajax({
                    url : `/delivery_fees/${id}`,
                    method : 'DELETE',
                  }).done(function(res) {
                      table.ajax.reload();
                      Toast.fire({
                      icon: 'success',
                      title: "အောင်မြင်ပါသည်။"
                    })
                  })
                }
              });
            })
        })
    </script>
@endsection