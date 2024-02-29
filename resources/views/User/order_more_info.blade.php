@extends('User.userLayout.layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="text-primary">{{ __('labels.order_id') }}: {{ $data[0]['id'] }} </h1>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ __('labels.order_placed_on') }} :
                {{ \Carbon\Carbon::parse($data[0]['created_at'])->format('d-m-Y') }}</h5>

            <h6>{{ __('labels.total_price') }} : {{ $data[0]['book_total_price'] }}</h6>
            <h6>{{ __('labels.total_quantity') }} : {{ $data[0]['book_total_quantity'] }}</h6>


            <table class="table table-bordered mt-3 mb-3">
                <thead>
                    <tr>
                        <th scope="col">{{ __('labels.book_name') }}</th>
                        <th scope="col">{{ __('labels.book_edition') }}</th>
                        <th scope="col">{{ __('labels.book_price') }}</th>
                        <th scope="col">{{ __('labels.book_discount') }}</th>
                        <th scope="col">{{ __('labels.quantity') }}</th>
                        <th scope="col">{{ __('labels.give_review') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalDiscount = 0;
                        $totalPrice = 0;
                    @endphp
                    @foreach ($data as $bookInfo)
                        <tr>
                            <td>{{ $bookInfo['book_name'] }}</td>
                            <td>{{ $bookInfo['book_edition'] }}</td>
                            <td>{{ $bookInfo['book_price'] }}</td>
                            <td>{{ $bookInfo['book_discount'] }}</td>
                            <td>{{ $bookInfo['book_quantity'] }}</td>
                            <td>
                                <button type="button" class="btn btn-primary addBookReview" data-toggle="modal"
                                    data-target="#addBookReview" data-whatever="{{$bookInfo['book_details_id']}}"><i class="bi bi-pencil-square"></i></button>
                            </td>
                        </tr>
                        @php
                            $totalPrice += $bookInfo['book_price'] * $bookInfo['book_quantity'];
                            $totalDiscount += $bookInfo['book_discount'] * $bookInfo['book_quantity'];
                        @endphp
                    @endforeach
                    <tr>
                        <td><b class="text-primary">{{ __('labels.total') }}</b></td>
                        <td> - </td>
                        <td><b class="text-primary">{{ $totalPrice }}</b></td>
                        <td><b class="text-primary">{{ $totalDiscount }}</b></td>
                        <td><b class="text-primary">{{ $data[0]['book_total_quantity'] }}</b></td>
                    </tr>


                </tbody>
            </table>


            <button onclick="goBack()" class="btn btn-lg btn-danger">{{ __('labels.back') }}</button>

            <button type="button" class="btn btn-light text-right" disabled><b>{{ __('labels.payable_amount') }} :
                    {{ $data[0]['book_total_price'] }}</b></button>

        </div>
        <div class="card-footer text-muted">
            <h3>{{ __('labels.status') }} : {{ $data[0]['order_status'] }} </h3>
        </div>
    </div>
@endsection
<div class="modal fade" id="addBookReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('labels.rate_us')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="">


        <div class="modal-body">
            <div class="star-rating">
                <input type="hidden" id="book_ratings" name="book_ratings" value="0">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
              </div>
            
            <div class="form-group">
              <label for="message-text" class="col-form-label">{{__('labels.your_review')}}</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary closeModel" data-dismiss="modal">Close</button>
          <button type="button" class="btn review btn-primary">{{__('labels.submit_review')}}</button>
        </div>
        

      </div>
    </div>
  </div>
@push('scripts')


var bookId;
var rating;
var review;
var userId = {{ Auth::user()->id}}

// Retrieve book_id from data-whatever attribute when modal is shown
$('.addBookReview').on('click', function () {
     bookId = $(this).data('whatever');
});

$('.star').click(function () {
    var value = $(this).data('value');
    $('#book_ratings').val(value);
    $('.star').removeClass('text-warning');
    $(this).prevAll('.star').addBack().addClass('text-warning');
});



// AJAX request when review button is clicked
$(document).on('click', '.review',function () {
    rating = $('#book_ratings').val();
    review = $('#message-text').val();
    
    
    // Perform AJAX request to submit review
    $.ajax({
        type: 'post',
        url: '/api/addRatings',
        data: {
            'user_id' : userId,
            'rating': rating,
            'review': review,
            'book_id': bookId,
        },
        dataType: "json",
        success: function(data) {
            if(data['status']=='success'){
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Thank you for  your feedback!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }else if(data['status']=='fail'){ 
                Swal.fire({
                    position: "top-end",
                    icon: "warning",
                    title: "Something went wrong",
                    showConfirmButton: false,
                    timer: 1500
                });
            }else if(data['status']=='NULL'){
                Swal.fire({
                    position: "top-end",
                    icon: "warning",
                    title: "Please add review",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function(err) {
            console.log(err);
        }
    });

    $('#book_ratings').val('');
    $('#message-text').val('');
    $('.star').removeClass('text-warning');
    $('.closeModel').click();
});
@endpush



