@extends('main')

@section('content')
    <div class="card-header">
        <a href="{{route('customer')}}" class="card-title mb-0 d-inline-flex align-items-center create_title">
            <i class=" ri-arrow-left-s-line mr-3 primary-icon"></i> 
            <span class="create_sub_title">{{$customer->name}} ၏၀ယ်ယူထားသော အထည်များ</span>
        </a>
    </div>
    <div class="card brand">
        <div class="card-body">
            <table class="table table-bordered" id="datatable" style="width:100%;">
                <thead class="text-center">
                    <th class="text-center no-sort no-search">Image</th>
                    <th class="text-center no-sort">Product Name</th>
                    <th class="text-center">အရေအတွက်</th>
                    <th class="text-center">စျေးနူန်း</th>
                    <th class="text-center">စုစုပေါင်းစျေးနူန်း</th>
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
                ajax: "/customers/"+ {{$id}} +"/datatable/ssd",
                language : {
                  "processing": "<img src='{{asset('/images/loading.gif')}}' width='50px'/><p></p>",
                  "paginate" : {
                    "previous" : '<i class="ri-arrow-left-circle-fill"></i>',
                    "next" : '<i class="ri-arrow-right-circle-fill"></i>',
                  }
                },
                columns : [
                    {data: 'image', name: 'image', class: 'text-center'},
                    {data: 'name', name: 'name', class: 'text-center'},
                    {data: 'quantity', name: 'quantity', class: 'text-center'},
                    {data: 'price', name: 'price', class: 'text-center'},
                    {data: 'total_price', name: 'total_price', class: 'text-center'},
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