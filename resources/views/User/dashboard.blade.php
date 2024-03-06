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

@endpush
