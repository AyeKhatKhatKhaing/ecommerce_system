@extends('main')

@section('content')
    <h4 class="mb-3">၀ယ်ယူသူများ</h4>
    <div class="card brand">
        <div class="card-body">
            <table class="table table-bordered" id="datatable" style="width:100%;">
                <thead class="text-center">
                    <th class="text-center no-sort no-search">Image</th>
                    <th class="text-center">အမည်</th>
                    <th class="text-center">ဖုန်းနံပါတ်</th>
                    <th class="text-center">၀ယ်ထားသော ပစ္စည်းများကြည့်ရန်</th>
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
                ajax: "/customers/datatable/ssd",
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
                  {data: 'phone', name: 'phone', class: 'text-center'},
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