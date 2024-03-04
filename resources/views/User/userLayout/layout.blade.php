<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token"  content="{{ csrf_token() }}">

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

            {{-- <form class="form-inline my-2 mr-3 my-lg-0" method="get" action="{{ route('user.watchlist') }}">
                <button class="btn-sm btn-primary " type="submit" id="seeWatchlist" name="seeWatchlist" value="">
                    <i class="bi bi-bookmark-check-fill mr-1"></i>{{ __('labels.see_wishlist_btn') }}<i
                        id="watchlistCount"></i>
                </button>
            </form>

            <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('user.cart') }}">
                <button class="btn-sm btn-warning " type="submit" id="seeCart" name="seeCart" value="">
                    <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.see_cart_btn') }}<i id="cartCount"></i>
                </button>
            </form> --}}
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

        

    });

    function goBack() {
        window.history.back();
    }
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
