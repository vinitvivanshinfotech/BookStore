@extends('Auth.Admin.layout')
@section('content')
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <h3>{{ __('labels.admin_login') }}</h3>

        <label for="email">{{ __('labels.email') }}</label>
        <input type="email" placeholder="{{ __('labels.email') }}" id="email" name="email" >
        @if ($errors->has('email'))
            <span style="color: red;">{{ $errors->first('email') }}</span>
        @endif

        <label for="password">{{ __('labels.password') }}</label>
        <input type="password" placeholder="{{ __('labels.password') }}" id="password" name="password" >
        @if ($errors->has('password'))
            <span style="color: red;">{{ $errors->first('password') }}</span>
        @endif

        <button>{{ __('messages.login') }}</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>

