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


                            <div class="card mt-2 mb-2 ms-4 me-4" style="width: 18rem;">

                                <img class="card-img-top"
                                    src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($book->book_cover) }}"
                                    alt="Book cover" height="150px" width="200px" >
                                <hr>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $book->book_name }}</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{ __('labels.author_name') }} :
                                            {{ $book->author_name }}</li>
                                        <li class="list-group-item">{{ __('labels.book_price') }} : {{ $book->book_price }}
                                        </li>
                                        <li class="list-group-item">

                                            <form action="{{route('user.bookDetails')}}" method="POST">
                                                @csrf
                                                <input type="hidden" id="book_id" name="book_id"
                                                    value="{{ $book->id }}">
                                                <button type="submit" class="btn-sm btn-secondary" id="showBookDetails"
                                                    name="showBookDetails" value="">
                                                    <i
                                                        class="bi bi-eye-fill mr-1"></i>{{ __('labels.more') }}
                                                </button>
                                            </form>




                                            <button class="btn-sm btn-primary mt-2 mr-1 addToWishlistButton"
                                                id="addToWishlistButton" name="addToWishlistButton"
                                                value="{{ $book->id }}">
                                                <i
                                                    class="bi bi-bookmark-check-fill "></i>{{ __('labels.add_to_wishlist_btn') }}
                                            </button>

                                            <button class="btn-sm btn-warning mt-2 mb-3 addToCartButton"
                                                id="addToCartButton" name="addToCartButton" value="{{ $book->id }}">
                                                <i class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.add_to_cart_btn') }}
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
