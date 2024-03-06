@extends('User.userLayout.layout')
@section('content')
<div class="d-flex justify-content-end mb-2">
   
    <form class="form-inline" method="get" action="{{ route('user.cart') }}">
        <button class="btn btn-sm btn-warning" type="submit" id="seeCart" name="seeCart" value="">
            <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.see_cart_btn') }}<i id="cartCount"></i>
        </button>
    </form>
</div>

    <div class="myWishlistWrapper" id="myWishlistWrapper">
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
                
            </tbody>
        </table>
    </div>
</div>
        <div class="text-centre text-dark" id="empty-wishlist" style="display: none;">
            <h1 class=""> {{__('messages.empty_wishlist')}}</h1>
        </div>
@endsection

@push('scripts')
    {{-- let table = new DataTable('#myWishlist'); --}}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#myWishlist').DataTable({
        processing : true,
        serverSide :true,
        
        ajax:{
            url:'{{route('user.myWishlistAjax')}}',
            type:"POST",
            
        },
        
        'lengthMenu': [5,10,25,50,100],
        
        columns:[
            {
                data : 'book_cover',
                "searchable": false,
                "orderable": false
            },
            {
                data : 'book_name',
               
            },
            {
                data : 'author_name',
                
            },
            {
                data : 'book_price',
                
            },
            {
                data : 'book_discount',
               
            },
            {
                data : 'more',
                "searchable": false,
                "orderable": false
            },
            {
                data : 'remove',
                "searchable": false,
                "orderable": false
            },
            {
                data : 'add_to_cart',
                "searchable": false,
                "orderable": false
            },
        ]
    })



    $.ajax({
        type: 'get',
        url: '/api/getWatchlistCartData',
        data: {
            'user_id': {{ auth()->user()->id }}
        },
        dataType: "json",
        success: function(data) {
            if(data['wishlistCount']==0){
                $('#empty-wishlist').show();
                $('#myWishlistWrapper').hide();
            }
            $('#watchlistCount').html("").html('(' + data['wishlistCount'] + ')');
            $('#cartCount').html("").html('(' + data['cartCount'] + ')');

        },
        error: function(err) {

        }

    });

    $(document).on('click', '.addToCartButton', function() {

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
