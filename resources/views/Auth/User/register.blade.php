@extends('Auth.User.layout')

<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
@section('content')
    <form method="post" action="{{ route('user.register') }}">
        @csrf
        <h3>User Register</h3>

        <div class="row">
            <div class="col">
                <label for="first_name">{{ __('labels.first_name') }}</label>
                <input type="text" placeholder="{{ __('labels.first_name') }}" id="first_name" name="first_name"
                    value="{{ old('first_name') }}">
                {{-- error message --}}
                @if ($errors->has('first_name'))
                    <span style="color:red;"> {{ $errors->first('first_name') }}
                @endif
            </div>
            <div class="col">
                <label for="last_name">{{ __('labels.last_name') }}</label>
                <input type="text" placeholder="{{ __('labels.last_name') }}" id="last_name" name="last_name"
                    value="{{ old('last_name') }}">
                @if ($errors->has('last_name'))
                    <span style="color:red;"> {{ $errors->first('last_name') }}
                @endif
            </div>
        </div>







        <label for="email">{{ __('labels.email') }}</label>
        <input type="email" placeholder="{{ __('labels.email') }}" id="email" name="email"
            value="{{ old('email') }}">
        @if ($errors->has('email'))
            <span style="color:red;"> {{ $errors->first('email') }}
        @endif

        <label for="phone_number">{{ __('labels.phone_number') }}</label>
        <input type="tel" placeholder="{{ __('labels.phone_number') }}" id="phone_number" name="phone_number"
            value="{{ old('phone_number') }}">
        @if ($errors->has('phone_number'))
            <span style="color:red;"> {{ $errors->first('phone_number') }}
        @endif


        <label for="password">{{ __('labels.password') }}</label>
        <input type="password" placeholder="{{ __('labels.password') }}" id="password" name="password"
            {{ old('password') }}>
        @if ($errors->has('password'))
            <span style="color:red;"> {{ $errors->first('password') }}
        @endif


        <label for="password_confirm">{{ __('labels.password_confirm') }}</label>
        <input type="password" placeholder="{{ __('labels.password_confirm') }}" id="password_confirmation"
            name="password_confirmation" value="{{ old('password_confirmation') }}">
        @if ($errors->has('password_confirm'))
            <span style="color:red;"> {{ $errors->first('password_confirm') }}
        @endif

        <button type="submit">{{ __('labels.register') }}</button>

        <a class="mt-1" href="{{route('login')}}">{{__('login')}}</a>

        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
@endsection
