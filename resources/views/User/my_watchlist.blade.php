@extends('User.userLayout.layout')
@section('content')

<h1>{{__('labels.see_wishlist_btn')}}</h1>


    <div class="container-fluid">
        <table class="table table-bordered" id="myWishlist" name="myWishlist">
            <thead>
                <tr>
                    <th scope="col">{{ __('labels.book_cover') }}</th>
                    <th scope="col">{{ __('labels.book_name') }}</th>
                    <th scope="col">{{ __('labels.author_name') }}</th>
                    <th scope="col">{{ __('labels.book_price') }}</th>
                    <th scope="col">{{ __('labels.book_discount') }}</th>
                    <th scope="col">{{ __('labels.remover') }}</th>
                    <th scope="col">{{ __('labels.add_to_cart') }}</th>
                </tr>
            </thead>
            <tbody>
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
                            <form action="{{route('user.removeFromWatchlist')}}" method="POST">
                                @csrf
                                <input type="hidden" id="wishlist_id" name="wishlist_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-sm btn-danger mt-2 mb-3 " id=""
                                    name="" >
                                    <i class="bi bi-trash3-fill mr-1"></i>{{ __('labels.remove_from_list') }}
                                </button>
                            </form>
                        </td>
                        <td><button class="btn-sm btn-warning mt-2 mb-3 addToCartButton" id="addToCartButton"
                                name="addToCartButton" value="{{ $item['book_details']['id'] }}">
                                <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.add_to_cart_btn') }}
                            </button></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    
jQuery(document).ready(function($) {
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
