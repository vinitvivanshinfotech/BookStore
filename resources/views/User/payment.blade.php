<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Integration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Payment Integration</h2>
                <form id="paymentForm" action="{{route('user.MakePayment')}}">
                    @csrf
                    <div class="form-group">
                        <label for="total_book_price">Total Book Price</label>
                        <input type="text" class="form-control" id="book_total_price" name="book_total_price" value="{{$book_total_price}}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="total_book_qty">Total Book Quantity</label>
                        <input type="text" class="form-control" id="book_total_quantity" name="book_total_quantity" value="{{$book_total_quantity}}" readonly>
                    </div>

                    <input type="hidden" name="paymentId" value="{{$paymentId}}">
                    <input type="hidden" name="orderId" value="{{$orderId}}">
                    {{-- <input type="hidden" name="data" value="{{$data}}"> --}}
                    <input type="hidden" name="tempFilePath" value="{{$tempFilePath }}">
                    <input type="hidden" name="invoiceName" value="{{$invoiceName}}">
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
