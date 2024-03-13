@extends('Auth.User.layout')
@section('content')
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form method="post" action="{{ route('user.login') }}">
        @csrf
        <h3>User Login </h3>

        @if (Session::has('error'))
            <span style="color: red;">{{ Session::get('error') }}</span>
        @endif

        <label for="email">{{ __('labels.email') }}</label>
        <input type="email" placeholder="{{ __('labels.email') }}" id="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span style="color: red;">{{ $errors->first('email') }}</span>
        @endif

        <label for="password">{{ __('labels.password') }}</label>
        <input type="password" placeholder="{{ __('labels.password') }}" id="password" name="password"
            value="{{ old('password') }}" required>
        @if ($errors->has('password'))
            <span style="color: red;">{{ $errors->first('password') }}</span>
        @endif

        <button type="submit">{{ __('labels.login') }}</button>
        <a class="mt-1" href="{{ route('register') }}">
            <button type="button">{{ __('labels.register') }}</button>
        </a>

        <a class="mt-1" href="{{ route('user.forgot-password-view') }}">{{ __('labels.forgotPassword') }}</a>
        


        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
@endsection
