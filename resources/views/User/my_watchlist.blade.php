@extends('User.userLayout.layout')
@section('content')
<div class="d-flex justify-content-end mb-2">
   
    <form class="form-inline" method="get" action="{{ route('user.cart') }}">
        <button class="btn btn-sm btn-warning" type="submit" id="seeCart" name="seeCart" value="">
            <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.see_cart_btn') }}<i id="cartCount"></i>
        </button>
    </form>
</div>

@if(sizeof($data) !=0)

    <h1>{{ __('labels.see_wishlist_btn') }}</h1>
    <div class="container-fluid">
        <table class="table table-bordered" id="myWishlist" name="myWishlist">
            <thead>
                <tr>
                    <th scope="col">{{ __('labels.book_cover') }}</th>
                    <th scope="col">{{ __('labels.book_name') }}</th>
                    <th scope="col">{{ __('labels.author_name') }}</th>
                    <th scope="col">{{ __('labels.book_price') }}</th>
                    <th scope="col">{{ __('labels.book_discount') }}</th>
                    <th scope="col">{{ __('labels.more') }}</th>
                    <th scope="col">{{ __('labels.remover') }}</th>
                    <th scope="col">{{ __('labels.add_to_cart') }}</th>
                </tr>
            </thead>
            <tbody>
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
                            <form action="{{ route('user.bookDetails') }}" method="GET">
                                @csrf
                                <input type="hidden" id="book_id" name="book_id"
                                    value="{{ $item['book_details']['id'] }}">
                                <button type="submit" class="btn-sm btn-secondary" id="showBookDetails"
                                    name="showBookDetails" value="">
                                    <i class="bi bi-eye-fill mr-1"></i>{{ __('labels.more') }}
                                </button>
                            </form>
                        </td>

                        <td>
                            <form class="mt-1" action="{{ route('user.removeFromWatchlist') }}" method="POST">
                                @csrf
                                <input type="hidden" id="wishlist_id" name="wishlist_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-sm btn-danger mt-2 mb-3 " id="" name="">
                                    <i class="bi bi-trash3-fill mr-1" ></i>{{ __('labels.remove_from_list') }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="text-success addedSpan {{$item['book_details']['id']}}"></span>
                            <button class="btn-sm btn-warning mt-2 mb-3 addToCartButton {{$item['book_details']['id']}}" id="addToCartButton"
                                name="addToCartButton" value="{{ $item['book_details']['id'] }}" @if(in_array($item['book_details']['id'],$booksInCart)) disabled @endif>
                                <i class="bi bi-cart-plus-fill mr-1 cartStatus {{$item['book_details']['id'] }}"></i>@if(in_array($item['book_details']['id'],$booksInCart)) ADDED @else Cart @endif
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    @else
        <div class="text-centre text-dark">
            <h1 class=""> {{__('messages.empty_wishlist')}}</h1>
        </div>
    @endif
@endsection

@push('scripts')
    let table = new DataTable('#myWishlist');

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

    $('.addToCartButton').click(function() {
        var bookId = $(this).val();
        var userId = {{ auth()->id() }};

        $.ajax({
            type: 'get',
            url: '/api/addToCart/' + userId + '/' + bookId,
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
                        icon: "success",
                        title: "{{ __('messages.quantity_incresed') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.addedSpan.' + dynamicClass).html('Quantity incresed');
                    $('.addToCartButton.' + dynamicClass).prop("disabled", true);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "{{ __('messages.added_to_cart') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.addedSpan.' + dynamicClass).html('Added to cart');
                    $('.addToCartButton.' + dynamicClass).prop("disabled", true);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }



            },
            error: function(err) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "{{ __('messages.added_to_cart_error') }}",
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
