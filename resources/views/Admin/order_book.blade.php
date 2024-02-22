<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')

    <table class="table table-bordered table-hover" id="books_list" name="books_list">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <thead>
            <th>{{__('adminlabel.no')}}</th>
            <th>{{__('adminlabel.customer_name')}}</th>
            <th>{{__('adminlabel.author_name')}}</th>
            <th>{{__('adminlabel.book_name')}}</th>
            <th>{{__('adminlabel.book_name')}}</th>
            <th>{{__('adminlabel.book_name')}}</th>
            <th>{{__('adminlabel.orderdetails')}}</th>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order['user']['first_name']}} {{$order['user']['last_name']}}</td>
                <td>{{$order['book']['book_name']}}</td>
                <td>{{$order['book']['author_name']}}</td>
                <td>{{$order['book']['book_price']}}</td>
                <td>{{$order->book_quantity}}</td>
                <td><a href="{{route('orderdetails.book',$order->id)}}">{{__('adminlabel.moreinfo')}}</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#books_list');

        });
    </script>
</body>

</html>