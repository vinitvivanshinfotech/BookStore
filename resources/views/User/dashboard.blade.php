@extends('User.userLayout.layout')
@section('content')
    
<div class="d-flex justify-content-end mb-2">
    <form class="form-inline mr-3" method="get" action="{{ route('user.watchlist') }}">
        <button class="btn btn-sm btn-primary" type="submit" id="seeWatchlist" name="seeWatchlist" value="">
            <i class="bi bi-bookmark-check-fill mr-1"></i>{{ __('labels.see_wishlist_btn') }}<i id="watchlistCount"></i>
        </button>
    </form>

    <form class="form-inline" method="get" action="{{ route('user.cart') }}">
        <button class="btn btn-sm btn-warning" type="submit" id="seeCart" name="seeCart" value="">
            <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.see_cart_btn') }}<i id="cartCount"></i>
        </button>
    </form>
</div>


@endsection

@push('scripts')
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
