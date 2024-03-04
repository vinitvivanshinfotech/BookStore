@extends('User.userLayout.layout')
@section('content')
    <h1>{{ __('labels.my_orders') }}</h1>
    <div class="text-right mb-3">
        <button onclick="goBack()" class="btn btn-lg btn-danger">{{ __('labels.back') }}</button>
    </div>
    @foreach ($orders as $order)
        <div class="card">
            <b>
                <h5 class="card-header text-primary">{{ __('labels.order_id') }} : {{ $order['id'] }}</h5>
            </b>
            <div class="card-body">
                <h5 class="card-title">{{ __('labels.order_placed_on') }} :
                    {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}</h5>
                <h5 class="card-title">{{ __('labels.total_quantity') }} : {{ $order['book_total_quantity'] }}</h5>
                <h5 class="card-title">{{ __('labels.total_price') }} : {{ $order['book_total_price'] }}</h5>
                <form action="{{ route('user.orderMoreInfo') }}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                    <button type="submit" class="btn btn-secondary "><i class="bi bi-eye-fill mr-1"></i>
                        {{ __('labels.more_details') }}</button>
                </form>
            </div>
        </div>

        <br>
    @endforeach
@endsection

@push('scripts')
@endpush
