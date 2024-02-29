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
                        <th scope="col">{{ __('labels.book_edition') }}</th>
                        <th scope="col">{{ __('labels.book_price') }}</th>
                        <th scope="col">{{ __('labels.book_discount') }}</th>
                        <th scope="col">{{ __('labels.quantity') }}</th>
                        <th scope="col">{{ __('labels.give_review') }}</th>
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
                            <td>{{ $bookInfo['book_edition'] }}</td>
                            <td>{{ $bookInfo['book_price'] }}</td>
                            <td>{{ $bookInfo['book_discount'] }}</td>
                            <td>{{ $bookInfo['book_quantity'] }}</td>
                            <td>
                                <form action="{{ route('user.addBookReview') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="book_id" id="book_id"
                                        value="{{ $bookInfo['book_details_id'] }}">

                                    <input class="" type="number" name="" placeholder="{{__( 'labels.rating' )}}"   value="0"/>
                                    <br>
                                    <input class="mt-1" type="text" name="" placeholder="{{__('labels.your_review')}}" >
                                    <br>

                                    <button type="submit" class="btn btn-sm btn-primary mt-1"><i
                                            class="bi bi-send mr-1"></i>{{ __('labels.submit_review') }}</button>

                                </form>
                            </td>
                        </tr>
                        @php
                            $totalPrice += $bookInfo['book_price'] * $bookInfo['book_quantity'];
                            $totalDiscount += $bookInfo['book_discount'] * $bookInfo['book_quantity'];
                        @endphp
                    @endforeach
                    <tr>
                        <td><b class="text-primary">{{ __('labels.total') }}</b></td>
                        <td> - </td>
                        <td><b class="text-primary">{{ $totalPrice }}</b></td>
                        <td><b class="text-primary">{{ $totalDiscount }}</b></td>
                        <td><b class="text-primary">{{ $data[0]['book_total_quantity'] }}</b></td>
                    </tr>


                </tbody>
            </table>


            <button onclick="goBack()" class="btn btn-lg btn-danger">{{ __('labels.back') }}</button>

            <button type="button" class="btn btn-light text-right" disabled><b>{{ __('labels.payable_amount') }} :
                    {{ $data[0]['book_total_price'] }}</b></button>

        </div>
        <div class="card-footer text-muted">
            <h3>{{ __('labels.status') }} : {{ $data[0]['order_status'] }} </h3>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
