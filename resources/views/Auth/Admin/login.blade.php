@extends('Auth.Admin.layout')
@section('content')
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<form action="{{ route('admin.login') }}" method="POST">
    @csrf
    <h3>{{__('messages.admin_login')}}</h3>

    <label for="email">{{__('messages.email')}}</label>
    <input type="email" placeholder="{{__('messages.email')}}" id="email" name="email" required>
    @error('email')
    <span class="text-danger">{{$message}}</span>
    @enderror

    <label for="password">{{__('messages.password')}}</label>
    <input type="password" placeholder="{{__('messages.password')}}" id="password" name="password" required>
    @error('password')
    <span class="text-danger">{{$message}}</span>
    @enderror

    <button>{{__('messages.login')}}</button>
    <div class="social">
        <div class="go"><i class="fab fa-google"></i> Google</div>
        <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
    </div>
</form>
@endsection