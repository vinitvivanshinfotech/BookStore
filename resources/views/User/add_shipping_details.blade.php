@extends('User.userLayout.layout')

@php
 
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card" style="width: 36rem;">
                <div class="card-body">
                    <h3 class="card-title">{{ __('labels.shipping_info') }}</h3>

                    <form method="POST" action="{{ route('user.placeOrder') }}">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="first_name">{{ __('labels.first_name') }}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') != null ? old('first_name') : $user['first_name'] }}"
                                    required>
                                @if ($errors->has('first_name'))
                                    <span style="color: red;">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name">{{ __('labels.last_name') }}</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') != null ? old('last_name') : $user['last_name'] }}">
                                @if ($errors->has('last_name'))
                                    <span style="color: red;">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('labels.email') }}</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') != null ? old('email') : $user['email'] }}" required>
                            @if ($errors->has('email'))
                                <span style="color: red;">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone_number">{{ __('labels.phone_number') }}</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                value="{{ old('phone_number') != null ? old('phone_number') : $user['phone_number'] }}"
                                required>
                            @if ($errors->has('phone_number'))
                                <span style="color: red;">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="address">{{ __('labels.address') }}</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            @if ($errors->has('address'))
                                <span style="color: red;">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="pincode">{{ __('labels.pincode') }}</label>
                                <input type="number" class="form-control" id="pincode" name="pincode" required>
                                @if ($errors->has('pincode'))
                                    <span style="color: red;">{{ $errors->first('pincode') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="city">{{ __('labels.city') }}</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                                @if ($errors->has('city'))
                                    <span style="color: red;">{{ $errors->first('city') }}</span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="state">{{ __('labels.state') }}</label>
                            <select class="form-control" name="state" id="name">
                                <option value="" selected disabled hidden>Select State</option>
                                @foreach(config('constant.STATES') as $key)
                                    <option value="{{$key}}">{{$key}}</option>
                                @endforeach
                            </select>
                            </select>
                            @if ($errors->has('state'))
                                <span style="color: red;">{{ $errors->first('state') }}</span>
                            @endif
                        </div>  

                        <div class="form-group">
                            <label>{{ __('labels.payment_mode') }}</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_mode" id="online_payment"
                                    value="online">
                                <label class="form-check-label" for="online_payment">{{ __('labels.online') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_mode" id="offline_payment"
                                    value="cod" checked>
                                <label class="form-check-label" for="offline_payment">{{ __('labels.offline') }}</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="goBack()"
                                class="btn btn-lg btn-danger">{{ __('labels.back') }}</button>
                            
                            <button type="submit" class="btn btn-primary">{{ __('labels.place_order') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
