<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.orderbook')}}</title>
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
            <th>{{__('adminlabel.order_id')}}</th>
            <th>{{__('adminlabel.total_amount')}}</th>
            <th>{{__('adminlabel.total_quantity')}}</th>
            <th>{{__('adminlabel.order_status')}}</th>
            <th>{{__('adminlabel.action')}}</th>
            <th>{{__('adminlabel.action')}}</th>
            <th>{{__('adminlabel.action')}}</th>


        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order['user']['first_name']}} {{$order['user']['last_name']}}</td>
                <td>{{$order->id}}</td>
                <td>{{$order->book_total_price}}</td>
                <td>{{$order->book_total_quantity}}</td>
                <form action="{{route('update.order.status')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$order->id}}" name="order_id">
                <td>
                    {{$order->order_status}}

                        <div class="form-floating mb-3">
                            @php
                            $order_status[] = $order->order_status;
                            @endphp
                            <select class="form-select" id="floatingSelectGrid" name="Order Status">
                                <option value="{{__('adminlabel.placed_order')}}" @if(in_array('Placed Order',$order_status)) selected @endif>{{__('adminlabel.placed_order')}}</option>
                                <option value="{{__('adminlabel.procees_order')}}" @if(in_array('Process Order',$order_status)) selected @endif>{{__('adminlabel.procees_order')}}</option>
                                <option value="{{__('adminlabel.shipped_order')}}" @if(in_array('Shipped Order',$order_status)) selected @endif>{{__('adminlabel.shipped_order')}}</option>
                                <option value="{{__('adminlabel.delivered_order')}}" @if(in_array('Delivered Order',$order_status)) selected @endif>{{__('adminlabel.delivered_order')}}</option>
                                <option value="{{__('adminlabel.shipped_order')}}" @if(in_array('Shipped Order',$order_status)) selected @endif>{{__('adminlabel.shipped_order')}}</option>
                                <option value="{{__('adminlabel.cancelled_order')}}" @if(in_array('Cancelled Order',$order_status)) selected @endif>{{__('adminlabel.cancelled_order')}}</option>
                            </select>
                            @error('book_edition')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <label for="floatingSelectGrid">{{__('adminlabel.order_status')}}</label>
                        </div>
                    </td>
                    <td><input type="submit" class="btn btn-sm btn-success" value="{{__('adminlabel.update')}}"></td>
                </form>
                <td><a href="{{route('orderdetails.book',$order->id)}}" class="btn btn-sm btn-info">{{__('adminlabel.moreinfo')}}</a></td>
                <td>
                    <form action="{{route('delete.order',$order->id)}}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-sm btn-danger" value="{{__('adminlabel.delete')}}">
                    </form>
                 </td>
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