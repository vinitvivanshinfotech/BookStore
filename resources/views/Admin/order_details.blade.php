<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.orderdetails')}}</title>
    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <section>
        <div>
            <div class="card">
                <h5 class="card-header">{{__('adminlabel.orderdetails')}}</h5>
                <div class="card-body">
                    <h5 class="card-title">{{__('adminview.shipingdetails')}}</h5>
                    <fieldset disabled>
                        <div class="row g-3">
                            <div class="col">
                                <label for="disabledTextInput" class="form-label">{{__('labels.first_name')}}</label>
                                <input type="text" class="form-control" placeholder="First name" aria-label="First name" value="{{$orderDetails[0]['first_name']}}">
                            </div>
                            <div class="col">
                                <label for="disabledTextInput" class="form-label">{{__('labels.last_name')}}</label>
                                <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" value="{{$orderDetails[0]['last_name']}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="disabledTextInput" class="form-label" value="{{$orderDetails[0]['email']}}">{{__('labels.email')}}</label>
                            <input type="email" class="form-control" id="disabledTextInput" value="{{$orderDetails[0]['email']}}">
                        </div>
                        <div class="col-md-6">
                            <label for="disabledTextInput" class="form-label">{{__('labels.phone_number')}}</label>
                            <input type="text" class="form-control" value="{{$orderDetails[0]['phone_number']}}">
                        </div>
                        <div class="col-12">
                            <label for="disabledTextInput" class="form-label">{{__('labels.address')}}</label>
                            <input type="text" class="form-control" id="disabledTextInput" value="{{$orderDetails[0]['address']}}">
                        </div>
                        <div class="col-12">
                            <label for="disabledTextInput" class="form-label">Address 2</label>
                            <input type="text" class="form-control" id="disabledTextInput" value="{{$orderDetails[0]['address']}}">
                        </div>
                        <div class="col-md-6">
                            <label for="disabledTextInput" class="form-label">{{__('labels.city')}}</label>
                            <input type="text" class="form-control" id="disabledTextInput" value="{{$orderDetails[0]['city']}}">
                        </div>
                        <div class="col-md-4">
                            <label for="disabledTextInput" class="form-label">{{__('labels.state')}}</label>
                            <input type="text" class="form-control" id="disabledTextInput" value="{{$orderDetails[0]['state']}}">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="disabledTextInput" class="form-label">{{__('labels.pincode')}}</label>
                            <input type="text" class="form-control" id="disabledTextInput" value="{{$orderDetails[0]['pincode']}}">
                        </div>
                    </fieldset>
                </div>
            </div>
    </section>
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
            <th>{{__('labels.quantity')}}</th>
            <th>{{__('labels.discount')}}</th>
            <th>{{__('labels.total_price')}}</th>
        </thead>
        <tbody>
            @foreach ($orderDetails as $orderDetail )    
            <tr>
                <td>{{$loop->index+1 }}</td>
                <td>{{$orderDetail['book_name']}}</td>
                <td>{{$orderDetail['book_price']}}</td>
                <td>{{$orderDetail['book_total_quantity']}}</td>
                <td>{{$orderDetail['book_discount']}}</td>
                <td>{{  ($orderDetail['book_price'] * $orderDetails[0]['book_total_quantity']) - ($orderDetail['book_discount'] * $orderDetails[0]['book_total_quantity'])  }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>   


</body>

</html>