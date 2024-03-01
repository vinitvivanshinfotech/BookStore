<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.orderdetails')}}</title>
    @include('cdn')
</head>

<body>
    <div class="row">
        <div class="col-xs-10">
            <div class="invoice-title">
                <h2>{{__('adminlabel.invoice')}}</h2>
                <h5 class="pull-right">Order id {{$orderDetails[0]['order_id']}}</h5>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        {{$orderDetails[0]['first_name']}} {{$orderDetails[0]['last_name']}}<br>
                        {{$orderDetails[0]['phone_number']}}<br>
                        {{$orderDetails[0]['email']}}<br>
                        {{$orderDetails[0]['city']}}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        {{$orderDetails[0]['first_name']}} {{$orderDetails[0]['last_name']}}<br>
                        {{$orderDetails[0]['address']}}<br>
                        {{$orderDetails[0]['pincode']}}<br>
                        {{$orderDetails[0]['city']}} {{$orderDetails[0]['state']}}
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        {{$orderDetails[0]['payment_mode']}}<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{$orderDetails[0]['book_billdate']}}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>
    </div>

    <table class="table table-bordered table-hover" id="books_list" name="books_list">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <thead>
            <th>{{__('adminlabel.no')}}</th>
            <th>{{__('labels.book_name')}}</th>
            <th>{{__('labels.book_price')}}</th>
            <th>{{__('labels.discount')}}</th>
            <th>{{__('labels.quantity')}}</th>
            <th>{{__('labels.total_price')}}</th>
        </thead>
        <tbody>
            @php
            $total_amount = 0
            @endphp
            @foreach ($orderDetails as $orderDetail )
            {{$orderDetail['book_quantity']}}
            <tr>
                <td>{{$loop->index+1 }}</td>
                <td>{{$orderDetail['book_name']}}</td>
                <td>{{$orderDetail['book_price']}}</td>
                <td>{{$orderDetail['book_discount']}}</td>
                <td>{{$orderDetail['book_quantity']}}</td>
                <td>{{(($orderDetail['book_price'] * $orderDetail['book_quantity']) - ($orderDetail['book_discount'] * $orderDetail['book_quantity']))}}
                @php
                $total_amount += (($orderDetail['book_price'] * $orderDetail['book_quantity']) - ($orderDetail['book_discount'] * $orderDetail['book_quantity']))
                @endphp
            </td>
            </tr>
            @endforeach
            <tr>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line text-right"><strong>Total Quantity : </strong> {{$orderDetails->sum('book_quantity')}}</td>
                <td class="no-line text-right"><strong>Total Price : </strong> {{($total_amount)}}</td>
            </tr>
        </tbody>


    </table>
</body>

</html>