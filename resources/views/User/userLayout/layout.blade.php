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
  
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;" >
        <a class="navbar-brand mr-4" href="#">Book Store</a>
        <button class="navbar-toggler ms-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="dropdown navbar-nav">
                <button class=" text-right btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Options
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li class="nav-item">
                        <a href="{{ route('user.showBooks') }}" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-clipboard-check"></i> <span class="ms-1 d-none d-sm-inline">{{ __('labels.see_books') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.myOrders') }}" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-card-list"></i> <span class="ms-1 d-none d-sm-inline">{{ __('labels.my_orders') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{auth()->user()->first_name}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{route('user.profile')}}">{{__('labels.profiel')}}</a>
                        <a class="dropdown-item" href="{{ route('user.logout') }}">{{__('labels.logout')}}</a>
                    </div>
                </li>
            </ul>
        </div>
        
    </nav>
    

    <div class="container-fluid" >
        <div class="row flex-nowrap">
            {{-- <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-transparent" >
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100" style="background-color: #9e9e9e">
                    
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="{{ route('user.showBooks') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-clipboard-check"></i> <span class="ms-1 d-none d-sm-inline">{{ __('labels.see_books') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.myOrders') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-card-list"></i> <span class="ms-1 d-none d-sm-inline">{{ __('labels.my_orders') }}</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                   
                </div>
            </div> --}}
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
