<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>

    </style>

    @include('User.userLayout.cdn')

    <title>User</title>


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>

            <form class="form-inline my-2 mr-3 my-lg-0" method="get" action="{{ route('user.watchlist') }}">
                @csrf
                <button class="btn-sm btn-primary " type="submit" id="seeWatchlist" name="seeWatchlist" value="">
                    <i class="bi bi-bookmark-check-fill mr-1"></i>{{ __('labels.see_wishlist_btn') }}<i
                        id="watchlistCount"></i>
                </button>
            </form>

            <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('user.cart') }}">
                @csrf
                <button class="btn-sm btn-warning " type="submit" id="seeCart" name="seeCart" value="">
                    <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.see_cart_btn') }}<i id="cartCount"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-transparant">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        

                        <li class="nav-item">
                            <a href="{{ route('user.showBooks') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-clipboard-check"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('labels.see_books') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.myOrders') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-card-list"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('labels.my_orders') }}</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4 text-dark">
                        
                        <button class="btn btn-outline-dark"><span class="d-none d-sm-inline mx-1 text-primary"> <i
                                    class="fs-4 bi-people "> </i>
                                <b class="text-primary">
                                </b></span>
                            <hr>
                            <a class="dropdown-item text-primary" href="">Profile</a>
                            <hr>
                            <a class="dropdown-item text-primary" onclick="retun showConfirmButton()"
                                href="{{ route('user.logout') }}">Sign out</a>
                        </button>

                        </a>


                    </div>
                </div>
            </div>
            <div class="col py-3">

                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('failure'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('failure') }}
                    </div>
                @endif

                @yield('content')


            </div>
        </div>
    </div>




</body>

<script>
    jQuery(document).ready(function($) {
        @stack('scripts')

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

                    var dynamicClass= data['book_id']
                    
                    if (data['status'] == "exists") {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "{{ __('messages.quantity_incresed') }}",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.addedSpan.'+dynamicClass).html('Quantity incresed');
                        $('.addToCartButton.'+dynamicClass).prop("disabled", true);
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "{{ __('messages.added_to_cart') }}",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.addedSpan.'+dynamicClass).html('Added to cart');
                        $('.addToCartButton.'+dynamicClass).prop("disabled", true);
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
    });


    function showConfirmButton() {
        let c = confirm("Are you Sure want to logout...?");
        if (c) {
            return true;
        } else {
            return false;
        }
    }

    function goBack() {
        window.history.back();
    }


    // Data Tables 
    let myWatchlist = new DataTable('#myWatchlist');
    let myCart = new DataTable('#myCart');
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>

</html>
