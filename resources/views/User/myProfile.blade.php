@extends('User.userLayout.layout')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card" style="width: 36rem;">
            <div class="card-body">
                <form method="post" action="{{ route('user.updateProfile') }}">
                    @csrf
                    <h3>Edit Profile</h3>
                    <div class="row">
                        <div class="col">
                            <label for="first_name" class="form-label">{{ __('labels.first_name') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('labels.first_name') }}" id="first_name" name="first_name"
                                value="@if(old('first_name')) {{old('first_name')}} @else {{$user->first_name}} @endif">
                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="last_name" class="form-label">{{ __('labels.last_name') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('labels.last_name') }}" id="last_name" name="last_name"
                                value="@if(old('last_name')) {{old('last_name')}} @else {{$user->last_name}} @endif">
                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label for="email" class="form-label">{{ __('labels.email') }}</label>
                            <input type="email" class="form-control" placeholder="{{ __('labels.email') }}" id="email" name="email"
                                value="@if(old('email')) {{old('email')}} @else {{$user->email}} @endif">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="phone_number" class="form-label">{{ __('labels.phone_number') }}</label>
                            <input type="tel" class="form-control" placeholder="{{ __('labels.phone_number') }}" id="phone_number" name="phone_number"
                                value="@if(old('phone_number')) {{old('phone_number')}} @else {{$user->phone_number}} @endif">
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{$user->id}}">
                   
                    <button type="submit" class="btn btn-primary mt-3">{{__('labels.update')}}</button>

                </form>

                <a href="{{route('user.showBooks')}}">
                    <div class="text-right mb-3">
                        <button class="btn btn-lg btn-danger">{{__('labels.back')}}</button>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
