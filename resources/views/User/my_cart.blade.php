@extends('User.userLayout.layout')
@section('content')

<div class="d-flex justify-content-end mb-2">
    <form class="form-inline mr-3" method="get" action="{{ route('user.watchlist') }}">
        <button class="btn btn-sm btn-primary" type="submit" id="seeWatchlist" name="seeWatchlist" value="">
            <i class="bi bi-bookmark-check-fill mr-1"></i>{{ __('labels.see_wishlist_btn') }}<i id="watchlistCount"></i>
        </button>
    </form>

</div>


@if(sizeof($data) !=0)

<h1>{{ __('labels.see_cart_btn') }}</h1>
    <div class="container-fluid">
        <table class="table table-bordered" id="myCart" name="myCart">
            <thead>
                <tr>
                    <th id="book_cover" name="book_cover" scope="col">{{ __('labels.book_cover') }}</th>
                    <th id="book_name" name="book_name" scope="col">{{ __('labels.book_name') }}</th>
                    <th id="author_name" name="author_name" scope="col">{{ __('labels.author_name') }}</th>
                    <th id="book_price" name="book_price" scope="col">{{ __('labels.book_price') }}</th>
                    <th id="book_discount" name="book_discount" scope="col">{{ __('labels.book_discount') }}</th>
                    <th id="quantity" name="quantity" scope="col">{{ __('labels.quantity') }}</th>
                    <th id="more" name="more" scope="col">{{ __('labels.more') }}</th>
                    <th id="remover" name="remover" scope="col">{{ __('labels.remover') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCartItem = 0;
                    $totalCartPrice = 0;
                    $totalCartDiscount = 0;
                @endphp
                @foreach ($data as $item)
                    <tr>

                        <td><img class="card-img-top mt-1 mb-1 ms-1 mr-1"
                                src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($item['book_details']['book_cover']) }}"
                                onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTUUcQuoOAi8EgqOQ6epycAwp8T9WaxN7IkA&usqp=CAU';"
                                alt="Card image cap" height="100px" width="50px"></td>
                        <td>{{ $item['book_details']['book_name'] }}</td>
                        <td>{{ $item['book_details']['author_name'] }}</td>
                        <td>{{ $item['book_details']['book_price'] }}</td>
                        <td>{{ $item['book_details']['book_discount'] }}</td>
                        <td>


                            <form action="{{ route('user.quantityChange') }}" method="post"
                                style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="action" value="decrease">
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-primary"><i class="bi bi-dash"></i></button>
                            </form>

                            {{ $item['book_quantity'] }}

                            <form action="{{ route('user.quantityChange') }}" method="post"
                                style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="action" value="increse">
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-primary"><i class="bi bi-plus-lg"></i></button>
                            </form>

                        </td>
                        <td>

                            <form action="{{ route('user.bookDetails') }}" method="GET">
                                @csrf
                                <input type="hidden" id="book_id" name="book_id" value="{{ $item['book_id'] }}">
                                <button type="submit" class="btn-sm btn-secondary" id="showBookDetails"
                                    name="showBookDetails" value="">
                                    <i class="bi bi-eye-fill mr-1"></i>{{ __('labels.more') }}
                                </button>
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
                        $totalCartDiscount += $item['book_details']['book_discount'] * $item['book_quantity'];
                    @endphp
                @endforeach




            </tbody>
        </table>

        <div class="text-end mt-3 mr-5">
                <b class="">{{ __('labels.total_price') }} : </b>{{ $totalCartPrice }} <br>
                <b class="">{{ __('labels.total_discount') }} : </b>{{ $totalCartDiscount }} <br>
                <b class="">{{ __('labels.total_quantity') }} : </b>{{ $totalCartItem }} <br>
                <b class="">{{ __('labels.amout_to_be_payable') }} : </b>{{ $totalCartPrice - $totalCartDiscount }} <br>
        </div>

    </div>

    <div>
    </div>

    @if ($totalCartItem != 0)
        <div class="text-center mb-3">
            <form action="{{ route('user.ShippingDetailsForm') }}" method="get">
                <button type="submit" class="btn btn-lg btn-primary mr-5">{{ __('labels.add_shipping_details') }}<i
                        class="bi bi-play-fill ms-1"></i></button>
            </form>
        </div>
    @endif
@else
    <div class="text-centre text-dark">
        <h1 class=""> {{__('messages.empty_cart')}}</h1>
    </div>
@endif
@endsection

@push('scripts')
    let table = new DataTable('#myCart');

    $.ajax({
        type: 'get',
        url: '/api/getWatchlistCartData',
        data: {
            'user_id': {{ auth()->user()->id }}
        },
        dataType: "json",
        success: function(data) {
            $('#watchlistCount').html("").html('(' + data['wishlistCount'] + ')');
            $('#cartCount').html("").html('(' + data['cartCount'] + ')');

        },
        error: function(err) {

        }

    });

    $('.addToWishlistButton').click(function() {

        // Get the value of the book ID
        var bookId = $(this).val();
        // Get the value of the authenticated user's ID
        var userId = {{ auth()->id() }};
        // Log the values to the console (you can do further processing here)

        $.ajax({
            type: 'get',
            url: '/api/addToWishlist/' + userId + '/' + bookId,
            data: {
                'book_id': bookId,
                'user_id': userId
            },
            dataType: "json",
            success: function(data) {

                var dynamicClass = data['book_id']


                if (data['status'] == "exists") {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        title: "{{ __('messages.exists_in_wishlist') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.addedSpan.' + dynamicClass).html('Allredy Exists');
                    $('.addToWishlistButton.' + dynamicClass).prop("disabled", true);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "{{ __('messages.added_to_wishlist') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.addedSpan.' + dynamicClass).html('Added to list');
                    $('.addToWishlistButton.' + dynamicClass).prop("disabled", true);
                }



            },
            error: function(err) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "{{ __('messages.added_to_wishlist_error') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

        $.ajax({
            type: 'get',
            url: '/api/getWatchlistCartData',
            data: {
                'user_id': {{ auth()->user()->id }}
            },
            dataType: "json",
            success: function(data) {
                $('#watchlistCount').html("").html('(' + data['wishlistCount'] + ')');
                $('#cartCount').html("").html('(' + data['cartCount'] + ')');

            },
            error: function(err) {

            }

        });
    });
@endpush
