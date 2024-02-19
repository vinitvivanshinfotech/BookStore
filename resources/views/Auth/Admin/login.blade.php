@extends('Auth.Admin.layout')
@section('content')
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form action="{{ route('admin.login') }}" method="POST" >
        <h3>Admin Login </h3>

        <label for="email">{{__('email')}}</label>
    <input type="email" placeholder="{{__('email')}}" id="email" name="email" required>

    <label for="phone_number">{{__('phone_number')}}</label>
    <input type="tel" placeholder="{{__('phone_number')}}" id="phone_number" name="phone_number" required>

        <button>Log In</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
@endsection
