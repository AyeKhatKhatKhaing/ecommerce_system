@extends('main')

@section('content')
    <h4 class="mb-3">Confirm Orders</h4>
    <div class="card brand">
        <div class="card-body">
            <table class="table table-bordered" id="datatable" style="width:100%;">
                <thead class="text-center">
                    <th class="text-center no-sort">Order Number</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Total Price</th>
                    <th class="text-center">Action</th>
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
                ajax: "/confirm_orders/datatable/ssd",
                language : {
                  "processing": "<img src='{{asset('/images/loading.gif')}}' width='50px'/><p></p>",
                  "paginate" : {
                    "previous" : '<i class="ri-arrow-left-circle-fill"></i>',
                    "next" : '<i class="ri-arrow-right-circle-fill"></i>',
                  }
                },
                columns : [
                  {data: 'order_number', name: 'order_number', class: 'text-center'},
                  {data: 'created_at', name: 'created_at', class: 'text-center'},
                  {data: 'customer', name: 'customer'},
                  {data: 'payment_type', name: 'payment_type', class: 'text-center'},
                  {data: 'grand_total', name: 'grand_total', class: 'text-center'},
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
        })
    </script>
@endsection