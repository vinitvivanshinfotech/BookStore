@extends('User.userLayout.layout')

{{-- {{dd($bookDetails['reviewbooks'])}} --}}
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="text-right mb-3">
                <a href="{{route('user.showBooks')}}"><button  class="btn btn-lg btn-danger">{{ __('labels.back') }}</button></a>
            </div>

            <b class="text-primary">
                <h2>Book Name : {{ $bookDetails->book_name }}</h2>
            </b>
            <br>
            <b>
                <h4>Title : {{ $bookDetails->book_title }}</h4>
            </b>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <img class="card-img-top"
                            src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($bookDetails->book_cover) }}"
                            alt="Book cover"
                            onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTUUcQuoOAi8EgqOQ6epycAwp8T9WaxN7IkA&usqp=CAU';"
                            style="border: 1px solid black; height: 200px; width: 100px;">
                    </div>
                    <div class="col-md-4">
                        <b class="mt-2">{{ __('labels.book_edition') }}</b> : {{ $bookDetails->book_edition }}
                        <br>
                        <br>
                        <b>{{ __('labels.book_language') }}</b> : {{ $bookDetails->book_language }}
                        <br>
                        <br>
                        <b>{{ __('labels.book_type') }}</b> : {{ $bookDetails->book_type }}
                        <br>
                    </div>
                    <div class="col-md-4">
                        <blockquote class="blockquote mb-0">
                            <p>{{ __('labels.description') }} : {{ $bookDetails->description }}</p>
                            <footer class="blockquote-footer">{{ __('labels.author_name') }} : <cite
                                    title="Source Title">{{ $bookDetails->author_name }}</cite></footer>
                        </blockquote>
                        <br>
                        <h5>{{ __('labels.book_price') }}: {{ $bookDetails->book_price }}</h5>
                        <h5 class="text-success">{{ __('labels.book_discount') }}: {{ $bookDetails->book_discount }}</h5>
                    </div>
                    <div class="col-md-2">
                        <span class="text-success addedSpan {{ $bookDetails->id }}"></span>
                        <br>

                       

                        <button class="btn-sm btn-primary  addToWishlistButton {{ $bookDetails->id }}"
                            id="addToWishlistButton" name="addToWishlistButton"
                            value="{{ $bookDetails->id }}" @if(in_array($bookDetails->id,$booksInWishlist)) disabled @endif>
                            <i class="bi bi-bookmark-check-fill listStatus {{ $bookDetails->id}}">
                                @if(in_array($bookDetails->id,$booksInWishlist)) SAVED @else Save @endif
                            </i>
                        </button>

                       

                        <button class="btn-sm btn-warning   addToCartButton {{ $bookDetails->id }}"
                            id="addToCartButton" name="addToCartButton"
                            value="{{ $bookDetails->id }}" @if(in_array($bookDetails->id,$booksInCart)) disabled @endif >
                            {{-- @if(in_array($bookDetails->id,$booksInCart)) disabled value='Added' @else disabled value='add' @endif --}}
                            <i class="bi bi-cart-plus-fill mr-1 cartStatus {{ $bookDetails->id }}">
                                @if(in_array($bookDetails->id,$booksInCart)) ADDED @else Cart @endif
                            </i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table >
        <tbody>
            <h3 class="text-primary mt-2">{{ __('labels.review') }}</h3>
            @foreach ($bookDetails['reviewbooks'] as $review)
                @if ($loop->index % 4 == 0)
                    <tr>
                @endif
                <td>
                    <div class="card mt-2 mr-2" style="width: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">{{ $review['user']['first_name'] }}
                                {{ $review['user']['last_name'] }}</h5>
                            <p class="card-text">{{ $review['book_comments'] }}</p>

                        </div>
                    </div>
                </td>
                @if (($loop->index + 1) % 4 == 0 || $loop->last)
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>


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
