@extends('Auth.User.layout')
@section('content')
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form method="post" action="{{ route('user.login') }}">
        @csrf
        <h3>User Login </h3>

        <label for="email">{{ __('email') }}</label>
        <input type="email" placeholder="{{ __('email') }}" id="email" name="email" required>
        @if ($errors->has('email'))
            <span style="color: red;">{{ $errors->first('email') }}</span>
        @endif

        <label for="password">{{ __('password') }}</label>
        <input type="password" placeholder="{{ __('password') }}" id="password" name="password" required>
        @if ($errors->has('password'))
            <span style="color: red;">{{ $errors->first('password') }}</span>
        @endif

        <button type="submit">Log In</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
@endsection