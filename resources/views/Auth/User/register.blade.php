@extends('Auth.User.layout')

<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
@section('content')
   


    <form method="post" action="{{ route('user.register') }}">
        @csrf
        <h3>User Register</h3>

        <label for="first_name">{{ __('first_name') }}</label>
        <input type="text" placeholder="{{ __('first_name') }}" id="first_name" name="first_name"
            value="{{ old('first_name') }}">
        {{-- error message --}}
        @if ($errors->has('first_name'))
            <span style="color:red;"> {{ $errors->first('first_name') }}
        @endif


        <label for="last_name">{{ __('last_name') }}</label>
        <input type="text" placeholder="{{ __('last_name') }}" id="last_name" name="last_name"
            value="{{ old('last_name') }}">
        @if ($errors->has('last_name'))
            <span style="color:red;"> {{ $errors->first('last_name') }}
        @endif



        <label for="email">{{ __('email') }}</label>
        <input type="email" placeholder="{{ __('email') }}" id="email" name="email" value="{{ old('email') }}">
        @if ($errors->has('email'))
            <span style="color:red;"> {{ $errors->first('email') }}
        @endif

        <label for="phone_number">{{ __('phone_number') }}</label>
        <input type="tel" placeholder="{{ __('phone_number') }}" id="phone_number" name="phone_number"
            value="{{ old('phone_number') }}">
        @if ($errors->has('phone_number'))
            <span style="color:red;"> {{ $errors->first('phone_number') }}
        @endif


        <label for="password">{{ __('password') }}</label>
        <input type="password" placeholder="{{ __('password') }}" id="password" name="password" {{ old('password') }}>
        @if ($errors->has('password'))
            <span style="color:red;"> {{ $errors->first('password') }}
        @endif


        <label for="password_confirm">{{ __('password_confirm') }}</label>
        <input type="password" placeholder="password_confirm" id="password_confirmation" name="password_confirmation"
            value="{{ old('password_confirmation') }}">
        @if ($errors->has('password_confirm'))
            <span style="color:red;"> {{ $errors->first('password_confirm') }}
        @endif

        <button type="submit">Register</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
@endsection
