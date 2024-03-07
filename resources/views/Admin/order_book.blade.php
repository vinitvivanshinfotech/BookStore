<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.orderbook')}}</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <table class="table table-bordered table-hover" id="datatable" name="books_list">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <thead>
            <th>{{__('adminlabel.no')}}</th>
            <th>{{__('adminlabel.customer_name')}}</th>
            <th>{{__('adminlabel.order_id')}}</th>
            <th>{{__('adminlabel.total_amount')}}</th>
            <th>{{__('adminlabel.total_quantity')}}</th>
            <th>{{__('adminlabel.order_status')}}</th>
            <th>{{__('adminlabel.action')}}</th>
        </thead>
        <!-- <tbody id="orders">

        </tbody> -->
    </table>
    <script>
        $(document).ready(function() {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: {
                     url :"{{route('order.book')}}",
                     dataType:"json",
                     type:"POST",
                     data:{_token: '{{csrf_token()}}'}  
                    },
                    columns:[
                        {data:'id'},
                        {data:'customer_name'},
                        {data:'orderid'},
                        {data:'book_total_price'},
                        {data:'book_total_quantity'},
                        {data:'order_status'},
                        {data:'options'}

                    ],
                });
            });
           
    </script>

</body>

</html>