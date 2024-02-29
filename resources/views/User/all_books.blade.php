@extends('User.userLayout.layout')
@section('content')
    <div class="container-fluid">
        <table class="table ">
            <tbody>
                @foreach ($books as $book)
                    @if ($loop->index % 3 == 0)
                        <tr>
                    @endif
                    <td>


                        <div class="card mt-2 mb-2 ms-4 me-4" style="width: 18rem;">

                            <img class="card-img-top"
                                src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($book->book_cover) }}"
                                onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTUUcQuoOAi8EgqOQ6epycAwp8T9WaxN7IkA&usqp=CAU';"
                                alt="Image not fount" height="150px" width="200px">
                            <hr>
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->book_name }}</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b class="text-primary">{{ __('labels.author_name') }} : </b>
                                        {{ $book->author_name }}</li>
                                    <li class="list-group-item"><b class="text-primary">{{ __('labels.book_price') }} : </b>{{ $book->book_price }} <i>   </i>
                                        <b class="text-primary ms-3">{{ __('labels.book_discount') }} : </b>
                                        {{ $book->book_discount }}

                                    <li class="list-group-item">
                                        <span class="text-success {{$book->id}}"></span>
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ route('user.bookDetails') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" id="book_id" name="book_id"
                                                        value="{{ $book->id }}">
                                                    <button type="submit" class="btn-sm btn-secondary" id="showBookDetails"
                                                        name="showBookDetails" value="">
                                                        <i class="bi bi-eye-fill mr-1"></i>{{ __('labels.more') }}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <button class="btn-sm btn-primary  addToWishlistButton"
                                                    id="addToWishlistButton" name="addToWishlistButton"
                                                    value="{{ $book->id }}">
                                                    <i
                                                        class="bi bi-bookmark-check-fill "></i>{{ __('labels.add_to_wishlist_btn') }}
                                                </button>
                                            </div>
                                            <div class="col">
                                                <button class="btn-sm btn-warning   addToCartButton" id="addToCartButton"
                                                    name="addToCartButton" value="{{ $book->id }}">
                                                    <i
                                                        class="bi bi-cart-plus-fill mr-1"></i>{{ __('labels.add_to_cart_btn') }}
                                                </button>
                                            </div>
                                        </div>
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

@push('scripts')
@endpush
