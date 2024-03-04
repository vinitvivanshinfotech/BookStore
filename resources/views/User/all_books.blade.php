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



    <div class="container-fluid">
        <table class="table ">
            <tbody>
                @foreach ($books as $book)
                    @if ($loop->index % 3 == 0)
                        <tr>
                    @endif
                    <td>


                        <div class="card mt-2 mb-2 ms-4 me-4" style="width: 18rem;">

                            <img class="card-img-top"
                                src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($book->book_cover) }}"
                                onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTUUcQuoOAi8EgqOQ6epycAwp8T9WaxN7IkA&usqp=CAU';"
                                alt="Image not fount" height="150px" width="200px">
                            <hr>
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->book_name }}</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b class="text-primary">{{ __('labels.author_name') }} :
                                        </b>
                                        {{ $book->author_name }}</li>
                                    <li class="list-group-item"><b class="text-primary">{{ __('labels.book_price') }} :
                                        </b>{{ $book->book_price }}
                                        <b class="text-primary ms-3">{{ __('labels.book_discount') }} : </b>
                                        {{ $book->book_discount }}
                                    </li>
                                    <li class="list-group-item"><b class="text-primary">{{ __('labels.ratings') }} :
                                        </b>{{ number_format($book->ratings, 1, '.', '') }} </li>
                                    <li class="list-group-item">
                                        <span class="text-success addedSpan {{ $book->id }}"></span>
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ route('user.bookDetails') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" id="book_id" name="book_id"
                                                        value="{{ $book->id }}">
                                                    <button type="submit" class="btn-sm btn-secondary" id="showBookDetails"
                                                        name="showBookDetails" value="" >
                                                        <i class="bi bi-eye-fill mr-1"></i>{{ __('labels.more') }}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <button class="btn-sm btn-primary  addToWishlistButton {{ $book->id }}"
                                                    id="addToWishlistButton" name="addToWishlistButton"
                                                    value="{{ $book->id }}" @if(in_array($book->id,$booksInWishlist)) disabled @endif>
                                                    <i class="bi bi-bookmark-check-fill listStatus {{ $book->id }}">
                                                        @if(in_array($book->id,$booksInWishlist)) SAVED @else Save @endif
                                                    </i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <button class="btn-sm btn-warning   addToCartButton {{ $book->id }}"
                                                    id="addToCartButton" name="addToCartButton"
                                                    value="{{ $book->id }}" @if(in_array($book->id,$booksInCart)) disabled @endif >
                                                    {{-- @if(in_array($book->id,$booksInCart)) disabled value='Added' @else disabled value='add' @endif --}}
                                                    <i class="bi bi-cart-plus-fill mr-1 cartStatus {{ $book->id }}">
                                                        @if(in_array($book->id,$booksInCart)) ADDED @else Cart @endif
                                                    </i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                            </div>
                        </div>

                    </td>

                    @if (($loop->index + 1) % 3 == 0 || $loop->last)
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        {{ $books->links() }}
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
                $('.listStatus.' + dynamicClass).html('').html("SAVED");
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
                $('.listStatus.' + dynamicClass).html('').html("SAVED");
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
                $('.cartStatus.' + dynamicClass).html("").html("ADDED");
               
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
                $('.cartStatus.' + dynamicClass).html('').html("ADDED");

               
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
