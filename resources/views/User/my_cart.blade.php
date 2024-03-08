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
        <div class="text-center mb-3" id="shipping-details-form-button">
                <button type="button" class="btn btn-lg btn-primary mr-5">{{ __('labels.add_shipping_details') }}<i
                        class="bi bi-play-fill ms-1"></i></button>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">

            <div class="card" id="shipping-details-div" style="width: 36rem;" style="display: none;">
                <div class="card-body"  >
                    
                    <form method="POST" action="{{ route('user.placeOrder') }}" id="shipping-details-form" >
                        <h3 class="card-title">{{ __('labels.shipping_info') }}</h3>
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="first_name">{{ __('labels.first_name') }}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') != null ? old('first_name') : $user['first_name'] }}"
                                    required>
                                @if ($errors->has('first_name'))
                                    <span style="color: red;">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name">{{ __('labels.last_name') }}</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') != null ? old('last_name') : $user['last_name'] }}">
                                @if ($errors->has('last_name'))
                                    <span style="color: red;">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('labels.email') }}</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') != null ? old('email') : $user['email'] }}" required>
                            @if ($errors->has('email'))
                                <span style="color: red;">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone_number">{{ __('labels.phone_number') }}</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                value="{{ old('phone_number') != null ? old('phone_number') : $user['phone_number'] }}"
                                required>
                            @if ($errors->has('phone_number'))
                                <span style="color: red;">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="address">{{ __('labels.address') }}</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            @if ($errors->has('address'))
                                <span style="color: red;">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="pincode">{{ __('labels.pincode') }}</label>
                                <input type="number" class="form-control" id="pincode" name="pincode" required>
                                @if ($errors->has('pincode'))
                                    <span style="color: red;">{{ $errors->first('pincode') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="city">{{ __('labels.city') }}</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                                @if ($errors->has('city'))
                                    <span style="color: red;">{{ $errors->first('city') }}</span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="state">{{ __('labels.state') }}</label>
                            <select class="form-control" name="state" id="name">
                                <option value="" selected disabled hidden>Select State</option>
                                @foreach(config('constant.STATES') as $key)
                                    <option value="{{$key}}">{{$key}}</option>
                                @endforeach
                            </select>
                            </select>
                            @if ($errors->has('state'))
                                <span style="color: red;">{{ $errors->first('state') }}</span>
                            @endif
                        </div>  

                        <div class="form-group">
                            <label>{{ __('labels.payment_mode') }}</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_mode" id="online-payment"
                                    value="online">
                                <label class="form-check-label" for="online_payment">{{ __('labels.online') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_mode" id="offline-payment"
                                    value="cod" checked>
                                <label class="form-check-label" for="offline_payment">{{ __('labels.offline') }}</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="goBack()"
                                class="btn btn-lg btn-danger">{{ __('labels.back') }}</button>
                            
                            <button type="button" class="btn btn-primary" id="submit-shipping-details">{{ __('labels.place_order') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-centre text-dark">
        <h1 class=""> {{__('messages.empty_cart')}}</h1>
    </div>
@endif
@endsection

@push('scripts')
    $('#shipping-details-div').hide();   
    
    $(document).on('click','#shipping-details-form-button',function(){
        $('#shipping-details-div').show();   
        $(this).hide();
    });

    $(document).on('click','#submit-shipping-details',function(e){
        e.preventDefault();
        if($('#offline-payment').is(':checked')){
            $('#shipping-details-form').submit();
        }else if($('#online-payment').is(':checked')){
            {{-- alert($('#online-payment').val()); --}}
            {{-- $('#shipping-details-form').submit(); --}}
        }
    });

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
