@extends('User.userLayout.layout')
@section('content')
    

    <div class="card">
        <div class="card-header">
            <div class="text-right mb-3">
                <button onclick="goBack()" class="btn btn-lg btn-danger">{{__('labels.back')}}</button>
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
            <img class="card-img-top"
                src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($bookDetails->book_cover) }}" alt="Book cover"
                style="border: 1px solid black; height: 200px; width: 100px;">
            <br>
            <br>

            <b class="mt-2">{{ __('labels.book_edition') }}</b> : {{ $bookDetails->book_edition }}
            <br>
            <br>
            <b>{{ __('labels.book_language') }}</b> : {{ $bookDetails->book_language }}
            <br>
            <br>
            <b>{{ __('labels.book_type') }}</b> : {{ $bookDetails->book_type }}
            <br>

            <blockquote class="blockquote mb-0">
                <p>{{ __('labels.description') }} : {{ $bookDetails->description }}</p>
                <footer class="blockquote-footer">{{ __('labels.author_name') }} : <cite
                        title="Source Title">{{ $bookDetails->author_name }}</cite></footer>
            </blockquote>
            <br>
            <h5>{{ __('labels.book_price') }}: {{ $bookDetails->book_price }}</h5>

            <button class="btn-sm btn-primary mt-2 mr-1 addToWishlistButton" id="addToWishlistButton"
                name="addToWishlistButton" value="{{ $bookDetails->id }}">
                <i class="bi bi-bookmark-check-fill "></i>{{ __('labels.add_to_wishlist_btn') }}
            </button>

            <button class="btn-sm btn-warning mt-2 mb-3 addToCartButton" id="addToCartButton" name="addToCartButton"
                value="{{ $bookDetails->id }}">
                <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.add_to_cart_btn') }}
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    
jQuery(document).ready(function($) {
    $('.addToWishlistButton').click(function() {
        // Get the value of the book ID
        var bookId = $(this).val();
        // Get the value of the authenticated user's ID
        var userId = {{ auth()->id() }};
        // Log the values to the console (you can do further processing here)

        $.ajax({
            type: 'get',
            url: 'http://localhost:8000/api/addToWishlist/' + userId + '/' + bookId,
            data: {
                'book_id': bookId,
                'user_id': userId
            },
            dataType: "json",
            success: function(data) {

                if (data['status'] == "exists") {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        title: "{{ __('messages.exists_in_wishlist') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "{{ __('messages.added_to_wishlist') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
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
    });
    $('.addToCartButton').click(function() {
        // Get the value of the book ID
        var bookId = $(this).val();
        // Get the value of the authenticated user's ID
        var userId = {{ auth()->id() }};
        // Log the values to the console (you can do further processing here)

        $.ajax({
            type: 'get',
            url: 'http://localhost:8000/api/addToCart/' + userId + '/' + bookId,
            data: {
                'book_id': bookId,
                'user_id': userId
            },
            dataType: "json",
            success: function(data) {

                if (data['status'] == "exists") {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        title: "{{ __('messages.exists_in_cart') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "{{ __('messages.added_to_cart') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
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
    });
});
@endpush