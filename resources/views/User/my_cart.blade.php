@extends('User.userLayout.layout')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('failure'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('failure') }}
        </div>
    @endif

    <h1>{{ __('labels.see_cart_btn') }}</h1>

    <div class="container-fluid">
        <table class="table table-bordered" id="myWishlist" name="myWishlist">
            <thead>
                <tr>
                    <th scope="col">{{ __('labels.book_cover') }}</th>
                    <th scope="col">{{ __('labels.book_name') }}</th>
                    <th scope="col">{{ __('labels.author_name') }}</th>
                    <th scope="col">{{ __('labels.book_price') }}</th>
                    <th scope="col">{{ __('labels.quantity') }}</th>
                    <th scope="col">{{ __('labels.remover') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>

                        <td><img class="card-img-top mt-1 mb-1 ms-1 mr-1"
                                src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($item['book_details']['book_cover']) }}"
                                alt="Card image cap" height="100px" width="50px"></td>
                        <td>{{ $item['book_details']['book_name'] }}</td>
                        <td>{{ $item['book_details']['author_name'] }}</td>
                        <td>{{ $item['book_details']['book_price'] }}</td>
                        <td>1</td>
                        <td>
                            <form action="{{ route('user.removeFromCart') }}" method="POST">
                                @csrf
                                <input type="hidden" id="cart_id" name="cart_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-sm btn-danger mt-2 mb-3 " id="" name="">
                                    <i class="bi bi-trash3-fill mr-1"></i>{{ __('labels.remove_from_list') }}
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
