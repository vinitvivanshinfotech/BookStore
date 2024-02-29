@extends('User.userLayout.layout')
@section('content')
    <h1>{{ __('labels.see_cart_btn') }}</h1>

    <div class="container-fluid">
        <table class="table table-bordered" id="myWishlist" name="myWishlist">
            <thead>
                <tr>
                    <th scope="col">{{ __('labels.book_cover') }}</th>
                    <th scope="col">{{ __('labels.book_name') }}</th>
                    <th scope="col">{{ __('labels.author_name') }}</th>
                    <th scope="col">{{ __('labels.book_price') }}</th>
                    <th scope="col">{{ __('labels.book_discount') }}</th>
                    <th scope="col">{{ __('labels.quantity') }}</th>
                    <th scope="col">{{ __('labels.remover') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCartItem = 0;
                    $totalCartPrice = 0;
                @endphp
                @foreach ($data as $item)
                    <tr>

                        <td><img class="card-img-top mt-1 mb-1 ms-1 mr-1"
                                src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($item['book_details']['book_cover']) }}"
                                alt="Card image cap" height="100px" width="50px"></td>
                        <td>{{ $item['book_details']['book_name'] }}</td>
                        <td>{{ $item['book_details']['author_name'] }}</td>
                        <td>{{ $item['book_details']['book_price'] }}</td>
                        <td>{{ $item['book_details']['book_discount'] }}</td>
                        <td>

                            
                            <form action="{{route('user.quantityChange')}}" method="post" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="action" value="decrease">
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-primary"><i class="bi bi-dash"></i></button>
                            </form>

                            {{ $item['book_quantity'] }}

                            <form action="{{route('user.quantityChange')}}" method="post" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="action" value="increse">
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-primary"><i class="bi bi-plus-lg"></i></button>
                            </form>

                        </td>
                        <td>
                            <form action="{{ route('user.removeFromCart') }}" method="POST">
                                @csrf
                                <input type="hidden" id="cart_id" name="cart_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-sm btn-danger mt-2 mb-3 " id="" name="">
                                    <i class="bi bi-trash3-fill mr-1"></i>{{ __('labels.remove_from_list') }}
                                </button>
                            </form>
                        </td>

                    </tr>
                    @php
                        $totalCartItem += $item['book_quantity'];
                        $totalCartPrice += $item['book_details']['book_price'] * $item['book_quantity'];
                    @endphp
                @endforeach

                <td></td>
                <td></td>
                <td></td>
                <td>
                    <b>{{ __('labels.total_quantity') }} : </b>{{ $totalCartItem }}
                </td>
                <td>
                    <b>{{ __('labels.total_price') }} : </b>{{ $totalCartPrice }}
                </td>

            </tbody>
        </table>
    </div>

    <div class="text-center mb-3">
        <form action="{{ route('user.ShippingDetailsForm') }}" method="get">
            <button type="submit" class="btn btn-lg btn-primary mr-5">{{ __('labels.add_shipping_details') }}<i
                    class="bi bi-play-fill ms-1"></i></button>
        </form>
    </div>
@endsection
