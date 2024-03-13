@extends('Auth.User.layout')
@section('content')
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <form method="post" action="{{ route('user.update-password') }}">
        @csrf
        <h3>{{__('labels.reserPassword')}} </h3>

        @if (Session::has('error'))
            <span style="color: red;">{{ Session::get('error') }}</span>
        @endif

        <input type="hidden"  id="email" name="email" value="{{$email}}" >
        <input type="hidden"  id="passwordResetToken" name="passwordResetToken" value="{{$token}}" >
        

        <label for="password">{{ __('labels.newPassword') }}</label>
        <input type="password" placeholder="{{ __('labels.newPassword') }}" id="password" name="password"
            value="{{ old('password') }}" required>
        @if ($errors->has('password'))
            <span style="color: red;">{{ $errors->first('password') }}</span>
        @endif

        <label for="password_confirm">{{ __('labels.password_confirm') }}</label>
        <input type="password" placeholder="{{ __('labels.password_confirm') }}" id="password_confirmation"
            name="password_confirmation" value="{{ old('password_confirmation') }}">
        @if ($errors->has('password_confirm'))
            <span style="color:red;"> {{ $errors->first('password_confirm') }}
        @endif

        <button type="submit">{{ __('labels.Submit') }}</button>
       
        
    </form>
@endsection
