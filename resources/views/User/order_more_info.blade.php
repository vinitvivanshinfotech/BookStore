@extends('User.userLayout.layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="text-primary">{{ __('labels.order_id') }}: {{ $data[0]['id'] }} </h1>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ __('labels.order_placed_on') }} :
                {{ \Carbon\Carbon::parse($data[0]['created_at'])->format('d-m-Y') }}</h5>

            <h6>{{ __('labels.total_price') }} : {{ $data[0]['book_total_price'] }}</h6>
            <h6>{{ __('labels.total_quantity') }} : {{ $data[0]['book_total_quantity'] }}</h6>


            <table class="table table-bordered mt-3 mb-3">
                <thead>
                    <tr>
                        <th scope="col">{{ __('labels.book_name') }}</th>
                        <th scope="col">{{ __('labels.book_price') }}</th>
                        <th scope="col">{{ __('labels.book_discount') }}</th>
                        <th scope="col">{{ __('labels.quantity') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalDiscount = 0;
                        $totalPrice = 0;
                    @endphp
                    @foreach ($data as $bookInfo)
                        <tr>
                            <td>{{ $bookInfo['book_name'] }}</td>
                            <td>{{ $bookInfo['book_price'] }}</td>
                            <td>{{ $bookInfo['book_discount'] }}</td>
                            <td>{{ $bookInfo['book_quantity'] }}</td>
                        </tr>
                        @php
                            $totalPrice += $bookInfo['book_price']*$bookInfo['book_quantity']; 
                            $totalDiscount+=$bookInfo['book_discount'];
                        @endphp
                    @endforeach
                    <tr>
                        <td><b class="text-primary">{{ __('labels.total') }}</b></td>
                        <td><b class="text-primary">{{$totalPrice}}</b></td>
                        <td><b class="text-primary">{{ $totalDiscount }}</b></td>
                        <td><b class="text-primary">{{ $data[0]['book_total_quantity'] }}</b></td>
                    </tr>


                </tbody>
            </table>


            <button onclick="goBack()" class="btn btn-lg btn-danger">{{ __('labels.back') }}</button>

            <button type="button" class="btn btn-light text-right" disabled><b>{{__('labels.payable_amount')}} : {{ $data[0]['book_total_price'] }}</b></button>

        </div>
        <div class="card-footer text-muted">
            <h3>{{ __('labels.status') }} : {{$data[0]['order_status']}} </h3>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
