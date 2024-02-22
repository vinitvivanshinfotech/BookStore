@extends('User.userLayout.layout')
@section('content')
    <div class="container-fluid">
        <table class="table ">
            <thead>
                {{-- <tr>
                    <th scope="col">{{ __('labels.book_cover') }}</th>
                    <th scope="col">{{ __('labels.book_name') }}</th>
                    <th scope="col">{{ __('labels.author_name') }}</th>
                    <th scope="col">{{ __('labels.view_details') }}</th>
                    <th scope="col">{{ __('labels.add_to_wishlist') }}</th>
                    <th scope="col">{{ __('labels.add_to_cart') }}</th>

                </tr> --}}
            </thead>
            <tbody>
                @foreach ($books as $book)
                    @if ($loop->index % 3 == 0)
                        <tr>
                    @endif
                    <td>
                        <div class="card" style="width: 18rem;">

                            <img class="card-img-top" src="{{ asset('storage/uploads/books_cover/' . $book->book_cover) }}"
                                alt="Card image cap" height="150px" width="200px">
                                <hr>
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->book_name }}</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{__('labels.author_name')}} : {{$book->author_name}}</li>
                                    <li class="list-group-item">{{__('labels.book_price')}} : {{$book->book_price}}</li>
                                    <li class="list-group-item">
                                        <button class="btn-sm btn-primary mt-2 mr-3 addToWishlistButton" id="addToWishlistButton" name="addToWishlistButton" value="{{$book->id}}">
                                            <i class="bi bi-bookmark-check-fill mr-1"></i>Save
                                        </button>

                                        <button class="btn-sm btn-warning mt-2 mb-3 addToCartButton" id="addToCartButton" name="addToCartButton" value="{{$book->id}}">
                                            <i class="bi bi-cart-plus-fill mr-1"></i>Cart
                                        </button>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </td>

                    @if (($loop->index + 1) % 3 == 0 || $loop->last)
                        </tr>
                    @endif
                @endforeach

            </tbody>
            
        </table>
        {{ $books->links() }}

        
    </div>


    


@endsection
