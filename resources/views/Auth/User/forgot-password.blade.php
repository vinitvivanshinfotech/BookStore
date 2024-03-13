@extends('Auth.User.layout')
@section('content')
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form method="post" action="{{ route('user.forgot-password-view') }}">
        @csrf
        <h3>{{__('labels.forgotPassword')}} </h3>

        @if(Session::has( 'error' ))
            <span style="color: red;">{{ Session::get('error') }}</span>
        @endif

        <label for="email">{{ __('labels.email') }}</label>
        <input type="email" placeholder="{{ __('labels.email') }}" id="email" name="email" value="{{old('email')}}"  >
        @if ($errors->has('email'))
            <span style="color: red;">{{ $errors->first('email') }}</span>
        @endif

        <button type="submit">{{__('labels.Submit')}}</button>

        <a class="mt-1" href="{{route('login')}}">{{__('login')}}</a>

    </form>
@endsection
